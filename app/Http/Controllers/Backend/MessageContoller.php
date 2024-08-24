<?php

namespace App\Http\Controllers\Backend;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Jobs\MessageReplyJob;
use App\Mail\MessageReplyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageContoller extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $data['messages'] = ContactUs::latest()->orderBy('is_read', 'asc')->paginate(10);

        foreach ($data['messages'] as $message) {
            $message->is_read = 1;
            $message->save();
        }

        return view('Backend.pages.message.index')->with('data', $data);
    }

    // destroy
    public function destroy($id)
    {
        try {
            $message = ContactUs::find($id);
            if(!$message) {
                return redirect()->back()->with('error', 'Message not found');
            }
            $message->delete();

            return redirect()->back()->with('success', 'Message deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong ' . $e->getMessage());
        }
    }

    // reply
    public function reply(Request $request, $id)
    {
        try {
            $message = ContactUs::find($id);
            if(!$message) {
                return redirect()->back()->with('error', 'Message not found');
            }

            $message->response = $request->response;
            $message->is_resolved = 1;
            $message->resolved_at = now();
            $message->resolved_by = Auth::user()->id;
            $message->save();

            // dd($message);

            // MessageReplyJob::dispatch($message);
            Mail::to($message->email)
                ->send(new MessageReplyMail($message));

            return redirect()->back()->with('success', 'Message replied successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong ' . $e->getMessage());
        }
    }
}
