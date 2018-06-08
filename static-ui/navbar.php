<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"/>

		<!--Custom Style-->
		<link rel="stylesheet" href="css/nav-style.css">

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

		<!-- Google Font-->
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">

		<!--Custom JS-->
		<script src="../temp_html/js/script.js"></script>

	</head>
	<body>

		<nav class="navbar navbar-expand">
			<a class="navbar-brand" id="fullSizeTitle" href="#"><span class="brandText">Food<span class="spaceToggle">&nbsp;</span>Truck<span class="spaceToggle">&nbsp;</span>Found</span></a>
			<img id="navLogo" src="https://i.imgur.com/ETGr3aA.png">
			<div class="ml-auto" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<!--CATEGORY SEARCH-->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle navTopLevel pushDown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Food Types</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<button class="btn categoryButton" type="submit">Find Trucks</button>
								<!--							todo Angular insert categories into list of checkboxes-->
							<div class="dropdown-item"><input type="checkbox" title="categorySearchTerm" class="categorySearch" *ngFor="let category of categories" id="category{{category.categoryId}}" name="category{{category.categoryId}}"><label for="category{{category.categoryId}}" class="categoryTerm" *ngFor="let category of categories">&nbsp;{{category.categoryName}}</label></div>
						</div>
					</li>
					<!--USERS-->
					<li class="nav-item dropdown">
						<a class="nav-link navTopLevel" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<div class="dropdown-item"><a href="FAVORITES" class="userText"><i class="far fa-star"></i>&nbsp;Favorites</a></div>
							<div class="dropdown-item"><a href="SIGNUP" class="userText"><i class="fas fa-user-plus"></i>&nbsp;Sign Up</a></div>
							<div class="dropdown-item"><a href="SIGNIN" class="userText"><i class="fas fa-sign-in-alt"></i>&nbsp;Sign In</a></div>
							<div class="dropdown-item"><a href="SIGNOUT" class="userText"><i class="fas fa-sign-out-alt"></i>&nbsp;Sign Out</a></div>
						</div>
					</li>
				</ul>
			</div>
		</nav>

	</body>
</html>