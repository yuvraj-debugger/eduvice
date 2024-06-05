
@push('styles')
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    button, [type='button'], [type='reset'], [type='submit'] {
        -webkit-appearance: button;
        background-color: #4e73df;
        background-image: none;
    }
    </style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush


		<form wire:submit.prevent="store" class="interestForm">
		@csrf
		<div class="form-group">
			<div class="col-12">
				<label for="title">Course</label> <input type="text"
					name="title" wire:model="title"
					placeholder="Course"
					class="form-control bg-light"
					value="{{old('course')}}"> @error('course')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			
			
			<div class="col-12"> 
			
				<label for="mark_grade">Highest Education</label> <select
					name="mark_grade" wire:model="mark_grade"
					class="form-control bg-light"
					> 
					<option> Select Education</option>
						<option value="1">High School</option>
						<option value="2">Graduation</option>
						<option value="3">Post Graduation</option>
						
						
					</select>
				@error('interest_id')
					<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			
			<div class="col-md-1 mt-3">
				<button type="submit" class="btn btn-primary btn-user btn-block">Save</button>
			</div>
			</div>
		</form>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#select2-dropdown').select2({
            tags:true,
            data: <?=json_encode(explode(',',$globalCourse->tags))?>,
            tokenSeparators: [",", " "]
        });
        $('#select2-dropdown').val(<?=json_encode(explode(',',$globalCourse->tags))?>).trigger('change')

        $('#select2-dropdown').on('change', function (e) {
            let data = $(this).val();
             @this.set('tags_data', data);
        });
    });
</script>
@endpush
