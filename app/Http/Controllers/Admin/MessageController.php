<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return response()->json($messages);
    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->markAsRead();
        return response()->json(['success' => true, 'message' => 'Message marked as read']);
    }

    public function markAsUnread($id)
    {
        $message = Message::findOrFail($id);
        $message->markAsUnread();
        return response()->json(['success' => true, 'message' => 'Message marked as unread']);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return response()->json(['success' => true, 'message' => 'Message deleted successfully']);
    }
}
