<?php 
$intake=[];
if(! empty($manageCourses->getcourseIntake)){
foreach($manageCourses->getcourseIntake as $courseIntake)
    {
        $intake[]=$courseIntake->intake;
    }
}

$campus_id=[];
if(! empty($manageCourses->campusDetails())){
    foreach ($manageCourses->campusDetails() as $manageCoursesCampus){
        $campus_id[]=$manageCoursesCampus->campus_id;
    }
}
?>
<div>
    <form wire:submit.prevent="store" class="interestForm">
      <div class="form-group">
      <div class="row">
			<div class="col-md-6" wire:ignore>
				<label >Select University</label> 
				
				<select id="university_value"
					name="university_id" wire:model="university_id"
					class="form-control bg-light"> 	
					<option> Select University</option>
					 @foreach($universityName as $universityId)
					 <option value="{{$universityId->id}}">{{ $universityId->name }} </option>		
					 @endforeach
					</select>
				
				<p class="text-red-700 font-semibold mt-2"></p>
				</div>
				<div class="col-md-6"> 
			
				<label for="area_of_interest_id">Area Of Interest</label> <select
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
				<div class="col-md-6" >
    			<label >Select Campus</label> 
    		      <div wire:ignore>
    				<select name="campus_id[]" id="campus_name" wire:model="campus_id"  multiple="multiple" class="form-control bg-light" > 	
    					<option> Select Campus</option>
    					 @foreach($campusName as $campusId)
    							<option value="{{$campusId->id}}">{{$campusId->name}}</option>
    					 @endforeach
    					</select>
    			   </div>
    			</div>
    			 <div class="col-md-6"  wire:ignore>
    			<label >Select Global Course</label> 
    			<select name="global_course_id" id="global_course" wire:model="global_course_id"  class="form-control bg-light"> 	
    					<option> Select Global Course</option>
    					 @foreach($globalCourse as $globalCoures):
    							<option value="{{$globalCoures->id}}">{{$globalCoures->title}}</option>
    					 @endforeach
    					</select>
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
    					value="{{$this->title}}">			
    			</div>
			</div>
			<div class="row">
    			
    			
    				<div class="col-md-6">
    			<label >Intake</label> 
    			<div wire:ignore> 
    			<select name="intake[]" id="intake_name" wire:model="intake"  multiple="multiple" class="form-control bg-light" > 	
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
        			<input class="form-control bg-light"  type="date" name="open_intake" id="date"  wire:model="open_intake" value="{{$this->open_intake}}"/>
    			</div>
			</div>
			<div class="row">
    			<div class="col-md-6" >
    				<label >Duration : </label> 
    			<input class="form-control bg-light" type="number" name="duration_number" id="number" placeholder="Enter Number"  wire:model="duration_number" value="{{$this->duration_number}}"/> &nbsp;
    			</div>
    			<div class="col-md-6" wire:ignore>
						<label>Duration Option: </label> 
			 			<select class="form-control bg-light"  name="duration_option" id="duration_option" wire:model="duration_option">
                          	  <option>Select Duration</option>
                          	  <option value="1">Days</option>
                              <option value="2">Months</option>
                              <option value="3">Years</option>
                          </select>
						@error('duration_option')
							<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
						@enderror
    			</div>
    		
			</div>
			<div class="row">
    			<div class="col-md-6">
    				<label >Tuition Fee : </label> 
    				<input  class="form-control bg-light"  type="text" name="tution_fee_amount" id="tution_fee_amount" wire:model="tution_fee_amount"/> &nbsp;
    			</div>
    			<div class="col-md-6"  wire:ignore>
    				  <label>Select Currency : </label>
                              <select class="form-control bg-light"  name="tution_fee_currency" id="currency" wire:model="tution_fee_currency">
                              	@foreach($currency as $currencyValue)
									<option value="{{$currencyValue->currencyCode}}">{{$currencyValue->currencyCode}}</option>
								@endforeach
                              </select>
    			</div>
			</div>
			<div class="row">
    			<div class="col-md-6">
    				<label >Application Fee : </label> 
    			<input class="form-control bg-light"  type="text" name="application_fee_amount" id="application_fee_amount" wire:model="application_fee_amount"/> &nbsp;
    			</div>
    			<div class="col-md-6"  wire:ignore>
    				  <label>Select Currency : </label>
                              <select class="form-control bg-light"  name="application_fee_currency" id="application_currency" wire:model="application_fee_currency">
                              	  @foreach($currency as $currencyValue)
									<option value="{{$currencyValue->currencyCode}}">{{$currencyValue->currencyCode}}</option>
								@endforeach
                              </select>
    			</div>
			</div>
			<div class="row" wire:ignore>
    			<div class="col-md-12" >
        			<label>Key Highlights : </label>
        			<textarea id="key_highlight" name="key_highlight" 
    						wire:model="key_highlight" >{{$this->key_highlight}}</textarea>
        			
    			</div>
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
				<button type="submit" class="btn btn-primary ">Save</button>
			</div>
			</div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    
    
    
var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31],
    today = new Date(),
    // default targetDate is christmas
    targetDate = new Date(today.getFullYear(), 00, 01); 

setDate(targetDate);
setYears(5) // set the next five years in dropdown

$("#select-month").change(function() {
  var monthIndex = $("#select-month").val();
  setDays(monthIndex);
});

function setDate(date) {
  setDays(date.getMonth());
  $("#select-day").val(date.getDate());
  $("#select-month").val(date.getMonth());
  $("#select-year").val(date.getFullYear()); 
}

// make sure the number of days correspond with the selected month
function setDays(monthIndex) {
  var optionCount = $('#select-day option').length,
      daysCount = daysInMonth[monthIndex];
  
  if (optionCount < daysCount) {
    for (var i = optionCount; i < daysCount; i++) {
      $('#select-day')
        .append($("<option></option>")
        .attr("value", i + 1)
        .text(i + 1)); 
    }
  }
  else {
    for (var i = daysCount; i < optionCount; i++) {
      var optionItem = '#select-day option[value=' + (i+1) + ']';
      $(optionItem).remove();
    } 
  } 
}
function setYears(val) {
  var year = today.getFullYear();
  for (var i = 0; i < val; i++) {
      $('#select-year')
        .append($("<option></option>")
        .attr("value", year + i)
        .text(year + i)); 
    }
}
		$('#campus_name').select2({
           tags: true,
           multiple: true
           }).on('change', function(){
                @this.set('campus_id', $(this).val());
            });
        var campusId = <?='['.json_encode($this->campus_id,true).']'?>;
		$('#campus_name').select2("val", campusId);
            
        $('#global_course').val('<?=$this->global_course_id?>');
        $('#select-day').val('<?=$this->duration_day?>');
        $('#select-month').val('<?=$this->duration_month?>');
        $('#select-year').val('<?=$this->duration_year?>');
        $('#tution_fee_amount').val('<?=$this->tution_fee_amount?>');
        $('#currency').val('<?=$this->tution_fee_currency?>');
        $('#application_fee_amount').val('<?=$this->application_fee_amount?>');
        $('#application_currency').val('<?=$this->application_fee_currency?>');
        $('#key_highlight').val('<?=$this->key_highlight?>');
        
        

</script>
<script>
      $('#intake_name').select2({
      	 tags: true,
       	 multiple: true
    	 }).on('change', function(){
            @this.set('intake', $(this).val());
        });
     var IntakeValues = <?='['.json_encode($this->intake,true).']'?>;
	 $('#intake_name').select2("val", IntakeValues);
</script>

