
<section style="background-color: #eee;">
	<div class="container py-5">


		<div class="row">
			<div class="col-lg-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<img src="{{$manageCourse->logo}}" alt="avatar"
							class="rounded-circle img-fluid" style="width: 150px;">
						<h5 class="my-3">{{$manageCourse->title}}</h5>
						<p class="text-muted mb-4">{{$manageCourse->institutionName}}</p>


					</div>
				</div>
				<div class="card mb-4">
					<div class="card-body">
						<h2>Intake</h2>
						<table class="table table-bordered">
							<tr>
								<th>Name</th>
							</tr>
							@if(!empty($manageCourse->courseIntake()))
    							@foreach($manageCourse->courseIntake() as $intake)
        							<tr>
        								<td>{{$intake}}</td>
        							</tr>
        						@endforeach
							@endif
							
						</table>
					</div>
				</div>

			</div>
			<div class="col-lg-8">
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Course Name</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{$manageCourse->title}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">University</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{$manageCourse->university()->name}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Program URL</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{$manageCourse->programUrl}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Duration</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{$manageCourse->duration}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Min Requirement</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?=$manageCourse->key_highlight?></p>
							</div>
						</div>
					   <hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Area of Interest</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?=$manageCourse->AreaInterst()?></p>
							</div>
						</div>
						 <hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Global Course</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?=$manageCourse->globalCourse()?></p>
							</div>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="card mb-4">
							<div class="card-body">
								<h2>Campus</h2>
								<table class="table table-bordered">
									<tr>
									    <th>Name</th>
										<th>Tution Fees</th>
									    <th>Application Fees</th>
									    
										
										
									</tr>
								
    									@if(!empty($manageCourse->campusDetails()))
        									@foreach($manageCourse->campusDetails() as $feesData)
        									<tr>
        									    <td>{{! empty($feesData) ? $feesData->campusName : ''}}</td>
        										<td>{{! empty($feesData) ? $feesData->tuitionFee : ''}}</td>
        										<td>{{! empty($feesData) ? $feesData->applicationFee : ''}}</td>
        									</tr>
        									@endforeach
    									@endif
									<tr>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">

						<div class="card mb-4">
							<div class="card-body">
								<h2>Open Intake</h2>
								<table class="table table-bordered">
									<tr>
										<th>Name</th>
										<th>Year</th>
									</tr>
									@if(!empty($manageCourse->courseOpenIntake()))
									
    									@foreach($manageCourse->courseOpenIntake() as $intakeYear => $openIntake)
    									<tr>
    										<td>{{$openIntake}}</td>
    										<td>{{$intakeYear}}</td>
    									</tr>
    									@endforeach
									@endif
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-12">

						<div class="card mb-4">
							<div class="card-body">
								<h2>EST Details</h2>
								<table class="table table-bordered">
									<tr>
										<th>Name</th>
										<th>Score</th>
										<th>Min Score</th>
									</tr>
									@if(!empty($manageCourse->courseEstDetail))
    									@foreach($manageCourse->courseEstDetail as $estDetail)
    									<tr>
    										<td>{{$estDetail->scoreName}}</td>
    										<td>{{$estDetail->score}}</td>
    										<td>{{$estDetail->min_score}}</td>
    									</tr>
    									@endforeach
									@endif
								</table>
							</div>
						</div>
					</div>


				</div>


			</div>

		</div>

</section>
