<x-admin-layout> 
<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Users</h1> -->
<section class="breadcrumbSection">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="h3 text-gray-800">View User</h1>				
		</div>
		<div class="col-lg-6">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="/admin/user">Users</a></li>
					<li class="breadcrumb-item active" aria-current="page">View User</li>
				</ol>
			</nav>
		</div>
	</div>
</section>
<p class="mb-4">
	
</p>

<!-- DataTales Example -->
<div class="card shadow mb-4 commonView">
	
		<!-- <a href="{{route('admin.user')}}" class="btn btn-primary mb-2"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>	 -->
		<livewire:user-view :userid="$id"/>
</div>
</x-admin-layout> 
