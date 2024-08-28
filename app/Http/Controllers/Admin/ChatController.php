<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatRequest;

class ChatController extends Controller
{
    public function index() 
    {
        return view('admin.chat.index');
    }

    public function messageRecieved(ChatRequest $request)
    {
        $user = $request->user()->load('student');
        $image = $user->student->avatar_url;
        broadcast(new MessageSent($user, $request->message, $image));
        return response()->json('message broadcast');
    }
}
