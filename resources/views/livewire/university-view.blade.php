
<section style="background-color: #eee;">
	<div class="container py-5">


		<div class="row">
			<div class="col-lg-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<img src="{{$university->logo}}" alt="avatar"
							class="rounded-circle img-fluid" style="width: 150px;">
						<h5 class="my-3">{{$university->name}}</h5>
						<p class="text-muted mb-4">{{($university->type)?$university->country:$university->address.',
							'.$university->city.', '.$university->province.' -
							'.$university->pincode.', '.$university->country}}</p>


					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">University Name</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{$university->name}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Country</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{($university->type)?$university->country:$university->address.',
									'.$university->city.', '.$university->province.' -
									'.$university->pincode.', '.$university->country}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Institution Type</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{ucfirst($university->institutionType)}}</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">URL</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0">{{$university->institutionUrl}}</p>
							</div>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="card mb-4">
							<div class="card-body">
								<h2>Admission</h2>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Contact Person</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{$university->admission_contact_person}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Contact</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{$university->admission_contact_number}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Email</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{$university->admission_email}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">URL</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">
											<a href="{{$university->admission_website}}" target="_blank">{{$university->admission_website}}</a>
										</p>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card mb-4">
							<div class="card-body">
								<h2>Placement</h2>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Contact Person</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{$university->placement_contact_person}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Contact</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{$university->placement_contact_number}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Email</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">{{$university->placement_email}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">URL</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0">
											<a href="{{$university->admission_website}}" target="_blank">{{$university->placement_website}}</a>
										</p>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="card mb-4">
							<div class="card-body">
								<h2>About University</h2>
							<?=$university->about?>
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
										<th>Address</th>
									</tr>

									@foreach($university->universityCampus as $campus)
									<tr>
										<td>{{$campus->name}}</td>
										<td>{{$campus->address}}</td>
									</tr>
									@endforeach
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
										<th>Month</th>
										<th>Year</th>
									</tr>

									@foreach($university->universityOpenIntake as $openIntake)
									<tr>
										<td>{{$openIntake->IntakeName}}</td>
										<td>{{$openIntake->IntakeYear}}</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

</section>
&nbsp;
<div class="card">
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-4">
				<div class="card-body">
					<h2>Course</h2>
					<table class="table table-bordered">
						<tr>
							<th>Course Name</th>
							<th>Intake</th>
							<th>Open Intake</th>
							<th>Duration</th>
							<th>Duration Options</th>
							<th>Tuition Fee</th>
							<th>Tuition Fee Currency</th>
							<th>Application Fee</th>
							<th>Application Fee Currency</th>
							<th>Key Highlights</th>
						</tr>
                                @if(!empty($university_course))
                               
								@foreach($university_course as $courses)
								 <?php
        $intakeDate = ! empty($courses->courseIntake) ? implode(',', $courses->courseIntake()): '';

        ?>
								<tr>
							<td>{{$courses->title}}</td>
							<td>{{$intakeDate}}</td>
							<td>{{$courses->open_intake}}</td>
							<td>
    									<?php
            if ($courses->duration_number) {
                echo $courses->duration_number;
            } else {
                $duration = $courses->duration;
                $duration = explode(' ', $duration);
                echo $duration[0];
            }

            ?>
									</td>
							<td><?php
    if ($courses->duration_option == 1) {
        echo "Days";
    } elseif ($courses->duration_option == 2) {
        echo "Months";
    } else if ($courses->duration_option == 3) {
        echo "Years";
    } else {
        $duration = $courses->duration;
        $duration = explode(' ', $duration);
        echo $duration[1];
    }
    ?></td>
							<td>{{$courses->tution_fee_amount}} <?php
    if (empty($courses->tution_fee_amount)) {
        $campusDetail = json_decode($courses->campusDetails);
        if ($campusDetail) {
            $tution_fees = str_replace($courses->currencyCode . ' ' . $courses->currencySymbol, '', $campusDetail[0]->tuitionFee);
            echo $courses->tution_fee_amount = (int) $tution_fees;
            $courses->tution_fee_currency = $courses->currencyCode;
            $courses->update();
        }
    }
    ?></td>
							<td>{{$courses->currencyCode}}</td>
							<td>{{$courses->application_fee_amount}} <?php
    if (empty($courses->application_fee_amount)) {
        $campusDetail = json_decode($courses->campusDetails);
        if ($campusDetail) {
            $application_fees = str_replace($courses->currencyCode . ' ' . $courses->currencySymbol, '', $campusDetail[0]->applicationFee);
            echo $courses->application_fee_amount = (int) $application_fees;
            $courses->application_fee_currency = $courses->currencyCode;
            $courses->update();
        }
    }
    ?></td>
							<td>{{$courses->currencyCode}}</td>
							<td><?=$courses->key_highlight?></td>

						</tr>

						@endforeach @endif
					</table>
				</div>
				<div>{{$university_course->links()}}</div>
			</div>
		</div>
	</div>


</div>

