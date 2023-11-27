<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Toko Fajri Craft : Panel Admin</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin-assets/plugins/dropzone/min/dropzone.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin-assets/plugins/summernote/summernote.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">
	
	<link rel="icon" href="{{asset('admin-assets/img/logofajrii.png')}}">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<meta name="csrf-token" content="{{csrf_token()}}">
	
	
</head>

<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Right navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>					
			</ul>
			<div class="navbar-nav pl-2">
				<!-- <ol class="breadcrumb p-0 m-0 bg-white">
					<li class="breadcrumb-item active">Dashboard</li>
				</ol> -->
			</div>
			
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
						<span class="mr-2">{{ Auth::user()->name }}</span>
						<img src="{{ asset(Auth::user()->profile_image ? 'storage/' . Auth::user()->profile_image : 'admin-assets/img/avatar5.png') }}" class='img-circle elevation-2' width="40" height="40" alt="admin-profile">
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
						<h4 class="h4 mb-0"><strong>{{Auth::guard('admin')->user()->name}}</strong></h4>
						<div class="mb-3">{{Auth::guard('admin')->user()->email}}</div>
						<div class="dropdown-divider"></div>
						<a href="{{route('admin.profile')}}" class="dropdown-item">
							<i class="fas fa-user-edit mr-2"></i> Profil								
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-lock mr-2"></i> Ubah Password
						</a>
						<div class="dropdown-divider"></div>
						<a href="{{route('admin.logout')}}" class="dropdown-item text-danger">
							<i class="fas fa-sign-out-alt mr-2"></i> Logout							
						</a>							
					</div>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		@include('admin.layout.sidebar')
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			
		@yield('content')
			
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			
			<strong>Copyright &copy; 2023 Toko Fajri Craft All rights reserved.
			</footer>
			
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>


		<script src="{{asset('admin-assets/plugins/dropzone/min/dropzone.min.js')}}"></script>

		<script src="{{asset('admin-assets/plugins/summernote/summernote.min.js')}}"></script>

		<!-- AdminLTE for demo purposes -->
		<script src="{{asset('admin-assets/js/demo.js')}}"></script>

		{{-- Script sweet alert --}}
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

		{{-- Script Toastr --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		
		{{-- Script agar nama file saat ingin mengubah profile image admin tertera di form upload  --}}
		@yield('customFile-Js')
		
		@yield('previewImage-Js')
		
		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(document).ready(function(){
				$(".summernote").summernote({
					height: 250
				});
			})
		</script>

		@yield('delete-Js')

		@yield('createJs')

		@yield('editJs')

	</body>
	</html>