<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use \App\Models\Message;
use \App\Models\Chat_group;

class InboxController extends Controller
{

    
    public function index() {
        // Show just the users and not the admins as well
        $chat_groups = Chat_group::join('chat_users', 'chat_groups.chat_group_id', '=', 'chat_users.chat_group_id')
        ->join('users', 'chat_groups.created_by', '=', 'users.id')
        ->orWhere('chat_users.user_id', '=', auth()->id())
        ->orWhere('chat_groups.created_by', '=', auth()->id())
        ->orderBy('chat_groups.chat_group_id', 'DESC')->get();

        return view('home', [
            'chat_groups' => $chat_groups
        ]);
        
    }

    public function show($id) {
        $chat_groups = Chat_group::join('chat_users', 'chat_groups.chat_group_id', '=', 'chat_users.chat_group_id')
        ->join('users', 'chat_groups.created_by', '=', 'users.id')
        ->orWhere('chat_users.user_id', '=', auth()->id())
        ->orWhere('chat_groups.created_by', '=', auth()->id())
        ->orderBy('chat_groups.chat_group_id', 'DESC')->get();

        $user = Chat_group::join('chat_users', 'chat_groups.chat_group_id', '=', 'chat_users.chat_group_id')
        ->join('users', 'chat_groups.created_by', '=', 'users.id')
        ->orWhere('chat_users.user_id', '=', auth()->id())
        ->orWhere('chat_groups.created_by', '=', auth()->id())
        ->orWhere('chat_groups.chat_group_id', '=', $id)
        ->orderBy('chat_groups.chat_group_id', 'DESC')->first();
        
        return view('show', [
            'chat_groups' => $chat_groups,
            'checked_chat_group_id' => $id,
            'user' => $user
        ]);
    }

}
