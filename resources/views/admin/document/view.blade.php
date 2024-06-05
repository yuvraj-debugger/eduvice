<x-admin-layout> 
<!-- Page Heading -->
<section class="breadcrumbSection mb-4">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="h3 text-gray-800">Application</h1>				
		</div>
		<div class="col-lg-6">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Application</li>
				</ol>
			</nav>
		</div>
	</div>
</section>

<!-- DataTales Example -->
<div class="card shadow mb-4">
<!-- 	<div class="card-header py-3"> -->
<!-- 		<h6 class="m-0 font-weight-bold text-primary">Application</h6> -->
<!-- 	</div> -->
	<div class="card-body">	
		<div class="row">
			<div class="col-6">
				<a href="{{route('admin.document.index')}}" class="btn mb-2 backBtn"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
		</div>
		&nbsp;
		<livewire:document-view :document_id="$id"/>
		
	</div>
</div>
</x-admin-layout> 
