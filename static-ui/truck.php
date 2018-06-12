<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Font Awesome CDN for icons-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

    <!-- Custom CS link -->
    <link rel="stylesheet" href="css/truck.css">

    <!-- jQuery, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Contrail+One|Roboto" rel="stylesheet">

    <!--Actual page begins-->
    <title>Truck Details</title>
</head>
<body>
	<div class="truck-display">
		<div class="container contact">
			<h1 class="truck-title">{{truck.truckName}}</h1>
			<p class="truck-text"><i class="fas fa-check fa-lg"></i>{{truck.truckIsOpen | open }}</p>
			<p class="truck-text">{{truck.truckPhone}}</p>
			<p class="truck-text"><a href="{{truck.truckUrl}}" class="truck-url-link">{{truck.truckUrl}}</a></p>
		</div>
		<div class="container bio">
			<div class="Aligner">
				<div class="Aligner-item">
					<p class="truck-text">{{truck.truckBio}}</p>
					<!--<p><strong>#</strong>{{truck}}<strong></p>-->
				</div>
			</div>
		</div>

		<!--favorite-->
		<div class="container">
		<div class="Aligner-item--bottom">

			<!--create a favorite if it does not exist-->
			<button *ngIf="favorite === null " type="button" class="btn btn-outline-warning" (click)="createFavorite()">
				<i class="fas fa-star fa-lg"></i></button>

			<!--delete favorite if it exists-->
			<button *ngIf="favorite !== null" type="button" class="btn btn-outline-warning" (click)="deleteFavorite()">
				<i class="far fa-star fa-lg"></i></button>

			<!--votes-->
			<button type="button" class="btn btn-outline-warning" (click)="createVote(1)"><i class="fas fa-arrow-alt-circle-up fa-lg"></i>{{ truckVote.upVote }}</button>
			<button type="button" class="btn btn-outline-warning" (click)="createVote(-1)"><i class="fas fa-arrow-alt-circle-down fa-lg"></i>{{ truckVote.downVote }} </button>
		</div>
		</div>
	</div>
</body>

