<html lang="en">
	<head>
		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
				integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<!-- Font Awesome CDN for icons-->
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"
				  integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe"
				  crossorigin="anonymous"></script>

		<!-- Custom CS link -->
		<link rel="stylesheet" href="css/sign-up.css">

		<!-- jQuery, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"
				  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
				  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
				  crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
				  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
				  crossorigin="anonymous"></script>

		<!--Google Fonts-->
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">

		<title>sign-up</title>
	</head>

	<body>
		<div class="container">
			<div class="mx-auto">
				<h1 class="sign-up-title">Sign up with us!</h1>

				<form [formGroup]="signUpForm" (ngSubmit)="createSignUp();" novalidate>


					<!--First name-->
					<div class="form-group">
						<label for="sign-up-first-name" class="sign-up-text">First Name</label>
						<input id="sign-up-first-name" class="sign-up-input" type="text" name="firstname"
								 formControlName="profileFirstName">
					</div>
					<div
						*ngIf="signUpForm.controls.profileFirstName?.invalid && signUpForm.controls.profileFirstName?.touched"
						class="alert alert-danger signUpAlert" role="alert">
						<p *ngIf="signUpForm.controls.profileFirstName?.errors.required">First name is required.</p>
						<p *ngIf="signUpForm.controls.profileFirstName?.errors.maxlength">First name is too long</p>
					</div>

					<!--Last name-->
					<div class="form-group">
						<label for="sign-up-last-name" class="sign-up-text">Last Name</label>
						<input id="sign-up-last-name" class="sign-up-input" type="text" name="lastname"
								 formControlName="profileLastName">
					</div>
					<div
						*ngIf="signUpForm.controls.profileLastName?.invalid && signUpForm.controls.profileLastName?.touched"
						class="alert alert-danger signUpAlert" role="alert">
						<p *ngIf="signUpForm.controls.profileLastName?.errors.required">Last name is required.</p>
						<p *ngIf="signUpForm.controls.profileLastName?.errors.maxlength">Last name is too long</p>
					</div>


					<!--Username-->
					<div class="form-group">
						<label for="sign-up-username" class="sign-up-text">Username</label>
						<input id="sign-up-username" class="sign-up-input" type="text" name="username"
								 formControlName="profileUserName">
					</div>
					<div
						*ngIf="signUpForm.controls.profileUserName?.invalid && signUpForm.controls.profileUserName?.touched"
						class="alert alert-danger signUpAlert" role="alert">
						<p *ngIf="signUpForm.controls.profileUserName?.errors.required">Profile username is required.</p>
						<p *ngIf="signUpForm.controls.profileUserName?.errors.maxlength">Profile username is too long</p>
					</div>


					<!--Email address-->
					<div class="form-group">
						<label for="sign-up-email" class="sign-up-text">Email Address</label>
						<input id="sign-up-email" class="sign-up-input" type="text" name="email"
								 formControlName="profileEmail">
					</div>
					<div
						*ngIf="signUpForm.controls.profileEmail?.invalid && signUpForm.controls.profileEmail?.touched"
						class="alert alert-danger signUpAlert" role="alert">
						<p *ngIf="signUpForm.controls.profileEmail?.errors.required">Email is required.</p>
						<p *ngIf="signUpForm.controls.profileEmail?.errors.email">Email username is too long</p>
					</div>


					<!--Password-->
					<div class="form-group">
						<label for="sign-up-password" class="sign-up-text">Password</label>
						<input id="sign-up-password" class="sign-up-input" type="password" name="password"
								 formControlName="profilePassword">
					</div>
					<div
						*ngIf="signUpForm.controls.profilePassword?.invalid && signUpForm.controls.profilePassword?.touched"
						class="alert alert-danger signUpAlert" role="alert">
						<p *ngIf="signUpForm.controls.profilePassword?.errors.required">Password is required.</p>
						<p *ngIf="signUpForm.controls.profilePassword?.errors.maxlength">Password username is too long</p>
					</div>


					<!--Confirm password-->
					<div class="form-group">
						<label for="sign-up-confirm-password" class="sign-up-text">Confirm Password</label>
						<input id="sign-up-confirm-password" class="sign-up-input" type="password" name="confirmpassword"
								 formControlName="profilePasswordConfirm">
					</div>
					<div
						*ngIf="signUpForm.controls.profilePasswordConfirm?.invalid && signUpForm.controls.profilePasswordConfirm?.touched"
						class="alert alert-danger signUpAlert" role="alert">
						<p *ngIf="signUpForm.controls.profilePasswordConfirm?.errors.required">Password is required.</p>
						<p *ngIf="signUpForm.controls.profilePasswordConfirm?.errors.maxlength">Password username is too long</p>
					</div>

					<!--button-->
					<button type="submit" class="btn btn-block btn-warning mb-3 signUpSubmit">Sign Up</button>
				</form>
			</div>
		</div>
	</body>

</html>