<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::where('is_subscribed', 1)->latest('id')->paginate(10);

        return view('Backend.pages.subscriber.index')->with('subscribers', $subscribers);
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        return redirect()->back()->with('success', 'Subscriber deleted successfully');
    }
}
