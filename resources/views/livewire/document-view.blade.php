<?php
use Illuminate\Support\Facades\Auth;
?>
<link href="css/custom.css" rel="stylesheet" />
<style type="text/css">
#loader {
	display: none;
}
</style>
<div class="documentSection viewApplication">
	<div class="col-lg-12">
		<div class="card mb-4">
			<div class="card-header">
				<h2>Application No: <?=$userDocument->id?></h2>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-8">
						<div class="messageSection">
							<div class="messageListWrap">
								<div class="row">
									<div class="col-12">
										<div class="card">
											<div class="card-header text-center">User Message</div>
											<div class="card-body" id="message-list">
												<ul class="list-unstyled messageListing" id="messageListing">
                            					<?php
                                foreach ($message_id as $messages) {
                                    if (! empty($messages->getStudent)) {
                                        if ($messages->getStudent->role == 'student') {
                                            ?>
                            							<li class="mb-3">
														<div
															class="d-flex justify-content-start align-items-center userSection">
															<img src="{{$messages->getCreated->profile_photo_url}}"
																alt="Avatar" class="rounded-circle me-3" width="50">
															<div class="messageDetail">
																<p class="m-0 userName">
																	<span>{{$messages->getCreated->name}} <span
																		class="replyPill">Replied</span>
																	</span><span class="chatDate"><?=$messages->created_at ?></span>
																</p>

															</div>

														</div>
														<div class="messageOuter">
															<div class="left"></div>
															<div class="right">
														<?php

                                            if ($messages->type == 1) {
                                                echo $messages->message;
                                            } else {
                                                echo '<a href="' . $messages->getmessageDocument($messages->message_document) . '" target="_blank" >' . $messages->message_document . '</a>';
                                            }
                                            ?>
                                            </div>
														</div>
													</li>
                            							<?php
                                        }
                                    } else {
                                        ?>
                            							<li class="mb-3">
														<div class="d-flex align-items-center adminSection">
															<img src="{{$messages->getCreated->profile_photo_url}}"
																alt="Avatar" class="rounded-circle ms-3" width="50">
															<div>
																<p class="m-0 userName">
																	<span class="chatDate"><?=($messages->created_by != Auth::user()->id) ?   '' : $messages->created_at?></span><?php if($messages->created_by != Auth::user()->id){?> <span
																		class="replyPill">Reply</span> <?php }?><?= ($messages->created_by == Auth::user()->id) ? $messages->getCreated->name :''?> </p>



															</div>

														</div>
														<div class="adminMessageOuter">
															<div class="right">
																		<?php

                                        if ($messages->type == 1) {
                                            echo $messages->message;
                                        } else {
                                            echo '<a href="' . $messages->getmessageDocument($messages->message_document) . '" target="_blank">' . $messages->message_document . '</a>';
                                        }
                                        ?>
																	</div>
														</div>
													</li>
                            						<?php
                                    }
                                }
                                ?>
                                <li id="loader"><img
														src="{{asset('images/loading2.gif')}}"></li>
												</ul>
											</div>
											<div class="card-footer">
												<form id="files" enctype="multipart/form-data">
													@csrf
													<div class="row">
														<div class="col-12">
															<input type="hidden" name="document_id"
																value="{{$document_id}}" id="document_id" /> <input
																type="text" class="form-control" name="message"
																placeholder="Type your message" id="messagesinput"> <br />

															<input type="file" name="message_document"
																id="message_document" />
														</div>
														<div class="col-12 text-right mt-2">

															<button type="submit" class="btn btn-primary btn-send">Send</button>
															<span id="error"></span>

														</div>
													</div>
												</form>
											</div>
										</div>
									</div>

								</div>
							</div>

						</div>
						<br />
						<div class="row mt-2">
							<div class="col-sm-12">
								<p class="mb-0 font-semibold">SOP</p>
								<p class="attachmentLink text-muted mb-0">
									{{$userDocument->sop}}</p>
							</div>
							<div class="col-sm-8"></div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="card">
							<div class="card-header">
								<h2 class="mb-0">General Info</h2>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-4">
										<p class="mb-0 font-semibold">University Name</p>
									</div>
									<div class="col-sm-8">
										<p class="text-muted mb-0">

											<a class="applicationLink"
												href="{{route('admin.university.view',['id'=>$userDocument->getUniversity->id])}}"
												target="_blank">{{! empty($userDocument->getUniversity) ?
												$userDocument->getUniversity->name : ''}}</a>
										</p>
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-4">
										<p class="mb-0 font-semibold">Campus Name</p>
									</div>
									<div class="col-sm-8">
										<p class="text-muted mb-0">{{!empty($userDocument->getCourse)?$userDocument->getCourse->getCampusNameAttribute():''}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-4">
										<p class="mb-0 font-semibold">Course Name</p>
									</div>
									<div class="col-sm-8">
										<p class="text-muted mb-0">
											<a class="applicationLink"
												href="{{route('admin.manage.view',['id'=>$userDocument->getCourse->id])}}"
												target="_blank">{{! empty($userDocument->getCourse) ?
												$userDocument->getCourse->title : ''}}</a>
										</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-4">
										<p class="mb-0 font-semibold">Passport Number</p>
									</div>
									<div class="col-sm-8">
										<p class="text-muted mb-0">{{!
											empty($userDocument->passport_number) ?
											$userDocument->passport_number : ''}}</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-4">
										<p class="mb-0 font-semibold">Applied By</p>
									</div>
									<div class="col-sm-8">
										<p class="text-muted mb-0">

											<a class="applicationLink"
												href="{{route('admin.user.view',['id'=>$userDocument->created_by])}}"
												target="_blank">{{! empty($userDocument->getCreated) ?
												ucfirst($userDocument->getCreated->name) : ''}}</a>



										</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-4">
										<p class="mb-0 font-semibold">Applied Date</p>
									</div>
									<div class="col-sm-8">
										<p class="text-muted mb-0"><?=date("d M, Y",strtotime($userDocument->created_at))?></p>
									</div>
								</div>
								<hr>
							</div>
						</div>

						<div class="card mt-4 attachmentCard">
							<div class="card-header">
								<h2 class="mb-0">Attachments</h2>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<p class="mb-0 font-semibold">English Test Documnet</p>
										<p class="attachmentLink text-muted mb-0">
											<a class="applicationLink"
												href="{{$userDocument->getfile($userDocument->english_test_doc)}}"
												target="_blank"> <img
												src="{{asset ('admin/img/iconPdf.svg')}}" /> {{!
												empty($userDocument->english_test_doc) ?
												$userDocument->english_test_doc : ''}}
											</a> <img class="iconCross"
												src="{{asset ('admin/img/crossIcon.svg')}}" />
										</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-12">
										<p class="mb-0 font-semibold">Degree Document</p>
										<p class="attachmentLink text-muted mb-0">
											<a class="applicationLink"
												href="{{$userDocument->getfile($userDocument->degree_doc)}}"
												target="_blank"> <img
												src="{{asset ('admin/img/iconPdf.svg')}}" /> {{!
												empty($userDocument->degree_doc) ? $userDocument->degree_doc
												: ''}}
											</a> <img class="iconCross"
												src="{{asset ('admin/img/crossIcon.svg')}}" />
										</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-12">
										<p class="mb-0 font-semibold">Cv Or Experienced Document</p>
										<p class="attachmentLink text-muted mb-0">
											<a class="applicationLink"
												href="{{$userDocument->getfile($userDocument->cv_experienced_doc)}}"
												target="_blank"> <img
												src="{{asset ('admin/img/iconPdf.svg')}}" /> {{!
												empty($userDocument->cv_experienced_doc) ?
												$userDocument->cv_experienced_doc : ''}}
											</a> <img class="iconCross"
												src="{{asset ('admin/img/crossIcon.svg')}}" />
										</p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-12">
										<p class="mb-0 font-semibold">Passport Document</p>
										<p class="attachmentLink text-muted mb-0">
											<a class="applicationLink"
												href="{{$userDocument->getfile($userDocument->passport_doc)}}"
												target="_blank"> <img
												src="{{asset ('admin/img/iconPdf.svg')}}" /> {{!
												empty($userDocument->passport_doc) ?
												$userDocument->passport_doc : ''}}
											</a> <img class="iconCross"
												src="{{asset ('admin/img/crossIcon.svg')}}" />
										</p>
									</div>
									<div class="col-sm-8"></div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-12">
										<p class="mb-0 font-semibold">Lor Document</p>
										<p class="attachmentLink text-muted mb-0">
											<a class="applicationLink"
												href="{{$userDocument->getfile($userDocument->lor)}}"
												target="_blank"> <img
												src="{{asset ('admin/img/iconPdf.svg')}}" /> {{!
												empty($userDocument->lor) ? $userDocument->lor : ''}}
											</a> <img class="iconCross"
												src="{{asset ('admin/img/crossIcon.svg')}}" />
										</p>
									</div>
									<div class="col-sm-8"></div>
								</div>
							</div>
						</div>





					</div>
				</div>
			</div>
		</div>

	</div>
	<script>
$(document).ready(function(){
function resetForm() 
{
    $('#files')[0].reset(); 
  
    theEditor.setData('');
}
   var objDiv = document.getElementById("messageListing");
   objDiv.scrollTop = objDiv.scrollHeight;
   
 	var spinner = $('#loader');
	 $("#files").submit(function(e){
	 
	 e.preventDefault();
	 $('#error').text('');
	 var formData = new FormData(this);
            $.ajax({
              method: 'post',
              url:"{{route('messageAdmin')}}",
              data:formData,
              contentType:false,
              processData:false,
              headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
              success:function(data){
              spinner.hide();
               $('.messageListing').html(data);
               var objDiv = document.getElementById("messageListing");
               objDiv.scrollTop = objDiv.scrollHeight;
               resetForm();
           }
         })
  	});
 });
	
	
	
	
	
// Function to create a new message item with the given content
function createMessageItem(content, isSelf) {
  const li = document.createElement('li');
  li.classList.add('mb-3');

  const div = document.createElement('div');
  div.classList.add('d-flex');
  div.classList.add(isSelf ? 'justify-content-end' : 'justify-content-start');
  div.classList.add('align-items-center');

  const messageP = document.createElement('p');
  messageP.textContent = content;
  messageP.classList.add('m-0');
  div.appendChild(messageP);

  if (isSelf) {
    const img = document.createElement('img');
    img.src = 'https://via.placeholder.com/50';
    img.alt = 'Avatar';
    img.classList.add('rounded-circle');
    img.classList.add('ms-3');
    
    // Append image after message
    div.appendChild(img);
  }

  if (!isSelf) {
    const img = document.createElement('img');
    img.src = 'https://via.placeholder.com/50';
    img.alt = 'Avatar';
    img.classList.add('rounded-circle');
    img.classList.add('me-3');
    div.appendChild(img);
  }

  li.appendChild(div);

  return li;
}

// Function to send a new message
function sendMessage() {
  const messageInput = document.getElementById('messagesinput');
  const messageList = document.querySelector('.list-unstyled');
  

  if (messageInput.value.trim() === '') {
    return;
  }

  const messageItem = createMessageItem(messageInput.value, true);

  messageList.appendChild(messageItem);

  messageInput.value = '';
}


</script>

	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link
		href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
		rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous"></script>
	<script
		src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script
		src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
	<style>
.ck-editor__editable {
	min-height: 100px;
	min-weight: 100%;
}
</style>
	<script>

   ClassicEditor
    .create( document.querySelector( '#messagesinput' ),{
    	removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
    })
    .then(editor => {
           editor.model.document.on('change:data', () => {
           
           $('#messagesinput').val(editor.getData());
           removePlugins: ['image', 'uploadimage'];
          	theEditor = editor;  
          })
          
       })
    
    .catch( error => {
        console.error( error );
    } );
</script>

</div>