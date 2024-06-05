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
	<div class="row mb-3">

		<div class="col-md-3 col-3 text-left">
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
			<!-- <div class="col-6">
			</div> -->
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
				<label for="paginate" class="mb-0">Search</label> 
				<input type="text" name="search" wire:model="search" id="search" class="form-control form-control-sm" />
			</div>
		</div>
		@if ($selectPage)
		<div class="col-md-10 mb-2">
			@if ($selectAll)
			<div>
				You have selected all <strong>{{ $users->total() }}</strong> items.
			</div>
			@else
			<div>
				You have selected <strong>{{ count($checked) }}</strong> items, Do
				you want to Select All <strong>{{ $users->total() }}</strong>? <a
					href="#" class="ml-2" wire:click="selectAll">Select All</a>
			</div>
			@endif

		</div>
		@endif
	</div>



	<div class="table-responsive usersTable">
		<table class="table" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th><input type="checkbox" wire:model="selectPage"></th>
					<th>Profile</th>
					<th class="sortable" wire:click="sortBy('name')"
						:direction="{{$sortField === 'name'?$sortDirection:null}}">Name <?=$sortField === 'name'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('email')"
						:direction="{{$sortField === 'email'?$sortDirection:null}}">Email <?=$sortField === 'email'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th>Role</th>
					<th>Email Status</th>
					<th>User Status</th>
					<th class="sortable" wire:click="sortBy('created_at')"
						:direction="{{$sortField === 'created_at'?$sortDirection:null}}">Date Created <?=$sortField === 'created_at'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th>Action</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($users as $user)
				<tr>
					<th><input type="checkbox" value="{{ $user->id }}"
						wire:model="checked"></th>
					<td><img class="rounded-circle img-fluid " src="<?=$user->profile_photo_url ?>"></td>
					<td>{{$user->name}}</td>
					<td>{{$user->email}}</td>
					<td>{{ucfirst($user->role)}}</td>
					<td>{{$user->getStatus()}}</td>
					<td><?=($user->status == '2')?"Deleted":"Active"?></td>
					
					<td>{{$user->created_at}}</td>
					<td>
						<a href="{{route('admin.user.view',['id'=>$user->id])}}" class="btn btn-view"><i class="fa fa-eye"></i></a>
						<button class="btn btn-delete"
							onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()"
							wire:click="deleteRecord({{$user->id}})">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$users->links()}}
	</div>
</div>