<x-layout>
    <main class="create-room layout">
        <div class="container">
          <div class="layout__box">
            <div class="layout__boxHeader">
              <div class="layout__boxTitle">
                <a href="{{ route('rooms.show', ['room' => $room]) }}">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                    <title>arrow-left</title>
                    <path
                      d="M13.723 2.286l-13.723 13.714 13.719 13.714 1.616-1.611-10.96-10.96h27.625v-2.286h-27.625l10.965-10.965-1.616-1.607z">
                    </path>
                  </svg>
                </a>
                <h3>Edit Study Room</h3>
              </div>
            </div>
            <div class="layout__body">
              <form class="form" action="{{ route('rooms.update', ['room' => $room->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form__group">
                    <label for="topic">Topic</label>
                    <input required type="text" name="topic" id="topic" list="topic-list" value="{{ $room->topic->name }}" />
                    <datalist id="topic-list">
                      <select id="topic">
                        <option value="">Select your topic</option>
                        @foreach ($topics as $topic)
                        <option value={{ $topic->name }}>{{ $topic->name }}</option>
                        @endforeach
                      </select>
                    </datalist>
                    @error('topic')
                    <p class="error-message">{{$message}}</p>
                    @enderror
                </div>

                <div class="form__group">
                  <label for="name">Room Name</label>
                  <input
                    id="name"
                    name="name"
                    type="text"
                    placeholder="E.g. Mastering Python + Django"
                    value="{{ $room->name }}"
                  />
                  @error('name')
                    <p class="error-message">{{$message}}</p>
                  @enderror
                </div>

                <div class="form__group">
                  <label for="description">Room Description</label>
                  <textarea name="description" id="description" placeholder="Write about your study group..." >{{ $room->description }}</textarea>
                  @error('description')
                    <p class="error-message">{{$message}}</p>
                  @enderror
                </div>
                <div class="form__action">
                  <a class="btn btn--dark" href="{{ route('rooms.show', ['room' => $room]) }}">Cancel</a>
                  <button class="btn btn--main" type="submit">Update Room</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </main>
</x-layout>
