<?php

namespace App\Http\Controllers\Backend;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'order')->latest('id')->paginate(20);

        return view('Backend.pages.transaction.index', compact('transactions'));
    }

    public function getTransactions(){
        $transactions = Transaction::select([
            'id',
            'type',
            'gateway',
            'amount',
            'description',
            'status',
            'created_at'
        ]);

        return DataTables::of($transactions)
            // column index to the table will be from 1
            ->addIndexColumn()
            ->editColumn('type', function ($transaction) {
                return ucfirst($transaction->type);
            })
            ->editColumn('gateway', function ($transaction) {
                return ucfirst($transaction->gateway);
            })
            ->editColumn('status', function ($transaction) {
                $badgeClass = 'badge-secondary';

                if ($transaction->status == 'pending') {
                    $badgeClass = 'badge-warning';
                } elseif ($transaction->status == 'completed') {
                    $badgeClass = 'badge-success';
                } elseif ($transaction->status == 'failed') {
                    $badgeClass = 'badge-danger';
                }

                return '<span class="badge ' . $badgeClass . '">' . ucfirst($transaction->status) . '</span>';
            })
            ->editColumn('amount', function ($transaction) {
                return $transaction->currency . ' ' . number_format($transaction->amount, 2);
            })
            ->editColumn('created_at', function ($transaction) {
                return $transaction->created_at->format('d M, Y h:i A');
            })
            ->rawColumns(['status']) // allows HTML rendering for the status column
            ->make(true);
    }
}
