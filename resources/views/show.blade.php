@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
        @livewire('show', ['users' => $chat_groups, 'checked_chat_group_id' => $checked_chat_group_id, 'user' => $user])
        </div>
    </div>
@endsection
