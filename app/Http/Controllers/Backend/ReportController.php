<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\OrderItems;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function dailySales($year, $month)
    {
        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        // Fetch credit and debit sales
        $transactions = Transaction::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date,
                                                SUM(amount) as total_amount,
                                                type')
            ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
            ->groupBy('date', 'type')
            ->get()
            ->groupBy('date');

        // Prepare data for view
        $sales = [];
        foreach ($transactions as $date => $types) {
            $sales[$date] = [
                'credit' => $types->where('type', 'credit')->sum('total_amount'),
                'debit' => $types->where('type', 'debit')->sum('total_amount')
            ];
        }

        // Prepare month and navigation
        $currentMonth = $start->format('F Y');
        $previousMonth = $start->copy()->subMonth()->format('Y/m');
        $nextMonth = $start->copy()->addMonth()->format('Y/m');

        return view('Backend.pages.report.daily_sale', [
            'year' => $year,
            'month' => $month,
            'sales' => $sales,
            'currentMonth' => $currentMonth,
            'previousMonth' => $previousMonth,
            'nextMonth' => $nextMonth
        ]);
    }

    public function monthlySales($year)
    {
        // Prepare months
        $months = range(1, 12);

        // Fetch sales data
        $sales = [];
        foreach ($months as $month) {
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $creditSales = Transaction::selectRaw('SUM(amount) as total_amount')
                ->where('type', 'credit')
                ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
                ->first()
                ->total_amount ?? 0;

            $debitSales = Transaction::selectRaw('SUM(amount) as total_amount')
                ->where('type', 'debit')
                ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
                ->first()
                ->total_amount ?? 0;

            $sales[$month] = [
                'credit' => $creditSales,
                'debit' => $debitSales,
                'total' => $creditSales + $debitSales
            ];
        }

        // Prepare month names and navigation
        $currentYear = $year;
        $previousYear = $year - 1;
        $nextYear = $year + 1;

        return view('Backend.pages.report.monthly_sales', [
            'year' => $year,
            'sales' => $sales,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'nextYear' => $nextYear
        ]);
    }

    public function bestSeller()
    {
        // Fetch the top-selling books
        $bestSellers = OrderItems::select('book_id', Book::raw('SUM(quantity) as total_sold'))
            ->groupBy('book_id')
            ->orderBy('total_sold', 'desc')
            ->with('book') // Assuming you have a relationship defined on OrderItem model
            ->take(10) // Limit to top 10 best sellers
            ->get();

        return view('Backend.pages.report.best_seller', [
            'bestSellers' => $bestSellers
        ]);
    }

    public function bestSellingAuthors()
    {
        // Fetch the top-selling books grouped by author
        $bestSellingAuthors = OrderItems::with('book.author')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('users', 'books.author_id', '=', 'users.id')
            ->select(
                'users.id as author_id',
                DB::raw('CONCAT(users.first_name, " ", users.last_name) as author_name'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        return view('Backend.pages.report.best_selling_authors', [
            'bestSellingAuthors' => $bestSellingAuthors
        ]);
    }

    public function salesReport($year, $month = null)
    {
        // If month is null, it's a yearly report
        if ($month === null) {
            // Fetch yearly data
            $salesData = $this->getYearlySalesData($year);
            $transactionData = $this->getYearlyTransactionData($year);
            $orderCount = $this->getYearlyOrderCount($year);
            $view = 'Backend.pages.report.sales_report_yearly';
        } else {
            // Fetch monthly data
            $salesData = $this->getMonthlySalesData($year, $month);
            $transactionData = $this->getMonthlyTransactionData($year, $month);
            $orderCount = $this->getMonthlyOrderCount($year, $month);
            $view = 'Backend.pages.report.sales_report_monthly';
        }

        return view($view, compact('salesData', 'transactionData', 'orderCount', 'year', 'month'));
    }

    private function getYearlySalesData($year)
    {
        return DB::table('orders')
            ->select(
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('SUM(discount_amount) as total_discount'),
                DB::raw('SUM(coupon_amount) as total_coupon_discount'),
                DB::raw('SUM(shipping_amount) as total_shipping'),
                DB::raw('SUM(grand_total) as grand_total'),
                DB::raw('SUM(paid_amount) as total_paid'),
                DB::raw('SUM(due_amount) as total_due'),
                DB::raw('SUM(refund_amount) as total_refund'),
                DB::raw('SUM(profit_amount) as total_profit')
            )
            ->whereYear('created_at', $year)
            ->where('status', '!=', 'canceled')
            ->first();
    }

    private function getMonthlySalesData($year, $month)
    {
        return DB::table('orders')
            ->select(
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('SUM(discount_amount) as total_discount'),
                DB::raw('SUM(coupon_amount) as total_coupon_discount'),
                DB::raw('SUM(shipping_amount) as total_shipping'),
                DB::raw('SUM(grand_total) as grand_total'),
                DB::raw('SUM(paid_amount) as total_paid'),
                DB::raw('SUM(due_amount) as total_due'),
                DB::raw('SUM(refund_amount) as total_refund'),
                DB::raw('SUM(profit_amount) as total_profit')
            )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', '!=', 'canceled')
            ->first();
    }

    private function getYearlyTransactionData($year)
    {
        return DB::table('transactions')
            ->select(
                DB::raw('SUM(amount) as total_transactions'),
                DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) as total_credits'),
                DB::raw('SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) as total_debits')
            )
            ->whereYear('billed_at', $year)
            ->first();
    }

    private function getMonthlyTransactionData($year, $month)
    {
        return DB::table('transactions')
            ->select(
                DB::raw('SUM(amount) as total_transactions'),
                DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) as total_credits'),
                DB::raw('SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) as total_debits')
            )
            ->whereYear('billed_at', $year)
            ->whereMonth('billed_at', $month)
            ->first();
    }

    private function getYearlyOrderCount($year)
    {
        return DB::table('orders')
            ->whereYear('created_at', $year)
            ->count();
    }

    private function getMonthlyOrderCount($year, $month)
    {
        return DB::table('orders')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
    }

    public function showMonthlyReport($year, $month)
    {
        return $this->salesReport($year, $month);
    }

    public function showYearlyReport($year)
    {
        return $this->salesReport($year);
    }
}
