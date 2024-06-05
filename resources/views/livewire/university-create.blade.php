
<div>
	<form wire:submit.prevent="store" class="interestForm" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-12">
				<label for="name">University Name</label> <input type="text"
					name="name" wire:model.debounce.365ms="name"
					placeholder="University Name"
					class="form-control bg-light border-0 small"
					value="{{old('name')}}"> @error('name')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-6">
				<label for="name">Address</label> <input type="text" name="address"
					wire:model.debounce.365ms="address" placeholder="Address" id="address_university"
					class="form-control bg-light border-0 small address"
					value="{{old('address')}}"> @error('address')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-6">
				<label for="name">City</label> <input type="text" name="city"
					wire:model.debounce.365ms="city" placeholder="City" id="city"
					class="form-control bg-light border-0 small"
					value="{{old('city')}}"> @error('city')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-6">
				<label for="name">Province</label> <input type="text"
					name="province" wire:model.debounce.365ms="province" id="state"
					placeholder="Province" class="form-control bg-light border-0 small" 
					value="{{old('province')}}"> @error('province')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-6">
				<label for="name">Zipcode</label> <input type="text"
					name="province" wire:model.debounce.365ms="pincode" id="pincode_university"
					placeholder="pincode" class="form-control bg-light border-0 small" 
					value="{{old('pincode')}}"> @error('pincode')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-6">
				<label for="name">Country</label> <input type="text" name="country"
					wire:model.debounce.365ms="country" placeholder="Country" id="country"
					class="form-control bg-light border-0 small"
					value="{{old('country')}}"> @error('country')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-12">
				<label for="name">Campus</label>
				<div class=" add-input">
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter Name"
									wire:model="campus_name.0"> @error('campus_name.0') <span
									class="text-danger error">{{ $message }}</span>@enderror
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" class="form-control query"
									wire:model="campus_address.0" placeholder="Enter Address">
								@error('campus_address.0') <span class="text-danger error">{{
									$message }}</span>@enderror
							</div>
						</div>
						<div class="col-md-2">
							<button class="btn text-white btn-info btn-sm"
								wire:click.prevent="add({{$i}})">Add</button>
						</div>
					</div>
				</div>

				<div class=" add-input">
					@foreach($inputs as $key => $value)
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter Name"
									wire:model="campus_name.{{ $value }}"> @error('title.'.$value)
								<span class="text-danger error">{{ $message }}</span>@enderror
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" class="form-control query"
									wire:model="campus_address.{{ $value }}"
									placeholder="Enter Address"> @error('campus_address.'.$value) <span
									class="text-danger error" value="{{ $value }}">{{ $message }}</span>@enderror
							</div>
						</div>
						<div class="col-md-2">
							<button class="btn btn-danger btn-sm"
								wire:click.prevent="remove({{$key}})">remove</button>
						</div>
					</div>
					<script>
					var inputs= document.getElementsByClassName('query');

                     for (var i = 1; i < inputs.length; i++) {
    					var options = {
                          types: ['(cities)']
                        };
                        
                         var autocompletes = [];
                        
                         var autocomplete = new google.maps.places.Autocomplete(inputs[i], options);
                         autocomplete.inputId = {{$value}};
                         autocomplete.addListener('place_changed', fillIn);
                         autocompletes.push(autocomplete);
                    }                        
                    </script>
					@endforeach
				</div>
			</div>
			<div wire:ignore>
				<div class="col-12">
					<label for="name">About University</label>
					<textarea id="aboutckeditor" name="about" 
						wire:model="about" placeholder="About" ></textarea>
						
				</div>
			</div>
			<br /> <b>Contact Details</b>
			<hr />
			<div class="col-12">
				<b>Addmission Cell</b>
				<div class="row">
					<div class="col-6">
						<label for="name">Contact Person</label> <input type="text"
							name="admission_contact_person"
							wire:model.debounce.365ms="admission_contact_person"
							placeholder="Contact Person"
							class="form-control bg-light border-0 small"
							value="{{old('admission_contact_person')}}">
						@error('admission_contact_person')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
					<div class="col-6">
						<label for="name">Contact Number</label> <input type="text"
							name="admission_contact_number"
							wire:model.debounce.365ms="admission_contact_number"
							placeholder="Contact Number"
							class="form-control bg-light border-0 small"
							value="{{old('admission_contact_number')}}">
						@error('admission_contact_number')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
					<div class="col-6">
						<label for="name">Contact Email</label> <input type="text"
							name="admission_email"
							wire:model.debounce.365ms="admission_email" placeholder="Email"
							class="form-control bg-light border-0 small"
							value="{{old('admission_email')}}"> @error('admission_email')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
					<div class="col-6">
						<label for="name">Website</label> <input type="text"
							name="admission_website"
							wire:model.debounce.365ms="admission_website"
							placeholder="Website"
							class="form-control bg-light border-0 small"
							value="{{old('admission_website')}}"> @error('admission_website')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
				</div>
			</div>
			<hr />
			<div class="col-12">
				<b>Placement Cell</b>
				<div class="row">
					<div class="col-6">
						<label for="name">Contact Person</label> <input type="text"
							name="placement_contact_person"
							wire:model.debounce.365ms="placement_contact_person"
							placeholder="Contact Person"
							class="form-control bg-light border-0 small"
							value="{{old('placement_contact_person')}}">
						@error('placement_contact_person')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
					<div class="col-6">
						<label for="name">Contact Number</label> <input type="text"
							name="placement_contact_number"
							wire:model.debounce.365ms="placement_contact_number"
							placeholder="Contact Number"
							class="form-control bg-light border-0 small"
							value="{{old('placement_contact_number')}}">
						@error('placement_contact_number')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
					<div class="col-6">
						<label for="name">Contact Email</label> <input type="text"
							name="placement_email"
							wire:model.debounce.365ms="placement_email" placeholder="Email"
							class="form-control bg-light border-0 small"
							value="{{old('placement_email')}}"> @error('placement_email')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
					<div class="col-6">
						<label for="name">Website</label> <input type="text"
							name="placement_website"
							wire:model.debounce.365ms="placement_website"
							placeholder="Website"
							class="form-control bg-light border-0 small"
							value="{{old('placement_website')}}"> @error('placement_website')
						<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
					</div>
				</div>
			</div>
			<div class="col-6">
				<label for="name">Status</label> <select name="status"
					wire:model.debounce.365ms="status" placeholder="status"
					class="form-control bg-light border-0 small">
					<option value="0">Select Status</option>
					<option value="1">Enabled</option>
					<option value="2">Disabled</option>
					<option value="3">Open</option>
					<option value="4">Closed</option>
				</select> @error('status')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="col-6">
				<label>Image</label> <input type="file" class="form-control"
					id="logo" name="logo" wire:model="logo">
			</div>
			<div class="col-12 mt-2">
				<button type="submit" class="btn btn-primary btn-user btn-block submit_button">Save</button>
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

