<div>
<style>
.sortable{
    cursor:pointer;
}
</style>
	@if (session()->has('info'))
	<div class="alert alert-info alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ session('info') }}</strong>
	</div>
	@endif
	<div class="add-btn text-right mb-4">
		<a href="{{route('blog.tags.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Tags</a>
	</div>
	<div class="row mb-3">

		<div class="col-md-3 col-3 text-left">
			<div class="paginationEntries">
				<label for="paginate">Per page</label>
				<select class="form-control form-control-sm" wire:model="paginate"
					name="paginate" id="paginate">
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div>
		</div>
		<div class="col-md-4 col-4 text-right">
			@if ($checked)
			<div class="dropdown ml-4">
				<button class="btn btn-secondary dropdown-toggle"
					data-toggle="dropdown">With Checked ({{ count($checked) }})</button>
				<div class="dropdown-menu">
					<a href="#" class="dropdown-item" type="button"
						onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
						wire:click="deleteRecords()"> Delete </a> <a href="#"
						class="dropdown-item" type="button"
						onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"
						wire:click="exportSelected()"> Export </a>
				</div>
			</div>
			@endif
		</div>
		<div class="col-md-5 col-5  text-right">
			<div class="tableSearch">
				<label for="paginate">Search</label>
				<input type="text" name="search" wire:model="search" id="search"
					class="form-control form-control-sm">
			</div>
		</div>
		@if ($selectPage)
		<div class="col-md-10 mb-2">
			@if ($selectAll)
			<div>
				You have selected all <strong>{{ $tags->total() }}</strong> items.
			</div>
			@else
			<div>
				You have selected <strong>{{ count($checked) }}</strong> items, Do
				you want to Select All <strong>{{ $tags->total() }}</strong>? <a
					href="#" class="ml-2" wire:click="selectAll">Select All</a>
			</div>
			@endif

		</div>
		@endif
	</div>



	<div class="table-responsive">
		<table class="table table-hover" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th><input type="checkbox" wire:model="selectPage"></th>
					<th class="sortable" wire:click="sortBy('title')"
						:direction="{{$sortField === 'name'?$sortDirection:null}}">Title <?=$sortField === 'name'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('meta_title')"
						:direction="{{$sortField === 'email'?$sortDirection:null}}">Meta Title <?=$sortField === 'email'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th class="sortable" wire:click="sortBy('created_at')"
						:direction="{{$sortField === 'created_at'?$sortDirection:null}}">Created <?=$sortField === 'created_at'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th>Action</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($tags as $tag)
				<tr>
					<th><input type="checkbox" value="{{ $tag->id }}"
						wire:model="checked"></th>
					<td>{{$tag->title}}</td>
					<td>{{$tag->meta_title}}</td>
					<td>{{$tag->created_at}}</td>
					<td><button class="btn btn-danger"
							onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()"
							wire:click="deleteRecord({{$tag->id}})">
							<i class="fa fa-trash"></i>
						</button></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$tags->links()}}
	</div>
</div>