<?php

namespace App\Http\Livewire;

use \App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads; 
use \App\Models\Chat_msg;
use \App\Models\Chat_group;

class Message extends Component
{
    use WithFileUploads;

    public $message = '';
    public $users;
    public $checked_chat_group_id;
    public $messages;
    public $file;
    public $admin;

    public function render()
    {
        return view('livewire.message', [
            'users' => $this->users,
            'admin' => $this->admin
        ]);
    }

    public function mount()
    {
        $this->mountComponent();
    }

    public function mountComponent() {
        $this->users = Chat_group::join('chat_users', 'chat_groups.chat_group_id', '=', 'chat_users.chat_group_id')
        ->join('users', 'chat_groups.created_by', '=', 'users.id')
        ->orWhere('chat_users.user_id', '=', auth()->id())
        ->orWhere('chat_groups.created_by', '=', auth()->id())
        ->orderBy('chat_groups.chat_group_id', 'DESC')->get();

    }

    public function SendMessage() {
        $new_message = new Chat_msg();
        $new_message->chat_group_id = $this->checked_chat_group_id;
        $new_message->message = $this->message;
        $new_message->created_by = auth()->id();

        $new_message->save();

        // Clear the message after it's sent
        $this->reset(['message']);
        $this->file = '';
    }

    public function getUser($chat_group_id) 
    {
        $this->clicked_chat_group = Chat_group::find($chat_group_id);
        $this->messages = \App\Models\Chat_msg::where('chat_group_id', $this->clicked_chat_group)->get();
    }

    public function resetFile() 
    {
        $this->reset('file');
    }

}
