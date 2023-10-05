<x-layout>
    <main class="layout layout--3">
        <div class="container">
            <!-- Topics Start -->
            <x-topics-component :topics="$topics" :roomCount="$roomCount" />
            <!-- Topics End -->

            <!-- Room List Start -->
            <div class="roomList">
                <div class="mobile-menu">
                    <form class="header__search">
                        <label>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                            <title>search</title>
                            <path
                            d="M32 30.586l-10.845-10.845c1.771-2.092 2.845-4.791 2.845-7.741 0-6.617-5.383-12-12-12s-12 5.383-12 12c0 6.617 5.383 12 12 12 2.949 0 5.649-1.074 7.741-2.845l10.845 10.845 1.414-1.414zM12 22c-5.514 0-10-4.486-10-10s4.486-10 10-10c5.514 0 10 4.486 10 10s-4.486 10-10 10z"
                            ></path>
                        </svg>
                        <input placeholder="Search for posts" />
                        </label>
                    </form>
                    <div class="mobile-menuItems">
                        <a class="btn btn--main btn--pill" href="{{ route('topics.index') }}">Browse Topics</a>
                        <a class="btn btn--main btn--pill" href="#">Recent Activities</a>
                    </div>
                </div>
                <div class="roomList__header">
                    <div>
                        <h2>Study Room</h2>
                        <p>{{ $rooms->count() }} Rooms available</p>
                    </div>
                    @auth
                    <a class="btn btn--main" href="{{ route('rooms.create') }}">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                        <title>add</title>
                        <path
                            d="M16.943 0.943h-1.885v14.115h-14.115v1.885h14.115v14.115h1.885v-14.115h14.115v-1.885h-14.115v-14.115z"
                        ></path>
                        </svg>
                        Create Room
                    </a>
                    @endauth
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

