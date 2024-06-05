
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token"
	content="lxeP5Z2YufV1VjHeTuCVS959RF3hncLmkCcjyQqC">

<title>Eduvice</title>

<!-- Fonts -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<!-- Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="https://eduvice.softuvo.click/css/app.css">
<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
	integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
	crossorigin="anonymous"></script>
<script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
	integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	crossorigin="anonymous"></script>
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
	integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	crossorigin="anonymous"></script>
<script src="https://eduvice.softuvo.click/js/app.js"></script>
</head>
<body>
	<div class="font-sans text-gray-900 antialiased">
		<div class="loginMain">
			<div class="form-Imgsection">
				<img src="https://eduvice.softuvo.click/images/loginImg.svg" />
			</div>
			<div class="form-section">
				<div
					class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
					<div>
						<!-- <a href="/">
    <svg class="w-16 h-16" viewbox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11.395 44.428C4.557 40.198 0 32.632 0 24 0 10.745 10.745 0 24 0a23.891 23.891 0 0113.997 4.502c-.2 17.907-11.097 33.245-26.602 39.926z" fill="#6875F5"/>
        <path d="M14.134 45.885A23.914 23.914 0 0024 48c13.255 0 24-10.745 24-24 0-3.516-.756-6.856-2.115-9.866-4.659 15.143-16.608 27.092-31.75 31.751z" fill="#6875F5"/>
    </svg>
</a>
 -->
						<img src="https://eduvice.softuvo.click/images/logo.svg" />
					</div>

					<div
						class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
						<form method="POST" action="{{route('password')}}"
							class="loginForm">
							@csrf <input type="hidden" name="token" value="<?=$token?>" />
							<div class="passwordSection">
								<label class="block font-medium text-sm text-gray-700"
									for="email"> New Password </label> <input
									class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
									type="password" name="new_password" placeholder="New Password"
									id="password" required>
									<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>

							<div class="mt-4 passwordSection">
								<label class="block font-medium text-sm text-gray-700"
									for="password"> Confirm Password </label> <input
									class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
									type="password" name="confirm_password"
									placeholder="Confirm Password" id="confirm_password" required>
									<span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>


							<div class="flex items-center justify-end mt-4">


								<button type="submit"
									class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4 btn-login">
									Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>

	<script>
		$(".toggle-password").click(function() {
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
			input.attr("type", "text");
			} else {
			input.attr("type", "password");
			}
		});
	</script>
</body>
</html>

