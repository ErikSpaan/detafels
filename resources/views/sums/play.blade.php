<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="De tafels oefenen voor de basisschool">
	<meta name="keywords" content="tafels oefenen basisschool">
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/sums.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/play.css') }}">
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="https://kit.fontawesome.com/a5576b9dc6.js" crossorigin="anonymous"></script>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>De tafels</title>
</head>
<body>

<!-- detects if phone/tablet -->
@include('sums/mobiledetection')
<div class="container_wrapper">
	<div class="container_main">
		<div class="container_play">	
			<div class="container_title">
				<h1>Oefenen tafels:</h1>
				<h2>{{ $whichtables }}</h2>
				<div class="container_image_absolute-right">
					<img class="image" src="{{ asset('img/tafeluil2.png') }}" alt="tafels">
				</div>
			</div>
			<div class="container_play-intern">
				<div class="container_sum">
					<form name="mysum" id="playform" method="POST" action="\sums\{{ $sum->id }}">
						@csrf
						@method('PATCH')
						<label class="label_sum" for="answer">{{ $sum->number }} x {{ $sum->table }} = </label>
						@if (session('mobileDetection') == "yes") 
							<input oninput="message()" oninput="maxLengthCheck(this)" 
								id="focusJs" class="field_answer" pattern="[0-9]*" inputmode="numeric" 
								type="number" name="answer" maxlength="3" min="0" max="1000" autofocus readonly>
						@endif	
						@if (session('mobileDetection') == "no") 
							<input oninput="message()" oninput="maxLengthCheck(this)" 
								id="focusJs" class="field_answer" pattern="[0-9]*" inputmode="numeric" 
								type="number" name="answer" maxlength="3" min="0" max="1000" autofocus>
						@endif	
					</form>
				</div>
				@if(!empty($message))
					<div class="container_answer-false">
						<div id="message" class="answer_false">{{ $message ?? '' }}</div>
					</div>	
				@endif
				@if ( $errors->any() )
					<div class="container_message-error">
						<div class="message_error">
							@foreach ($errors->all() as $error)
    			    			<li>{{ $error }}</li>
    			        	@endforeach
						</div>
					</div>	
				@endif
				<div class="container_button">
					<a class="button-click" href="/pauze/{{ $sum->id }}">pauze</a>
				</div>
				<div class="container_sumstogo">
					<h6>{{ $countmysums }} van de {{ $totalsums }}</h6>
				</div>
			</div>	{{-- end play intern --}}
			<div class="keyboard">
				<div class="keyboard-row">
					<div class="digit">1</div>
					<div class="digit">2</div>
					<div class="digit">3</div>
					<div class="digit">X</div>
				</div>
				<div class="keyboard-row">
					<div class="digit">4</div>
					<div class="digit">5</div>
					<div class="digit">6</div>
					<div class="digit">Ga</div>
				</div>
				<div class="keyboard-row">
					<div class="digit">7</div>
					<div class="digit">8</div>
					<div class="digit">9</div>
					<div class="digit-blanc"></div>
				</div>
				<div class="keyboard-row">
					<div class="digit-blanc"></div>
					<div class="digit">0</div>
					<div class="digit-blanc"></div>
					<div class="digit-blanc"></div>
				</div>
			</div>
		</div>	{{-- end play --}}
	
	</div>	{{-- container main  --}}
</div>	{{-- container wrapper --}}

</body>
</html>