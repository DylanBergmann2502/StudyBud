<x-layout>
    <main class="profile-page layout layout--3">
        <div class="container">
          <!-- Topics Start -->
          <x-topics-component :topics="$topics" :roomCount="$roomCount" />
          <!-- Topics End -->

          <!-- Room List Start -->
          <div class="roomList">
            <div class="profile">
              <div class="profile__avatar">
                <div class="avatar avatar--large active">
                  <img src="https://randomuser.me/api/portraits/men/11.jpg" />
                </div>
              </div>
              <div class="profile__info">
                <h3>{{ $user->name }}</h3>
                <p>{{'@' . $user->name }}</p>
                @if($user->is(auth()->user()))
                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn--main btn--pill">Edit Profile</a>
                @endif
              </div>
              <div class="profile__about">
                <h3>About</h3>
                <p>
                  {{ $user->bio }}
                </p>
              </div>
            </div>

            <div class="roomList__header">
              <div>
                <h2>Study Rooms Hosted by {{ $user->name }}</a>
                </h2>
              </div>
            </div>
            <x-feed-component :rooms="$rooms" />
          </div>
          <!-- Room List End -->

          <!-- Activities Start -->
          <x-activity-component :messages="$messages" />
          <!-- Activities End -->
        </div>
    </main>
</x-layout>
