   <form wire:submit.prevent="store" class="interestForm">
		@csrf
		<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label >Select University</label> 
				
				<select  id="university_value"
					name="university_id" wire:model="university_id"
					class="form-control bg-light"
					> 	
		         
					<option> Select University</option>
					 @foreach($allUniverisity as $allUniverisitys)
							<option value="{{$allUniverisitys->id}}">{{$allUniverisitys->name}}</option>
								@endforeach
					</select>
				@error('university_id')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
				
				</div>
				
				<div class="col-md-6"> 
			
				<label for="interest_id">Area Of Interest</label> <select
					name="area_of_interest_id" wire:model="area_of_interest_id"
					class="form-control bg-light"
					> 
					<option> Select Area Of Interest</option>
					@foreach($areaofinterests as $areaofinterest):
						<option value="{{$areaofinterest->id}}">{{$areaofinterest->title}}</option>
					@endforeach
					</select>
				@error('area_of_interest_id')
					<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
				@enderror
    </div>
    				</div>
    
				<div class="row">
    				<div class="col-md-6">
        				<label >Select Campus</label>
        				
        				<div wire:ignore> 
        					<select name="campus_id[]" id="select2-dropdown" wire:model="campus_id"  multiple="multiple" class="form-control bg-light" > 	
            					<option> Select Campus</option>
            					 @foreach($allCampus as $allCampuss)
            							<option value="{{$allCampuss->id}}">{{$allCampuss->name}}</option>
            					 @endforeach
        					</select>
        				</div>
        					@error('campus_id')
    							<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
    						@enderror
        			</div>
    			<div class="col-md-6">
    				  <label >Select Global Course</label> 
    					<select name="global_course_id" id="global_course" wire:model="global_course_id"  class="form-control bg-light"> 	
        					<option> Select Global Course</option>
        					 @foreach($globalCourse as $globalCoures)
        							<option value="{{$globalCoures->id}}">{{$globalCoures->title}}</option>
        					 @endforeach
    					</select>
    					@error('global_course_id')
							<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
    			</div>
    			</div>
			<br/>
			<div class="row">
    		    
    			<div class="col-md-6">
    				<label >Course Name</label> 
     					<input type="text"
    					name="title" wire:model="title"
    					placeholder="Course Name"
    					class="form-control bg-light"
    					value="">	
    					@error('title')
							<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
					    @enderror		
    			</div>
    			
    			
			</div>
			<div class="row">
    			<div class="col-md-6">
    			<label >Intake</label> 
    			<div wire:ignore> 
    			<select name="intake[]" id="multiple-intake" wire:model="intake"  multiple="multiple" class="form-control bg-light" > 	
    					<option> Select Multiple Months</option>
    					  <option value="Jan">January</option>
                          <option value="Feb">February</option>
                          <option value="Mar">March</option>
                          <option value="Apr">April</option>
                          <option value="May">May</option>
                          <option value="Jun">June</option>
                          <option value="Jul">July</option>
                          <option value="Aug">August</option>
                          <option value="Sep">September</option>
                          <option value="Oct">October</option>
                          <option value="Nov">November</option>
                          <option value="Dec">December</option>
    			</select>
    			</div>
    			@error('intake')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
    			</div>
    			
    			<div class="col-md-6">
        			<label>Open Intake : </label>
        			<input class="form-control bg-light"  type="date" name="open_intake" id="date"  wire:model="open_intake"/>
        			@error('open_intake')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
    			</div>
			</div>
			<div class="row">
    			<div class="col-md-6">
    				<label >Duration : </label> 
    			<input class="form-control bg-light" type="number" name="duration_number" id="number" placeholder="Enter Number"  wire:model="duration_number"/> &nbsp;
    			@error('duration_number')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
    			</div>
    			<div class="col-md-6">
    					<label>Duration Option: </label> 
    			 			<select class="form-control bg-light"  name="duration_option" id="duration_option" wire:model="duration_option">
                              	  <option>Select Duration</option>
                              	  <option value="Days">Days</option>
                                  <option value="Months">Months</option>
                                  <option value="Years">Years</option>
                              </select>
    						@error('duration_option')
								<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
							@enderror
    			</div>
			</div>
			<br/>
			<div class="row">
    			<div class="col-md-6">
    				<label >Tuition Fee : </label> 
    				<input  class="form-control bg-light"  type="text" name="tution_fee_amount" id="tution_fee_amount" wire:model="tution_fee_amount"/> &nbsp;
    				 @error('tution_fee_amount')
				   <p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
    			</div>
    			<div class="col-md-6">
    				  <label>Select Currency : </label>
                              <select class="form-control bg-light"  name="tution_fee_currency" id="currency" wire:model="tution_fee_currency">
                                                            	 <option>Select Currency</option>
                              
                              	 @foreach($currency as $currencyValue)
									<option value="{{$currencyValue->currencyCode}}">{{$currencyValue->currencyCode}}</option>
								@endforeach
                              </select>
                              @error('tution_fee_currency')
				                 <p class="text-red-700 font-semibold mt-2">{{$message}}</p>
							  @enderror
    			</div>
			</div>
			<br/>
			<div class="row">
    			<div class="col-md-6">
    				<label >Application Fee : </label> 
    			<input class="form-control bg-light"  type="text" name="application_fee_amount" id="tution_fee_amount" wire:model="application_fee_amount"/> &nbsp;
    			 @error('application_fee_amount')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
    			</div>
    			<div class="col-md-6">
    				  <label>Select Currency : </label>
                              <select class="form-control bg-light"  name="application_fee_currency" id="currency" wire:model="application_fee_currency">
                                   <option>Select Currency</option>
                              	  @foreach($currency as $currencyValue)
									<option value="{{$currencyValue->currencyCode}}">{{$currencyValue->currencyCode}}</option>
								@endforeach
                              </select>
                              
                               @error('application_fee_currency')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
                              
    			</div>
			</div>
			<br/>
			<br/>
			<div class="row" >
    			<div class="col-md-12" >
        			<label>Key Highlights : </label>
        			<div wire:ignore>
        			<textarea id="key_highlight" name="key_highlight"  
    						wire:model="key_highlight" ></textarea>
        			</div>
    			</div>
    			 @error('key_highlight')
				<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
								@enderror
			</div>
			<br/>
				<div class="row">
				<div class="col-md-2">
				</div>
    			<div class="col-md-5">
    				<label>Score </label>
    			</div>
    			<div class="col-md-5">
    				<label>Min Score </label>
    			</div>
			</div>
						<br/>
			
			<div class="row">
			     
				<div class="col-md-2">
					<label>IELTS : </label>
				</div>
    				<div class="col-md-5" >
            			 <input class="form-control bg-light"  type="text" name="scores" id="score"  value="{{$this->ielts_score}}" wire:model="ielts_score" /> &nbsp;
            			</div>
            			<div class="col-md-5">
            			 <input class="form-control bg-light"  type="text" name="min_score" id="min_score" wire:model="ielts_min_score" value="{{$this->ielts_min_score}}"/> &nbsp;
            			 
        			</div>
        	</div>
        	<div class="row">
        	<div class="col-md-2">
        		<label>TOEFL : </label>
        	</div>
        			<div class="col-md-5" >
            			 <input class="form-control bg-light"  type="text" name="toefl_score" id="toefl_score" wire:model="toefl_score" value="{{$this->toefl_score}}"/> &nbsp;
            			 </div>
            			 <div class="col-md-5">
            			 <input class="form-control bg-light"  type="text" name="toefl_min_score" id="toefl_min_score" wire:model="toefl_min_score" value="{{$this->toefl_min_score}}"/> &nbsp;
            			 
            			
        			</div>
        			
        	</div>
        	<div class="row">
        	<div class="col-md-2">
        	<label>PTE : </label>
        	</div>
        			<div class="col-md-5" >
            			
            			 <input class="form-control bg-light"  type="text" name="pte_score" id="pte_score" wire:model="pte_score"/> &nbsp;
            		</div>
            	   <div class="col-md-5">
            			 <input class="form-control bg-light"  type="text" name="pte_min_score" id="pte_min_score" wire:model="pte_min_score"/> &nbsp;
        		   </div>
        	</div>
        	<div class="row">
        	<div class="col-md-2">
        	<label>Duolingo : </label>
        	</div>
        			<div class="col-md-5" >
            			 <input class="form-control bg-light"  type="text" name="duolingo_score" id="duolingo_score" wire:model="duolingo_score"/> &nbsp;
            		</div>
            		<div class="col-md-5">
            			 <input class="form-control bg-light"  type="text" name="duolingo_min_score" id="duolingo_min_score" wire:model="duolingo_min_score"/> &nbsp;
        			</div>
        	</div>
			
			<div class="col-md-1 mt-3">
				<button type="submit" class="btn btn-primary btn-user btn-block">Save</button>
			</div>
			</div>
		</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<style>
.ck-editor__editable {
    min-height: 500px;
}
</style>
<script>

   ClassicEditor
    .create( document.querySelector( '#key_highlight' ) )
    .then(editor => {
           editor.model.document.on('change:data', () => {
           @this.set('key_highlight', editor.getData());
          })
       })
    
    .catch( error => {
        console.error( error );
    } );

    var values = $('#select2-dropdown option[selected="true"]').map(function() { 
        return $(this).val(); 
    }).get();

    $('#select2-dropdown').select2({ 
    			placeholder: "Please select",
    });
     $('#select2-dropdown').select2();
     
   		$('#select2-dropdown').on('change', function (e) {
            let data = $(this).val();
             @this.set('campus_id', data);
        });
        
     var intake= $('#multiple-intake option[selected="true"]').map(function() { 
        			return $(this).val(); 
    			}).get();

        $('#multiple-intake').select2({ 
        			placeholder: "Please select",
        });
     $('#multiple-intake').select2();
        $('#multiple-intake').on('change', function (e) {
            let data = $(this).val();
             @this.set('intake', data);
        });
        
</script>

