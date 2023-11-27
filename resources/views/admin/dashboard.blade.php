@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Dashboard</h1>
			</div>
			<div class="col-sm-6">
				
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 col-6">							
				<div class="small-box card bg-info">
					<div class="inner">
						<h3>150</h3>
						<p>Total Pesanan</p>
					</div>
					<div class="icon">
						<i class="fas fa-shopping-cart"></i>
					</div>
					<a href="#" class="small-box-footer text-dark">More Info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			<div class="col-lg-4 col-6">							
				<div class="small-box card bg-success">
					<div class="inner">
						<h3>510</h3>
						<p>Total Pelanggan</p>
					</div>
					<div class="icon">
						<i class="fas fa-user"></i>
					</div>
					<a href="#" class="small-box-footer text-dark">More Info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			<div class="col-lg-4 col-6">							
				<div class="small-box card bg-warning">
					<div class="inner">
						<h3>Rp 1.000.000</h3>
						<p>Total Penjualan</p>
					</div>
					<div class="icon">
						<i class="fas fa-coins"></i> 
					</div>
					<a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
				</div>
			</div>
		</div>
	</div>					
	<!-- /.card -->
</section>
<!-- /.content -->
@endsection


{{-- @section('customJs')

<script>
	console.log("hello")
</script>

@endsection --}}