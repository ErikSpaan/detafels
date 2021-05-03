<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="De tafels oefenen voor de basisschool">
	<meta name="keywords" content="tafels oefenen basisschool">
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/sums.js') }}"></script>
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('css/finished.css') }}">
	{{-- <script src="{{ asset('js/bootstrap.js') }}"></script> --}}
	<script src="https://kit.fontawesome.com/a5576b9dc6.js" crossorigin="anonymous"></script>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>De tafels</title>
</head>
<body>
	<div class="container_wrapper">
		<div class="container_main">
			<div class="container_finished">
				<div class="container_title">
					<h1 class="title">Goed gedaan,</h1>
					<h1 class="title"><span class="hide_text">&nbsp;</span>de opdracht is klaar !</h1>
				</div>
				<div class="container_image">
					<img class="image" src="{{ asset('/img/tafeluilok11.png') }}" alt="tafel uil" width=100 height=100">
				</div>	
				<div class="container_button">
					<a class="button-click" href="/">Verder</a>
				</div>
			</div>	{{-- end finished --}}
		</div>	{{-- end main --}}
	</div>	{{-- end wrapper --}}
</body>
</html>