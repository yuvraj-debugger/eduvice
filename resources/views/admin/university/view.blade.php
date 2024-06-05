<x-admin-layout> 
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">University</h1>
<p class="mb-4">
	
</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold">University</h6>
	</div>
	<div class="card-body">	
		<div class="row">
			<div class="col-6">
				<a href="{{route('admin.university.index')}}" class="btn backBtn mb-2"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
		</div>
		<livewire:university-view :university_id="$id"/>
		
	</div>
</div>
</x-admin-layout> 
