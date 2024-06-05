<x-admin-layout> <!-- Page Heading -->

<h1 class="h3 mb-2 text-gray-800">Global Courses</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4 commonListing">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold">Global Courses</h6>
	</div>
	<div class="card-body">
		<div class=" text-right add-btn mb-4">
				<a href="{{route('admin.globalcourses.create')}}" class="btn mb-2 addBtn"><i class="fa fa-plus"></i> Add</a>
		</div>
		<livewire:globalcourses-index />

	</div>
</div>
</x-admin-layout>
