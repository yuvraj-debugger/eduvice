<style>
table, th, td {
	border: 1px solid black;
	border-collapse: collapse;
}

th, td {
	padding: 15px;
}
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
<section class="viewUserSection">
	<div class="p-3">


		<div class="row">
			<div class="col-lg-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<img class="userImg" src="{{! empty ($user) ? $user->profile_photo_url : ''}}"
							alt="avatar" class="rounded-circle img-fluid"
							style="width: 150px;">
						<h5 class="my-3">{{! empty($user) ? $user->name : ''}}</h5>


					</div>
				</div>
				<div class="card mb-4 mb-lg-0 qualificationCard">
					<div class="card-body p-0">
						<div class="card-body">
							<table class="table">
								<tr>
									<td><strong>Area of Interest</strong></td>
									<td>{{! empty($user->getPreference)? $user->getPreference->getAreaInterest->title
										: ''}}</td>
								</tr>
								<tr>
									<td><strong>Preferred Course</strong></td>
									<td>{{! empty($user->getPreference) ?
										$user->getPreference->getGlobalCourse() :''}}</td>
								</tr>
								<tr>
									<td><strong>Preferred Max Budget</strong></td>
									<td>{{! empty($user->getPreference)?$user->getPreference->preferred_budget_max:''}}</td>
								</tr>
								<tr>
									<td><strong>Preferred Min Budget</strong></td>
									<td>{{! empty($user->getPreference)?$user->getPreference->preferred_budget_min:''}}</td>
								</tr>
								<tr>
									<td><strong>Preferred Country</strong></td>
									<td>{{! empty($user)? $user->getCountry() :''}}</td>
								</tr>

							</table>
						</div>

					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Full Name</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty($user) ? $user->name : ''}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Email</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty($user) ? $user->email : ''}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Gender</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty($user) ? ucfirst($user->gender) : ''}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Date Of Birth (DOB)</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty ($user)?date('d M,
									Y',strtotime($user->date_of_birth)):''}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Marital Status</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty($user) ? ucfirst($user->martial_status) : ''}}</p>
							</div>
						</div>
						<hr>

						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Contact</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty($user) ? $user->contact : ''}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Address</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{! empty($user)?$user->address.',
									':''}} {{ ! empty($user)?$user->city.', ':''}}
									{{! empty($user)?$user->state.' - ':''}}
									{{! empty($user)?$user->zipcode.', ':''}} {{! empty($user) ? $user->country : ''}}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
				<?php
    if (! empty($user->getScore)) {
        foreach ($user->getScore as $score) {
            ?>
					<div class="col-md-12">
						<div class="card qualificationCard mb-4 mb-md-0">
							<div class="card-header">
								<p class="mb-0 tableHeading">
									<span class="">
									<?php
									if ($user->type == 1) {
                echo "I don't have";
									} elseif ($user->type == 2) {
                echo " I will appear soon";
            } else {
                echo "IELTS";
            }
            ?>
									
									</span>
								</p>
							</div>
							<div class="card-body">
								
								<?php
								if ($user->type != 1 && $user->type != 2) {
                ?>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Overall</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{! empty($score) ?$score->overall : ''}}</p>
									</div>
								</div>
								<?php
            }
            ?>
									
								<hr>

								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Remarks</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{! empty($score) ? $score->remarks : ''}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
        }
    }
    ?>
				</div>
				
				
			</div>
		</div>
		<div class="row">
				<?php
				if(! empty($user->getEducation)){
    foreach ($user->getEducation as $education) {
        ?>
					<div class="col-md-4">
						<div class="card qualificationCard mt-3">
    						<div class="card-header">
    							<p class="tableHeading mb-0">
    								<span>
    									<?php
                                            if ($education->type == 1) {
                                                echo "School Degree";
                                            } elseif ($education->type == 2) {
                                                echo "Graduation Degree";
                                            } else {
                                                echo "Master Degree";
                                            }
                                            ?>
                                    </span>
    							</p>
    						</div>
							<div class="card-body">

								<table class="table">
									<tr>
										<th>Class</th>
										<th>Mark grade</th>
										<th>Passing Year</th>
										<th>Institution</th>
									</tr>
									<tr>
										<td>{{$education->class}}</td>
										<td>{{$education->mark_grade}}</td>
										<td>{{$education->passing_year}}</td>
										<td>{{$education->institution}}</td>
									</tr>

								</table>
							</div>
						</div>
					</div>
					<?php
    }
				}
    ?>
				</div>
	</div>
</section>
&nbsp;



<div class="px-4">
	<div class="card mb-4 commonListing">
		<div class="card-body">
			<h2>Application</h2>
			<table class="table table-bordered">
				<tr>
					<th>University Name</th>
					<th>Campus Name</th>
					<th>Course Name</th>
					<th>Applied By</th>
					<th>Applied Date</th>
					<th>Unread Message</th>
					<th>Message Icon</th>
					<th>Action</th>
				</tr>

			<?php
			if(! empty($userDocument)){
			    foreach ($userDocument as $user_document) {
        ?>
				
				<tr>

					<td>{{! empty($user_document->getUniversity) ?
						$user_document->getUniversity->name : ''}}</td>
					<td>{{!empty($user_document->getCourse)?$user_document->getCourse->getCampusNameAttribute():''}}</td>
					<td>{{! empty($user_document->getCourse) ? $user_document->getCourse->title
						: ''}}</td>
					<td>{{! empty($user_document->getCreated) ?
						$user_document->getCreated->name : ''}}</td>
					<td><?=date("d M, Y",strtotime($user_document->created_at))?></td>
					<td>{{$user_document->MessageCount($user_document->id)}}</td>
					<td><span class="fa-stack fa-1x"
					<?php if(! empty($user_document->MessageCount($user_document->id))) { ?>
						data-count="<?=$user_document->MessageCount($user_document->id)?>"
						<?php } ?>> <i class="fa fa-circle fa-stack-2x"></i> <i
							class="fa fa-bell fa-stack-1x fa-inverse"></i>
					</span></td>
					<td>
						<a href="{{route('admin.document.view',['id'=>$user_document->id])}}"
						class="btn btn-view"><i class="fa fa-eye"></i></a>
						</td>
				</tr>
				<?php }}?>


			</table>
		</div>
	</div>


</div>
