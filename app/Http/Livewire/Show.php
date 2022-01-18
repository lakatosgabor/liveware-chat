<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use \App\Models\Chat_msg;
use \App\Models\Chat_group;

class Show extends Component
{
    use WithFileUploads;

    public $users;
    public $messages = '';
    public $sender;
    public $message;
    public $file;
    public $checked_chat_group_id;
    public $user;

    public function render()
    {
        return view('livewire.show', [
            'users' => $this->users,
            'messages' => $this->messages,
            'checked_chat_group_id' => $this->checked_chat_group_id,
            'user' => $this->user
        ]);
    }

    public function mountComponent() {
        $this->messages = Chat_msg::join('users', 'chat_msgs.created_by', '=', 'users.id')
        ->where('chat_group_id', $this->checked_chat_group_id)
        ->orderBy('chat_msgs.created_at', 'desc')
        ->get();

        $this->users = Chat_group::join('chat_users', 'chat_groups.chat_group_id', '=', 'chat_users.chat_group_id')
        ->join('users', 'chat_groups.created_by', '=', 'users.id')
        ->orWhere('chat_users.user_id', '=', auth()->id())
        ->orWhere('chat_groups.created_by', '=', auth()->id())
        ->orderBy('chat_groups.chat_group_id', 'DESC')->get();

        $this->user = Chat_group::join('chat_users', 'chat_groups.chat_group_id', '=', 'chat_users.chat_group_id')
        ->join('users', 'chat_groups.created_by', '=', 'users.id')
        ->orWhere('chat_users.user_id', '=', auth()->id())
        ->orWhere('chat_groups.created_by', '=', auth()->id())
        ->orWhere('chat_groups.chat_group_id', '=', $this->checked_chat_group_id)
        ->orderBy('chat_groups.chat_group_id', 'DESC')->first();
    }

    public function mount()
    {
        return $this->mountComponent();
    }

    public function SendMessage() {
        $new_message = new Chat_msg();
        $new_message->chat_group_id = $this->checked_chat_group_id;
        $new_message->message = $this->message;
        $new_message->created_by = auth()->id();
        
        $new_message->save();
        // Clear the message after it's sent
        $this->reset('message');
        $this->file = '';
    }

    public function resetFile() 
    {
        $this->reset('file');
    }

    public function uploadFile() {
        $file = $this->file->store('public/files');
        $path = url(Storage::url($file));
        $file_name = $this->file->getClientOriginalName();
        return [$path, $file_name];
    }

}
