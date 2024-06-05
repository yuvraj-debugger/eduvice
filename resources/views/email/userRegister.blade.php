<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Register</title>
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
	rel="stylesheet">
</head>
<body style="margin: 0; font-family: 'Roboto', sans-serif;">
	<div style="width: 100%; max-width: 700px; margin: 0 auto;">
		<div
			style="background-color: #273D68; text-align: center; padding: 20px 0 80px;">
			<img style="width: 100%; max-width: 200px;" src="{{asset('images/EduvicelogoWhite.png')}}"
				alt="eduvice logo" />
		</div>

		<div style="padding: 0 50px">

			<div
				style="background-color: #f5f5f5; padding: 15px; margin-top: -40px;">
				<h3 style="margin-top: 0; color: #273D68;">Welcome</h3>
				<p>Please click the button below to verify your email address.</p>
				<div style="text-align: center;">
				
					<a href="{{route('verify',['token'=>$token])}}"
						style="background-color: #273D68; color: #fff; text-decoration: none; display: inline-block; padding: 10px 20px; border-radius: 5px;">Click to Verify</a>
				</div>

				<p style="margin-top: 30px;">
					Thanks, <br /> <span style="font-weight: 600; color: #273D68;">Team
						Eduvice</span>
				</p>
			</div>
		</div>
	</div>
</body>
</html>