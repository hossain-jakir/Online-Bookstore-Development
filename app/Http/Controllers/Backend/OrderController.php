<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\OrderTrack;
use App\Models\DeliveryFee;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use App\Mail\ShippingStatusMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Authorization check
        if (Gate::denies('view order')) {
            abort(403, 'Unauthorized');
        }

        // Fetch orders with optional filters and search
        $query = Order::with('user')->where('isDeleted', 'no'); // Eager load the user relationship

        // Search filter
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search . '%');
                });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $orders = $query->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('Backend.pages.order.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::with('user', 'orderItems')->findOrFail($id); // Eager load the user relationship

        foreach ($order->orderItems as $item) {
            $item->book->image = ServeImage::image($item->book->image, 'grid');
        }

        // // Authorization check
        if (Gate::denies('view order', $order)) {
            abort(403, 'You are not authorized to view this page.');
        }

        return view('Backend.pages.order.show', compact('order'));
    }


    /**
     * Show the form for editing the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::with('orderItems','shippingAddress')->findOrFail($id);
        $countries = Country::all();
        $deliveryFees = DeliveryFee::all();

        foreach ($order->orderItems as $item) {
            $item->book->image = ServeImage::image($item->book->image, 'grid');
        }

        // Authorization check
        if (Gate::denies('edit order', $order)) {
            abort(403, 'Unauthorized');
        }

        return view('Backend.pages.order.edit', compact('order', 'countries', 'deliveryFees'));
    }

    public function updateShippingAddress(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $address = $order->shippingAddress;

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'zip_code' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $update = $address->update($request->only([
            'first_name', 'last_name', 'address_line_1', 'address_line_2', 'city', 'state', 'country_id', 'zip_code', 'phone_number', 'email'
        ]));

        $update
            ? session()->flash('success', 'Shipping address updated successfully.')
            : session()->flash('error', 'Failed to update shipping address.');


        return redirect()->route('backend.order.edit', ['id' => $order->id])->with('success', 'Shipping address updated successfully.');
    }

    public function updateDeliveryFee(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'delivery_fee' => 'required|exists:delivery_fees,id'
        ]);

        // Find the selected delivery fee
        $newDeliveryFee = DeliveryFee::find($validated['delivery_fee']);
        Log::info('New delivery fee: ' . $newDeliveryFee);
        // Calculate previous delivery fee if exists
        $previousDeliveryFee = DeliveryFee::find($order->delivery_method_id)->price;
        Log::info('Previous delivery fee: ' . $previousDeliveryFee);

        $updateDueAmount = $order->due_amount + $newDeliveryFee->price - $previousDeliveryFee;

        // Update the order with the selected delivery fee
        $order->delivery_method_id = $newDeliveryFee->id;
        $order->shipping_amount = $newDeliveryFee->price;
        $order->grand_total = $order->grand_total + $newDeliveryFee->price - $previousDeliveryFee;
        $order->due_amount = $updateDueAmount;

        if ($order->due_amount <= 0) {
            $order->payment_status = 'paid';
        } else {
            $order->payment_status = 'due';
        }

        $order->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'Delivery fee updated successfully.');
    }


    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Log::info($request->all());
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|string',
            'items.*.book_id' => 'required|integer', // Ensure book_id is required
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
            'total_amount' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'coupon_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'shipping_amount' => 'nullable|numeric',
            'grand_total' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            // Update the order data
            $order->total_amount = $request->input('total_amount', 0);
            $order->discount_amount = $request->input('discount_amount', 0);
            $order->coupon_amount = $request->input('coupon_amount', 0);
            $order->tax_amount = $request->input('tax_amount', 0);
            $order->shipping_amount = $request->input('shipping_amount', 0);
            $order->grand_total = $request->input('grand_total', 0);
            $order->paid_amount = $request->input('paid_amount', 0);
            $order->due_amount = $request->input('due_amount', 0);

            if ($order->due_amount <= 0) {
                $order->payment_status = 'paid';
            } else {
                $order->payment_status = 'due';
            }

            $order->save();

            // Get existing order items IDs
            $oldItemIds = $order->orderItems()->pluck('id')->toArray();

            // Collect new item IDs for easy checking
            $newItemIds = collect($request->input('items'))->filter(function ($item) {
                return !str_starts_with($item['id'], 'new');
            })->pluck('id')->toArray();

            // Update or create order items
            foreach ($request->input('items') as $itemData) {
                if (!isset($itemData['id']) || !isset($itemData['book_id']) || !isset($itemData['quantity']) || !isset($itemData['price']) || !isset($itemData['total'])) {
                    Log::error('Missing keys in item data:', $itemData);
                    continue;
                }

                if (str_starts_with($itemData['id'], 'new')) {
                    // Create a new order item
                    $order->orderItems()->create([
                        'book_id' => $itemData['book_id'], // Ensure book_id is set
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'total' => $itemData['total'],
                    ]);
                } else {
                    // Update existing order item
                    $orderItem = $order->orderItems()->find($itemData['id']);
                    if ($orderItem) {
                        $orderItem->update([
                            'book_id' => $itemData['book_id'], // Ensure book_id is set
                            'quantity' => $itemData['quantity'],
                            'price' => $itemData['price'],
                            'total' => $itemData['total'],
                        ]);
                    }
                }
            }

            // Determine items to delete (those that are no longer in the new list)
            $itemsToDelete = array_diff($oldItemIds, $newItemIds);

            foreach ($itemsToDelete as $itemId) {
                $order->orderItems()->find($itemId)->delete();
            }

            DB::commit();
            // Return success response
            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update order. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Authorization check
        if (Gate::denies('delete order', $order)) {
            abort(403, 'Unauthorized');
        }

        $order->update(['isDeleted' => 'yes']);

        return redirect()->route('backend.order.index')->with('success', 'Order deleted successfully');
    }

    public function trackOrder(Request $request, $id)
    {
        try {

            // Retrieve the specific order with related tracking data
            $order = Order::with(['tracks'])
                ->where('id', $id)
                ->firstOrFail();


            // Calculate the progress width based on the shipping status
            $progressWidth = $this->getProgressWidth($order->shipping_status);
            // Pass data to the view
            return view('Backend.pages.order.track', compact('order', 'progressWidth'));
        } catch (Exception $e) {
            // Handle errors, e.g., order not found
            session()->flash('error', 'Order not found. Error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    private function getProgressWidth($status)
    {
                // Calculate progress width based on shipping status
        switch ($status) {
            case 'pending':
                $progressWidth = 25;
                break;
            case 'processing':
                $progressWidth = 50;
                break;
            case 'shipped':
                $progressWidth = 75;
                break;
            case 'delivered':
                $progressWidth = 100;
                break;
            case 'canceled':
                $progressWidth = 100; // Set to 100% if the order is canceled
                break;
            default:
                $progressWidth = 0;
        }

        return $progressWidth;
    }

    public function invoice(Request $request, $id)
    {
        try {
            // Retrieve the specific order with related data
            $order = Order::with(['orderItems.book', 'user', 'address', 'shippingAddress', 'coupon', 'deliveryMethod'])
                ->where('id', $id)
                ->firstOrFail();

            // Generate images for books in order items
            foreach ($order->orderItems as $item) {
                $item->book->image = ServeImage::image($item->book->image, 'grid');
            }

            $data['shop'] = Shop::first();

            // Return the view with the order invoice details
            return view('Frontend.Profile.order_invoice', compact('order', 'data'));

        } catch (Exception $e) {
            // Handle unauthorized access or errors
            session()->flash('error', 'You are not authorized to view this invoice. Error: ' . $e->getMessage());
            return redirect()->route('profile.orders')->withErrors($e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validate the request
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
            'message' => 'required|string|max:255',
        ]);

        // Update the order status
        $order->shipping_status = $request->input('status');
        $order->save();

        // Log status update in OrderTrack
        OrderTrack::create([
            'order_id' => $order->id,
            'status' => $order->shipping_status,
            'message' => $request->input('message'),
        ]);

        if($order->shipping_status == 'delivered') {
            $order->update([
                'status' => 'completed',
                'delivered_at' => now(),
            ]);
        }

        Mail::to($order->user->email)->send(new ShippingStatusMail($order, $request->input('message')));

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function applyDiscount(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $couponCode = $request->input('coupon_code');
        $discountAmount = $request->input('discount_amount');

        // Validate the request
        $request->validate([
            'coupon_code' => 'required|string',
            'discount_amount' => 'required|numeric',
        ]);

        // Check if the coupon code is valid
        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 'active')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->first();

        if (!$coupon) {
            return redirect()->route('backend.order.edit', ['id' => $id])->with('error', 'Invalid coupon code.');
        }

        // Apply discount
        $order->discount_amount = $discountAmount;
        $order->grand_total -= $discountAmount;
        $order->save();

        return redirect()->route('backend.order.edit', ['id' => $id])->with('success', 'Coupon and discount applied successfully.');
    }

}
