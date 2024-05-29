<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Абонобладнання</title>
  <!-- <link rel="stylesheet" href="{{ asset('assets/css/uikit.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/uikit-rtl.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->

  <!-- Scripts -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
	<script src="{{ mix('js/app.js') }}" defer></script>
  
</head>
<body class="antialiased">
  <div id="app">
    <main style="margin-top: 0px;">
      <div>
        <!-- <h1>Welcome to VueJS!</h1> -->
        <!-- <router-view :user-id="{{ $user_id }}" :so-id="{{ $so_id }}" :uname="{{ $user_name }}"></router-view> -->
        <router-view 
          :user-id="{{ $user_id }}" :user-name="'{{ $user_name }}'" :so-id="{{ $so_id }}" :rem-id="{{ $rem_id }}" :bo-id="{{ $bo_id }}">
        </router-view>
        <!-- <example-component></example-component> -->
      </div>
    </main>
  </div>
  <script src="{{ asset('js/app-v.js') }}"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>