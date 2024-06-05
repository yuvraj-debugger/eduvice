<div>
<style>
.sortable{
    cursor:pointer;
}
</style>
	@if (session()->has('info'))
	<div class="alert alert-danger alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ session('info') }}</strong>
	</div>
	@endif
	@if (session()->has('success'))
	<div class="alert alert-info alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ session('success') }}</strong>
	</div>
	@endif
	<div class="row mb-3">

		<div class="col-md-2 col-3 text-left">
		   <div class="paginationEntries">
				<label for="paginate" class="mb-0">Show</label>
				<select class="form-control form-control-sm" wire:model="paginate"
					name="paginate" id="paginate">
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
				&nbsp;
			<label for="paginate" class="mb-0">Entries</label>
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
		
		
		<div class="col-md-5 col-5 text-right">
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
				You have selected all <strong>{{ $universities->total() }}</strong> items.
			</div>
			@else
			<div>
				You have selected <strong>{{ count($checked) }}</strong> items, Do
				you want to Select All <strong>{{ $universities->total() }}</strong>? <a
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
					<th>#</th>
					<th class="sortable" wire:click="sortBy('name')"
						:direction="{{$sortField === 'name'?$sortDirection:null}}">University Name <?=$sortField === 'name'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('address')"
						:direction="{{$sortField === 'address'?$sortDirection:null}}">Counrty <?=$sortField === 'address'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('admission_contact_person')"
						:direction="{{$sortField === 'admission_contact_person'?$sortDirection:null}}">Logo <?=$sortField === 'admission_contact_person'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('placement_contact_person')"
						:direction="{{$sortField === 'placement_contact_person'?$sortDirection:null}}">Program Count <?=$sortField === 'placement_contact_person'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('status')"
						:direction="{{$sortField === 'status'?$sortDirection:null}}">Status <?=$sortField === 'status'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('type')"
						:direction="{{$sortField === 'type'?$sortDirection:null}}">Type <?=$sortField === 'type'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th>Action</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($universities as $university)
				<tr>
					<th><input type="checkbox" value="{{ $university->id }}"
						wire:model="checked"></th>	
						<td>{{$university->id}}</td>					
					<td>{{$university->name}}</td>				
					<td>{{$university->country}}</td>
					<td><img class="img-profile rounded-circle" src="<?=$university->logo?>" width="90px"></td>
					<td>{{$university->programCount}}</td>
					<td>
						@if($university->status==1)
							<span class="badge badge-success">Enabled</span>
						@elseif($university->status==2)
							<span class="badge badge-danger">Diabled</span>
						@elseif($university->status==3)
							<span class="badge badge-primary">Open</span>
						@elseif($university->status==4)		
							<span class="badge badge-warning">Closed</span>
						@endif				
					</td>
					<td>{{($university->type==1)?'API':'Custom'}}</td>
					
					<td>
						<a href="{{route('admin.university.view',['id'=>$university->id])}}" class="btn btn-view"><i class="fa fa-eye"></i></a>

						<a href="{{route('admin.university.update',['id'=>$university->id])}}" class="btn btn-view"><i class="fas fa-pencil-alt"></i></a>
						<button class="btn btn-delete"
							onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()"
							wire:click="deleteRecord({{$university->id}})">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$universities->links()}}
	</div>
</div>