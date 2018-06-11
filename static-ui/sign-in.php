<html lang="en">
	<head>
		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<!-- Font Awesome CDN for icons-->
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

		<!-- Custom CS link -->
		<link rel="stylesheet" href="css/sign-in.css">

		<!-- jQuery, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!--Google Fonts-->
		<link href="https://fonts.googleapis.com/css?family=Contrail+One|Roboto" rel="stylesheet">


		<title>sign-in</title>
	</head>

	<body>

		<div class="container">
		<h1 class="sign-in-title">Sign-In</h1>
		<form [formGroup]="signInForm" (ngSubmit)= "createSignIn();" novalidate >

			<div class="form-group">
				<label for="sign-in-email" class="sign-in-text">Email Address</label>
				<br>
				<input id="sign-in-email" class="sign-in-input" type="text" name="enteremail" formControlName="profileEmail">
			</div>

			<div class="form-group">
				<label for="sign-in-password" class="sign-in-text">Password</label>
				<br>
				<input id="sign-in-password" class="sign-in-input" type="password" name="enterpassword" formControlName="profilePassword">
			</div>

			<button type="submit" class="btn btn-block btn-warning signInSubmit mb-3">Sign In</button>

		</form>
		</div>



	</body>
</html>