<div>
	<form wire:submit.prevent="store" class="interestForm">
	@csrf
		<div class="row">
			<div class="col-4 mx-auto">
				<div class="form-group">
					<label for="title">Area Of Interest</label>
					<input type="text"
						name="title" wire:model.debounce.365ms="title"
						placeholder="Area Of Interest"
						class="form-control bg-light small"
						value="{{old('title')}}"> 
						@error('title')
					<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
					<button type="submit" class="btn btn-primary btn-user btn-block">Save</button>
				</div>
			</div>
			<div class="col-12 mt-2">
			</div>
			
		</div>
	</form>
</div>
<style>
button, [type='button'], [type='reset'], [type='submit'] {
    -webkit-appearance: button;
    background-color: #4e73df;
    background-image: none;
}
</style>
