<x-admin-layout> <!-- Page Heading -->
<section class="breadcrumbSection">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="h3 text-gray-800">Area Of Interest</h1>				
		</div>
		<div class="col-lg-6">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Area Of Interest</li>
				</ol>
			</nav>
		</div>
	</div>
</section>
<!-- <h1 class="h3 mb-2 text-gray-800">Area Of Interest</h1> -->
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4 commonListing">
	<!-- <div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Area Of Interest</h6>
	</div> -->
	<div class="card-body">
		<div class=" text-right add-btn mb-4">
			<a href="{{route('admin.areaofinterest.create')}}" class="btn mb-2 addBtn"><i class="fa fa-plus"></i> Add</a>
		</div>
		<livewire:areaofinterest-index />

	</div>
</div>
</x-admin-layout>