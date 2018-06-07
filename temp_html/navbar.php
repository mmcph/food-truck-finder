<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"/>

		<!--Custom Style-->
		<link rel="stylesheet" href="./styles/nav-style.css">

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

		<!-- Google Font-->
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">

	</head>
	<body>

		<nav class="navbar navbar-expand-lg">
			<a class="navbar-brand" id="fullSizeTitle" href="#"><img id="navLogo" src="https://i.imgur.com/Kqlj3Q7.png"></a>
<!--			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">-->
<!--				<span class="navbar-toggler-icon"></span>-->
<!--			</button>-->

<!--			<div class="collapse navbar-collapse" id="navbarSupportedContent">-->
			<div class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Food Types</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<button class="btn btn-outline-success" type="submit">Find Trucks</button>

					<!--							todo Angular insert categories into list of checkboxes-->
					<div class="dropdown-item"><input type="checkbox" title="categorySearchTerm" class="categorySearch" id="PLACEHOLDER" name="PLACEHOLDER">PLACEHOLDER</div>

					<!--								todo divider between letters in alphabetical ordering?-->
					<div class="dropdown-divider"></div>
				</div>
			</div>

<!--			USERS-->
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="SIGNUP">Sign Up</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="SIGNIN">Sign In</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="PROFILE"><i class="fas fa-user"></i></a>
					</li>
				</ul>
<!--			</div>-->
		</nav>

		<!--					DROPDOWN categories-->
	<div class="col-xs-6">


		</div>






	</body>
</html>