<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Dashboard</title>

<!-- Custom fonts for this template-->
<link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}"
	rel="stylesheet" type="text/css">
	
<link
	href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
	rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
@livewireStyles
<!-- Scripts -->
<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
<script src="{{ asset('/js/app.js') }}" defer></script>
<link
	href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
	rel="stylesheet" id="bootstrap-css">
<script
	src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
<link
	href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
	rel="stylesheet" />

<script
	src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<x-sidebar />
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<x-navbar />
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">{{$slot}}</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; Eduvice <?=date('Y')?></span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top"> <i
		class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to
					end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button"
						data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="login.html">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
	<script
		src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

	<!-- Core plugin JavaScript-->
	<script
		src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

	<!-- Custom scripts for all pages-->
	<script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>

	<!-- Page level plugins -->
	<script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}"></script>

	<!-- Page level plugins -->
	<script
		src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
	<script
		src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

	<!-- Page level custom scripts -->
	<script src="{{asset('admin/js/demo/datatables-demo.js')}}"></script>

	<!-- Page level custom scripts -->
	<script src="{{asset('admin/js/demo/chart-area-demo.js')}}"></script>
	<script src="{{asset('admin/js/demo/chart-pie-demo.js')}}"></script>

	<script src="{{asset('admin/js/demo/chart-bar-demo.js')}}"></script>
	@livewireScripts
	@stack('scripts')
</body>

</html>