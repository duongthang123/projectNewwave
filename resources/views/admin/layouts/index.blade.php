<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('admin.includes.head')
  @vite(['resources/js/app.js'])
  <style>
    .alert-fixed-top-right {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050; /* Sử dụng một giá trị z-index lớn hơn giá trị của modal */
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('admin.includes.navbar')

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      {{-- <img src="#" alt="" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      {{-- <span class="brand-text font-weight-light ">Hello</span> --}}
    </a>

    <!-- Sidebar -->
    @include('admin.includes.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>

	<div class="container mt-3">
		<div id="notification" class="alert alert-success alert-dismissible fade alert-fixed-top-right invisible">

		</div>
	</div>

</div>
<!-- ./wrapper -->

@include('admin.includes.footer')

</body>
</html>
