<div>
	<style>
.sortable {
	cursor: pointer;
}

.fa-stack[data-count]:after {
	position: absolute;
	right: 0%;
	top: 1%;
	content: attr(data-count);
	font-size: 50%;
	padding: .6em;
	border-radius: 999px;
	line-height: .75em;
	color: white;
	background: rgba(255, 0, 0, .85);
	text-align: center;
	min-width: 2em;
	font-weight: bold;
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
				<select
					class="form-control form-control-sm" wire:model="paginate"
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
				<label for="paginate" class="mb-0">Search</label> <input type="text"
					name="search" wire:model="search" id="search"
					class="form-control form-control-sm" />
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
				you want to Select All <strong>{{ $document->total() }}</strong>? <a
					href="#" class="ml-2" wire:click="selectAll">Select All</a>
			</div>
			@endif

		</div>
		@endif
	</div>
	
	<div class="row">
	<div class="col-md-3 col-3 text-left">
			<div class="paginationEntries">
			
				<label for="message_filter" class="mb-0">Message Search</label> <select
					class="form-control form-control-sm" wire:model="message_filter"
					name="message_filter" id="message_filter">
					<option value="1">All Message</option>
					<option value="2">Read Message</option>
						<option value="3">Unread Message</option>
				</select>
			</div>
			<!-- <div class="col-6">
			</div> -->
		</div>
		</div>
	
	<br />


	<div class="table-responsive">
		<table class="table" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th><input type="checkbox" wire:model="selectPage"></th>
										<th>#</th>
					

					<th class="sortable" wire:click="sortBy('university_id')"
						:direction="{{$sortField === 'name'?$sortDirection:null}}">University Name <?=$sortField === 'name'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('campus_id')"
						:direction="{{$sortField === 'name'?$sortDirection:null}}">Campus Name <?=$sortField === 'name'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('course_id')"
						:direction="{{$sortField === 'name'?$sortDirection:null}}">Course Name <?=$sortField === 'name'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?> </th>
					<th class="sortable" wire:click="sortBy('created_at')"
						:direction="{{$sortField === 'created_at'?$sortDirection:null}}">Applied By <?=$sortField === 'created_at'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th class="sortable" wire:click="sortBy('created_at')"
						:direction="{{$sortField === 'created_at'?$sortDirection:null}}">Applied Date<?=$sortField === 'created_at'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th class="sortable"
						:direction="{{$sortField === 'created_at'?$sortDirection:null}}">Unread Message<?=$sortField === 'created_at'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>

					<th class="sortable" wire:click="sortBy('created_at')"
						:direction="{{$sortField === 'created_at'?$sortDirection:null}}">Message Icon<?=$sortField === 'created_at'?($sortDirection=='asc'?'<i class="fa fa-angle-down"></i>':'<i class="fa fa-angle-up"></i>'):null?></th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php

    foreach ($document as $documents) {
        ?>
				
				<tr>
					<th><input type="checkbox" value="{{ $documents->id }}"
						wire:model="checked"></th>
					<td>{{$documents->id}}</td>

					<td>{{! empty($documents->getUniversity) ?
						$documents->getUniversity->name : ''}}</td>
					<td>{{!empty($documents->getCourse)?$documents->getCourse->getCampusNameAttribute():''}}</td>
					<td>{{! empty($documents->getCourse) ? $documents->getCourse->title
						: ''}}</td>
					<td>{{! empty($documents->getCreated) ?
						$documents->getCreated->name : ''}}</td>
					<td><?=date("d M, Y",strtotime($documents->created_at))?></td>
					<td>{{$documents->MessageCount($documents->id)}}</td>
					<td><span class="fa-stack fa-1x"
						<?php if(! empty($documents->MessageCount($documents->id))) { ?>
						data-count="<?=$documents->MessageCount($documents->id)?>"
						<?php } ?>> <i class="fa fa-circle fa-stack-2x"></i> <i
							class="fa fa-bell fa-stack-1x fa-inverse"></i>
					</span></td>
					<td>
						<a href="{{route('admin.document.view',['id'=>$documents->id])}}"
						class="btn btn-view"><i class="fa fa-eye"></i></a>
						</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		{{$document->links()}}
	</div>
</div>
