<html lang="en">
	<head>
		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<!-- Font Awesome CDN for icons-->
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

		<!-- Custom CS link -->
		<link rel="stylesheet" href="css/newtruck.css">

		<!-- jQuery, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!--Google Fonts-->
		<link href="https://fonts.googleapis.com/css?family=Contrail+One|Roboto" rel="stylesheet">

		<title>newtruck</title>
	</head>

	<body>
		<div class="container">
		<h1 class="new-truck-title">Enter your truck into our system</h1>

		<form [formGroup]="newTruckForm" (ngSubmit)="createNewTruckForm();">
			<div class="form-group">
				<label for="truck-name" class="new-truck-text">Name of your truck</label>
				<input id="truck-name" class="new-truck-input" type="text" name="truckname" formControlName="truckName">
			</div>
			<div class="form-group">
				<label for="truck-bio" class="new-truck-text">Tell us about your truck</label>
				<textarea id="truck-bio" class="new-truck-input" rows="6" type="text" name="truckbio" placeholder="Briefly describe your business..." formControlName="truckBio"></textarea>
			</div>
			<div class="form-group">
				<label for="truck-phone" class="new-truck-text">Phone number for your truck</label>
				<input id="truck-phone" class="new-truck-input" type="text" name="truckphone" formControlName="truckPhone">
			</div>
			<div class="form-group">
				<label for="truck-url" class="new-truck-text">Your truck's website</label>
				<input id="truck-url" class="new-truck-input" type="text" name="truckurl" placeholder="Business site, YELP page, etc..." formControlName="truckUrl">
			</div>
			<div>
				<button class="btn btn-block btn-warning newTruckSubmit mb-3" type="submit">Register Your Truck!</button>
			</div>
		</form>
		</div>
	</body>

</html>