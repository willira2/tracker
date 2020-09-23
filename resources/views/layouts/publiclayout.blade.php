<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
   		@include('layouts.partials.head')
 	</head>
	<body class="bg-gradient-primary">
		  <div class="container">
		    <!-- Outer Row -->
		    <div class="row justify-content-center">
		      @yield('content')
		    </div>
		  </div>
		@include('layouts.partials.footer-scripts')
 	</body>
</html>