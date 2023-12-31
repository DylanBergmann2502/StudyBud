@props(['messages'])

<div class="activities">
    <div class="activities__header">
        <h2>Recent Activities</h2>
    </div>

    @foreach($messages as $message)
    <div class="activities__box">
        <div class="activities__boxHeader roomListRoom__header">
            <a href="{{ route('users.show', ['user' => $message->user->id ]) }}" class="roomListRoom__author">
            <div class="avatar avatar--small">
                <img src="https://randomuser.me/api/portraits/women/11.jpg" />
            </div>
            <p>
                {{ '@' . $message->user->name }}
                <span>{{ $message->created_at->diffForHumans() }}</span>
            </p>
            </a>
            <div class="roomListRoom__actions">
            <a href="#">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                <title>remove</title>
                <path
                    d="M27.314 6.019l-1.333-1.333-9.98 9.981-9.981-9.981-1.333 1.333 9.981 9.981-9.981 9.98 1.333 1.333 9.981-9.98 9.98 9.98 1.333-1.333-9.98-9.98 9.98-9.981z"
                ></path>
                </svg>
            </a>
            </div>
        </div>
        <div class="activities__boxContent">
            <p>replied to post “<a href="{{ route('rooms.show', ['room' => $message->room->id ]) }}">{{ $message->room->name }}</a>”</p>
            <div class="activities__boxRoomContent">
                {{ Str::limit($message->body, 50) }}
            </div>
        </div>
    </div>
    @endforeach
</div>
