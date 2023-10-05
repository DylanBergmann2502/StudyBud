@props(['topics', 'roomCount'])

<div class="topics">
    <div class="topics__header">
    <h2>Browse Topics</h2>
    </div>
    <ul class="topics__list">
    <li>
        <a href="{{ route('home') }}" class="active">All <span>{{ $roomCount }}</span></a>
    </li>
    @foreach($topics as $topic)
        <li>
            <a href="/?q={{ $topic->name }}">{{ $topic->name }}<span>{{ $topic->rooms()->count() }}</span></a>
        </li>
    @endforeach
    </ul>
    <a class="btn btn--link" href="{{ route('topics.index') }}">
    More
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
        <title>chevron-down</title>
        <path d="M16 21l-13-13h-3l16 16 16-16h-3l-13 13z"></path>
    </svg>
    </a>
</div>
