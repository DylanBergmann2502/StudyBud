<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ url('assets/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ url('css/style.css')}}" />
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>StudyBuddy - Find study partners around the world!</title>
  </head>

  <body>
    @include('partials._navbar')

    {{ $slot }}

    <x-flash-message />

    <script src="{{ url('js/script.js') }}"></script>
  </body>
</html>
