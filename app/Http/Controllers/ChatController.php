<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Customer side: List messages for their own conversation
    public function customerIndex()
    {
        $conversation = Conversation::where('customer_id', auth()->id())->first();
        $messages = $conversation ? $conversation->messages()->with('sender')->get() : collect();
        
        return view('chat.customer', compact('messages', 'conversation'));
    }

    // Staff side: Inbox
    public function staffInbox()
    {
        $conversations = Conversation::with(['customer', 'messages' => function($q) {
            $q->latest()->take(1);
        }])->orderBy('last_message_at', 'desc')->get();

        return view('chat.inbox', compact('conversations'));
    }

    // Staff side: Show specific chat
    public function staffShow(Conversation $conversation)
    {
        $conversations = Conversation::with(['customer', 'messages' => function($q) {
            $q->latest()->take(1);
        }])->orderBy('last_message_at', 'desc')->get();

        $messages = $conversation->messages()->with('sender')->get();
        
        // Mark messages as read
        $conversation->messages()->where('sender_id', '!=', auth()->id())->where('is_read', false)->update(['is_read' => true]);

        return view('chat.inbox', compact('conversations', 'conversation', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'conversation_id' => 'nullable|exists:conversations,id'
        ]);

        $conversationId = $request->conversation_id;

        // If customer sending first time, create conversation
        if (!$conversationId && auth()->user()->role === 'customer') {
            $conversation = Conversation::firstOrCreate(
                ['customer_id' => auth()->id()],
                ['last_message_at' => now()]
            );
            $conversationId = $conversation->id;
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => auth()->id(),
            'body' => $request->body,
        ]);

        Conversation::find($conversationId)->update(['last_message_at' => now()]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message->load('sender'),
                'formatted_date' => $message->created_at->format('M d, Y g:i A')
            ]);
        }

        return back();
    }
}
