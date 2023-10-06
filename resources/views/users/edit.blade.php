<x-layout>
    <main class="update-account layout">
        <div class="container">
            <div class="layout__box">
                <div class="layout__boxHeader">
                    <div class="layout__boxTitle">
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 32 32">
                                <title>arrow-left</title>
                                <path
                                    d="M13.723 2.286l-13.723 13.714 13.719 13.714 1.616-1.611-10.96-10.96h27.625v-2.286h-27.625l10.965-10.965-1.616-1.607z">
                                </path>
                            </svg>
                        </a>
                        <h3>Edit your profile</h3>
                    </div>
                </div>
                <div class="layout__body">
                    <form class="form" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- <div class="form__group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="text" placeholder="E.g. john@email.com" value="{{ $user->email }}" />
                            @error('message')
                                <p class="error-message">{{$message}}</p>
                            @enderror
                        </div> --}}

                        {{-- <div class="form__group">
                            <label for="profile_pic">Avatar</label>
                            <input id="profile_pic" name="profile_pic" type="file" />
                        </div> --}}

                        <div class="form__group">
                            <label for="name">Username</label>
                            <input id="name" name="name" type="text" placeholder="E.g. John doe" value="{{ $user->name }}" />
                            @error('name')
                                <p class="error-message">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" placeholder="Write about yourself...">{{ $user->bio }}</textarea>
                            @error('bio')
                                <p class="error-message">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form__action">
                            <a class="btn btn--dark" href="{{ back() }}">Cancel</a>
                            <button class="btn btn--main" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </main>
</x-layout>
