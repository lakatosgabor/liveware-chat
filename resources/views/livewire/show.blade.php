<div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <button onclick="showNewChatBox()">új üzenet</button>
                </div>
                <div class="card-body chatbox p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($users as $cg)
                            <a href="{{ route('inbox.show', $cg->chat_group_id) }}" class="text-dark link">
                                <li class="list-group-item" wire:click="getUser({{ $cg->chat_group_id }})" id="user_{{ $cg->chat_group_id }}">
                                    <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png">
                                    @if($cg->created_by == auth()->id())
                                        {{$cg->group_name}}
                                    @else   
                                        {{$cg->name}}
                                    @endif
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                @if($user->created_by == auth()->id())
                    {{$user->group_name}}
                @else   
                    {{$user->name}}
                @endif
                </div>
                <div class="card-body message-box" wire:poll.10ms="mountComponent()">
                    @if(filled($messages))
                        @foreach($messages as $message)
                            <div class="single-message @if($message->created_by !== auth()->id()) received @else sent @endif">
                                <p class="font-weight-bolder my-0">{{ $message->name }}</p>
                                <p class="my-0">{{ $message->message }}</p>
                                <small class="text-muted w-100">Sent <em>{{ $message->created_at }}</em></small>
                            </div>
                        @endforeach
                    @else
                        No messages to show
                    @endif
                </div>
                <div class="card-footer">
                    <form wire:submit.prevent="SendMessage" enctype="multipart/form-data">
                        <div wire:loading wire:target='SendMessage'>
                            Sending message . . . 
                        </div>
                        <div wire:loading wire:target="file">
                            Uploading file . . .
                        </div>
                        @if($file)
                                <div class="mb-2">
                                   You have an uploaded file <button type="button" wire:click="resetFile" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Remove {{ $file->getClientOriginalName() }}</button>
                                </div>
                            @else
                                No file is uploaded.
                            @endif
                        <div class="row">
                            <div class="col-md-7">
                                <input wire:model="message" class="form-control input shadow-none w-100 d-inline-block" placeholder="Type a message" @if(!$file) required @endif>
                            </div>
                            @if(empty($file))
                                <div class="col-md-1">
                                    <button type="button" class="border" id="file-area">
                                        <label>
                                            <i class="fa fa-file-upload"></i>
                                            <input type="file" wire:model="file">
                                        </label>
                                    </button>
                                </div>
                                @endif
                            <div class="col-md-4">
                                <button class="btn btn-primary d-inline-block w-100"><i class="far fa-paper-plane"></i> Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="new_chat_box" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Chat</h5>
      </div>
      <div class="modal-body">
        <input type="text" id="new_chat_username" placeholder="Kezd el begépleni a cimzett vagy a csoport nevét">
      </div>
      <div class="modal-footer">
        <button onclick="createNewChat()" class="btn btn-primary">Üzenet küldése</button>
      </div>
    </div>
  </div>
</div>
