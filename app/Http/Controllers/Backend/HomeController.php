<?php

namespace App\Http\Controllers\Backend;

use App\Models\Book;
use App\Models\ToDo;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $array = $this->getDashboardData('day'); // Default to day

        // Fetch orders and their amounts grouped by month
        $ordersByMonths = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(grand_total) as total_amount')
                        ->whereBetween('created_at', [now()->subMonths(6), now()->addDay()])
                        ->whereNotIn('status', ['pending', 'declined', 'canceled', 'refunded'])
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

        $orderByDate = Order::selectRaw('DATE(created_at) as date, SUM(grand_total) as total_amount')
                        ->whereBetween('created_at', [now()->subDays(6), now()->addDay()])
                        ->whereNotIn('status', ['pending', 'declined', 'canceled', 'refunded'])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();

        // dd($orders);

        // Prepare data for charts
        $orderDates = $orderByDate->pluck('date')->map(function($date) {
            return date('Y-m-d', strtotime($date)); // Format as needed
        });
        $orderAmountsByDate = $orderByDate->pluck('total_amount');

        $orderMonths = $ordersByMonths->pluck('month');
        $orderAmounts = $ordersByMonths->pluck('total_amount');

        // Prepare data for sales chart
        $salesData = Transaction::selectRaw('SUM(amount) as total_amount, gateway')
                                ->groupBy('gateway')
                                ->get();

        $salesLabels = $salesData->pluck('gateway');
        $salesAmounts = $salesData->pluck('total_amount');

        // get from yesterday
        // due date can be null
        $toDos = ToDo::where(function($query) {
            $query->where('due_date', '>=', now()->subDay(2)->startOfDay())
                ->orWhereNull('due_date');
        })
        ->orderBy('due_date')->limit(10)->get();

        // Pass data to the view
        return view('Backend.pages.home.index', compact('array','toDos','orderDates','orderAmountsByDate', 'orderMonths', 'orderAmounts', 'salesLabels', 'salesAmounts'));
    }

    public function getStats(Request $request)
    {
        $period = $request->input('period');
        $array = $this->getDashboardData($period);

        return view('Backend.pages.home.partials.stats', ['array' => $array])->render();
    }

    private function getDashboardData($period)
    {
        return [
            'newOrders' => Order::whereTimeframe('created_at', $period)->count(),
            'totalSales' => Order::whereNotIn('status', ['pending', 'declined', 'canceled', 'refunded'])
                                ->whereTimeframe('created_at', $period)
                                ->sum('grand_total'),
            'userRegistrations' => User::whereTimeframe('created_at', $period)->count(),
            'totalBooks' => Book::whereTimeframe('created_at', $period)->count(),
        ];
    }

    public function addToDo(Request $request)
    {
        $toDo = ToDo::create($request->all());
        return response()->json($toDo);
    }

    public function updateToDo(Request $request, ToDo $toDo)
    {
        $toDo->update($request->all());
        return response()->json($toDo);
    }

    public function toggleStatus(ToDo $toDo)
    {
        $toDo = ToDo::find($toDo->id);
        Log::info($toDo);
        $toDo->status == 'pending' ? $toDo->status = 'completed' : $toDo->status = 'pending';
        $toDo->save();
        return response()->json($toDo);
    }

    public function deleteToDo(ToDo $toDo)
    {
        $toDo->delete();
        return response()->json(['success' => true]);
    }

}
