<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="De tafels oefenen voor de basisschool">
	<meta name="keywords" content="tafels oefenen basisschool">
	<script src="{{ asset('js/jquery.js') }}"></script>
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('css/events_create.css') }}">
	{{-- <script src="{{ asset('js/bootstrap.js') }}"></script> --}}
	<script src="{{ asset('js/events_create.js') }}"></script>
	<script src="https://kit.fontawesome.com/a5576b9dc6.js" crossorigin="anonymous"></script>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>De tafels</title>
</head>
<body>
	<div class="container_wrapper">
		<div class="container_main">	
			<div class="container_create">
				<div class="container_title">
					<h1>Een nieuwe oefening toevoegen</h1>
				</div>
				<div class="container_form">
					<form name="mytable" method="POST" action="\events">
						@csrf
						<div class="checkbox_title">Kies de tafels:</div>
						<div class="container_checkbox">
							<div class="container_checkbox_out">
								<div class="container_checkbox_in">
									@for ($i = 1; $i <= 20; $i++)
										<span class="container_checkbox-field">
											<input type="checkbox" id="table{{ $i }}" class="checkBoxJs" name="table{{ $i }}" {{ old('table'.$i) ? 'checked':'' }}>
											<label class="checkbox_label" for="checkbox{{ $i }}"> De tafel van {{ $i }}</label><br>
										</span>
									@endfor
								</div>
								<div class="container_flexcenter">
									<span class="selectall-click" id="checkBoxSelect" onclick="selectAll()">
										Selecteer alles
									</span> 
								</div>
							</div>	{{-- checkbox out  --}}
						</div>
						<div class="radiobox_title">Volgorde van de sommen:</div>
							{{-- <div class="container_flexcenter"> --}}
						<div class="container_radiobox">

								<span class="radiobox_field-center">
									<input type="radio" name="selectorder" value="normal" 
										{{ old('selectorder','normal') == 'normal' ? 'checked':'' }}>
								  	<label class="radiobox_label" for="male">Normaal</label><br>
								</span>
								<span class="radiobox_field-center">
									  <input type="radio" name="selectorder" value="reverse"
									  	{{ old('selectorder') == 'reverse' ? 'checked':'' }}>
  									<label class="radiobox_label" for="female">Omgekeerd</label><br>
								</span>
								<span class="radiobox_field-center">  
									<input type="radio" name="selectorder" value="random"
										{{ old('selectorder') == 'random' ? 'checked':'' }}>
									<label class="radiobox_label" for="other">Willekeurig</label>
								</span>
							{{-- </div> --}}
						</div>
						{{-- <label for="timelimit">Tijdslimiet in s (0 = geen tijdslimiet</label><br>
						<input type="number" name="timelimit" value="0"> --}}
						<div class="container_button">
							<input class="button-click" type="submit" value="Toevoegen">
						</div>
					</form>
				</div>
				@if ( $errors->any() )
					<div class="container_error">
						<div class="message_error">
							@foreach ($errors->all() as $error)
    			          	  <li>{{ $error }}</li>
    			        	@endforeach
						</div>
					</div>	
				@endif
			</div>	{{-- container create --}}
			<div class="container_flexcenter">
				<a class="button-click" href="/">Terug</a>
			</div>
            <h6 class="blafco">gemaakt door<a href="https://www.blafco.nl">&nbsp;www.blafco.nl</a></h6>
		</div>	{{-- container main  --}}
	</div>	{{-- container wrapper --}}
</body>
</html>