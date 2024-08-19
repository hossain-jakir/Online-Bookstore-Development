<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderController extends MainController
{
    public function index(Request $request){
        $data = parent::frontendItems($request);

        $user = User::find(auth()->user()->id);
        if(!$user){
            return redirect()->route('home');
        }
        $data['user'] = $user;
        $data['user']['image'] = ServeImage::image($user->image, 'grid');
        // Retrieve the authenticated user's orders
        $data['orders'] = Order::with(['orderItems', 'orderItems.book', 'user', 'address', 'shippingAddress', 'coupon', 'deliveryMethod'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // dd($orders);

        // Return the view with the orders
        return view('Frontend.Profile.order')->with('data', $data);
    }

    public function show(Request $request, $id, $order_number)
    {
        try {
            // Fetch additional data for the frontend
            $data = parent::frontendItems($request);

            // Get the authenticated user
            $user = User::find(auth()->user()->id);
            if (!$user) {
                return redirect()->route('home');
            }

            // Attach user image
            $data['user'] = $user;
            $data['user']['image'] = ServeImage::image($user->image, 'grid');

            // Retrieve the order and its related data
            $order = Order::with(['orderItems.book', 'user', 'address', 'shippingAddress', 'coupon', 'deliveryMethod'])
                ->where('user_id', auth()->id()) // Ensure the order belongs to the authenticated user
                ->where('order_number', $order_number) // Also validate using order number
                ->findOrFail($id);

            // Generate images for books in order items
            foreach ($order->orderItems as $item) {
                $item->book->image = ServeImage::image($item->book->image, 'grid');
            }

            // Return the view with the order details
            return view('Frontend.Profile.order_details', compact('order', 'data'));

        } catch (Exception $e) {
            // Handle unauthorized access or errors
            session()->flash('error', 'You are not authorized to view this order.');
            return redirect()->route('profile.orders')->withErrors($e->getMessage());
        }
    }

    public function trackOrder(Request $request, $id, $order_number)
    {
        try {
            // Fetch additional data for the frontend
            $data = parent::frontendItems($request);

            // Get the authenticated user
            $user = User::find(auth()->user()->id);
            if (!$user) {
                return redirect()->route('home');
            }

            // Attach user image
            $data['user'] = $user;
            $data['user']['image'] = ServeImage::image($user->image, 'grid');

            // Retrieve the specific order with related tracking data
            $order = Order::with(['tracks'])
                ->where('user_id', Auth::id())
                ->where('id', $id)
                ->where('order_number', $order_number)
                ->firstOrFail();


            // Calculate the progress width based on the shipping status
            $progressWidth = $this->getProgressWidth($order->shipping_status);

            // Pass data to the view
            return view('Frontend.Profile.order_tracking', compact('order', 'progressWidth', 'data'));
        } catch (Exception $e) {
            // Handle errors, e.g., order not found
            session()->flash('error', 'Order not found.');
            return redirect()->route('profile.orders')->withErrors($e->getMessage());
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

    public function invoice(Request $request, $id, $order_number)
    {
        try {
            // Fetch additional data for the frontend
            $data = parent::frontendItems($request);

            // Get the authenticated user
            $user = User::find(auth()->user()->id);
            if (!$user) {
                return redirect()->route('home');
            }

            // Attach user image
            $data['user'] = $user;
            $data['user']['image'] = ServeImage::image($user->image, 'grid');

            // Retrieve the specific order with related data
            $order = Order::with(['orderItems.book', 'user', 'address', 'shippingAddress', 'coupon', 'deliveryMethod'])
                ->where('user_id', auth()->id())
                ->where('id', $id)
                ->where('order_number', $order_number)
                ->firstOrFail();

            // Generate images for books in order items
            foreach ($order->orderItems as $item) {
                $item->book->image = ServeImage::image($item->book->image, 'grid');
            }

            // Return the view with the order invoice details
            return view('Frontend.Profile.order_invoice', compact('order', 'data'));

        } catch (Exception $e) {
            // Handle unauthorized access or errors
            session()->flash('error', 'You are not authorized to view this invoice.');
            return redirect()->route('profile.orders')->withErrors($e->getMessage());
        }
    }


}
