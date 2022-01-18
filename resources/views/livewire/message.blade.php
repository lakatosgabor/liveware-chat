<div>
    <div class="row justify-content-center" wire:poll="mountComponent()">
        <div class="col-md-4" wire:init>
            <div class="card">
                <div class="card-header">
                    <button onclick="showNewChatBox()">új üzenet</button>
                </div>
                <div class="card-body chatbox p-0">
                    <ul class="list-group list-group-flush" wire:poll="render">
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
                    @if(isset($chat_group_id)) {{ $chat_group_id }}
                        Select a user to see the chat
                        <i class="fa fa-circle text-success"></i> We are online
                    @else
                        Messages
                    @endif
                </div>
                <div class="card-body message-box">
                    <span>Válassz beszélgetést.</span>
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
