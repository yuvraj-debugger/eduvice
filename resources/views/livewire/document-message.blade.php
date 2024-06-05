<div class="messageSection">
	<div class="col-md-12">
		<h2 class="mb-3">Messages</h2>
	</div>
	<div class="messageListWrap">
    	<div class="row">
    		<div class="col-12">
    			<div class="card">
    				<div class="card-header text-center">User Message</div>
    				<div class="card-body" id="message-list">
    					<ul class="list-unstyled">
    					<?php 
    					 foreach ($message_id as $messages ){
    					     if(! empty($messages->getStudent)){
    					     if($messages->getStudent->role =='student'){
    					     ?>
    							<li class="mb-3">
    							<div class="d-flex justify-content-start align-items-center">
    								<img src="https://via.placeholder.com/50" alt="Avatar"
    									class="rounded-circle me-3">
    								<div>
    
    									<p class="m-0"><?=$messages->message?></p>
    
    								</div>
    							</div>
    						</li>
    							<?php 
    					     }}else{?>
    							<li class="mb-3">
    							<div class="d-flex justify-content-end align-items-center">
    								<div>
    									<p class="m-0"><?=$messages->message?></p>
    								</div>
    								<img src="https://via.placeholder.com/50" alt="Avatar"
    									class="rounded-circle ms-3">
    							</div>
    						</li>
    						<?php } }
    					?>
    					</ul>
    				</div>
    				<div class="card-footer">
    					<form action="{{route('messageAdmin')}}" method="post">
    						@csrf
    						<div class="row">
    						<div class="col-12">
    						<input type="hidden" name="document_id" value="<?=! empty($messages) ? $messages->document_id : ''?>" id="document_id"/>
    							<input type="text" class="form-control" name="message"
    								placeholder="Type your message" id="message-input">
    								</div>
    								<div class="col-12 text-right mt-2">
    							<button type="submit" class="btn btn-primary">Send</button>
    								</div>
    								</div>
    					
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>
</div>
<script>
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
  const messageInput = document.getElementById('message-input');
  const messageList = document.querySelector('.list-unstyled');
  

  if (messageInput.value.trim() === '') {
    return;
  }

  const messageItem = createMessageItem(messageInput.value, true);

  messageList.appendChild(messageItem);

  messageInput.value = '';
}


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<style>
.ck-editor__editable {
    min-height: 100px;
    min-weight:100%;
}
</style>
<script>

   ClassicEditor
    .create( document.querySelector( '#message-input' ) )
    .then(editor => {
           editor.model.document.on('change:data', () => {
           $('#message-input').val(editor.getData());
          })
       })
    
    .catch( error => {
        console.error( error );
    } );
</script>
