<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $limit = (int) request()->query('limit', 15);
        if ($limit < 1) {
            $limit = 15;
        }
        $limit = min($limit, 50);

        $messages = Message::query()
            ->latest()
            ->paginate($limit);

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
