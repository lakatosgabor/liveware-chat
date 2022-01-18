<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Chat_group;
use \App\Models\Chat_user;

class ChatController extends Controller
{
    
    public function index(Request $request){
        if ($request->has('createNewChat')) {
            return $this->createNewChat($request);
        }
    }

    public function createNewChat($request){
        $new_chat_username = $request->input('new_chat_username'); #a kiválaszott user neve
        $new_chat_user_id = 2; #ez annak a felhasználónak az idja, akinek küldi az üzenetet
                               #ajax-al kell küldeni, majd amikor lekértük motimoron

        $createdby = auth()->id();
        $group_name = $new_chat_username;
        $new_chat_group = new Chat_group();
        $new_chat_group->created_by = $createdby;
        $new_chat_group->group_name = $group_name;
        $new_chat_group->save();

        $chat_group_id = Chat_group::select('chat_group_id')
                                   ->where('created_by', $createdby)
                                   ->orderBy('created_at', 'desc')
                                   ->first();

        $chat_users = new Chat_user();
        $chat_users -> chat_group_id = $chat_group_id->chat_group_id;
        $chat_users -> user_id = $new_chat_user_id;
        $chat_users -> save();




        return response()->json(array('type'=> 'success', 'chat_group_id' => $chat_group_id->chat_group_id), 200);
    }



}