.ck-editor__editable {
	min-height: 400px;
}
.btn, .submit_button{
    background-color: #273D68 !important;
}
.btn, .btn-block .submit_button {
    width: auto;
    margin: 0 auto;
    padding: 5px 30px;
    font-weight: 600;
    background-color: #273D68;
}
</style>

@push('scripts')
<script
	src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlFzDJS-mRsh7Ol928Nge6hbe9wUYuTNY&libraries=places&callback=initMap"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#aboutckeditor' ) )
         .then(editor => {
           editor.model.document.on('change:data', () => {
           @this.set('about', editor.getData());
          })
       })
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
var inputs = document.getElementsByClassName('query');
var options = {
  types: ['(cities)']
};

var autocompletes = [];

  var autocomplete = new google.maps.places.Autocomplete(inputs[0]);
  autocomplete.inputId = 0;
  autocomplete.addListener('place_changed', fillIn);
  autocompletes.push(autocomplete);


function fillIn() {
  
  var place = this.getPlace();
  @this.set('campus_address.'+this.inputId, place.formatted_address);
}

var inputs = document.getElementsByClassName('address');
var addressing = [];

  var addressing = new google.maps.places.Autocomplete(inputs[0],{
      componentRestrictions: { country: "us" },
      fields: ["address_components", "geometry", "icon", "name"],
      strictBounds: false,
      types: ["establishment"],
  });
  addressing.inputId = 0;
  addressing.addListener('place_changed',fillInAddress);
  addressing.push(autocomplete);
  
  function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = this.getPlace();
  let address1 = "";
  let postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    // @ts-ignore remove once typings fixed
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.long_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#city").value = component.long_name;
        @this.set('city', component.long_name);
        break;
      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.long_name;
        @this.set('province', component.long_name);
        break;
      }
      case "country":
        document.querySelector("#country").value = component.long_name;
        @this.set('country', component.long_name);
        break;
    }
  }
  assign(address1,postcode);
  
}
function assign(address, pincode)
{
	document.querySelector("#address_university").value = address;
	document.querySelector("#pincode_university").value = pincode;
    @this.set('address', address);    
    @this.set('pincode', pincode);
}
  
</script>
@endpush
