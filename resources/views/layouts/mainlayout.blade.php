<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
   		@include('layouts.partials.head')
 	</head>
	<body id="page-top">
		<!-- Page Wrapper -->
  		<div id="wrapper">
			@include('layouts.partials.sidebar')
			 <!-- Content Wrapper -->
		    <div id="content-wrapper" class="d-flex flex-column">

		      <!-- Main Content -->
		      <div id="content">
		      	<!-- Top Navigation -->
		      	@include('layouts.partials.topnav')
		      	<!-- Page Heading -->
				@include('layouts.partials.header')
				
				<div class="container-fluid">
		          	<!-- Content Row -->
		         	<div class="row justify-content-center">
		          		@yield('content')
		          	</div>
        		</div>

			</div>

			@include('layouts.partials.footer')
			@include('layouts.partials.footer-scripts')

		</div>
	</div>
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	@include('layouts.partials.logout-modal')

 	</body>
</html>