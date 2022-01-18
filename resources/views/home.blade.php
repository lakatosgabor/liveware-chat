@extends('layouts.app')

@section('content')
<div class="container">
    @livewire('message', ['users' => $chat_groups])
</div>
@endsection
