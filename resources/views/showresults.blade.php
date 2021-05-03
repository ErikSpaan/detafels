<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="De tafels oefenen voor de basisschool">
	<meta name="keywords" content="tafels oefenen basisschool">
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/showresults.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/showresults.css') }}">
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="https://kit.fontawesome.com/a5576b9dc6.js" crossorigin="anonymous"></script>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>De resultaten</title>
</head>
<body> 

<div class="container_wrapper">
	<div class="container_main">
		<div class="container_results">
			<div class="container_title">
				<h1 class="title">Resultaten van oefening {{ $event->id }}</h1>
			</div>	
			<div class="container_image_absolute-right">
				<img class="image" src="{{ asset('img/tafeluil2.png') }}" alt="tafels">
			</div>
			<h5 class="title-sub">De tafel van {{ $event->tables }}<h5>
			<h5 class="title-sub2">Volgorde : 	 
				{{ ($event->selectorder == 'normal') ? 'normaal' : '' }}
				{{ ($event->selectorder == 'random') ? 'willekeurig' : '' }}
				{{ ($event->selectorder == 'reverse') ? 'omgekeerd' : '' }}
			</h5>
			<div class="title-sub-date">
				<h6 class="title-sub2">Datum: {{ $lastDate }}</h6>
			</div>
			<div class="container_main-info">
				<div class="container_main-info-sub">
					<div class="info-width">
						<h6>Totaal: {{ $event->totalsums }}</h6> 
					</div>
					<div class="info-width">
						<h6>te doen: {{ $event->totalsums - $good - $false }}</h6>
					</div>
				</div>
				<div class="container_main-info-sub">
					<div class="info-width">
						<h6>Aantal goed: {{ $good }}</h6>
					</div>
					<div class="info-width">
						<h6>Aantal fout: {{ $false }}</h6>
					</div>
				</div>
			</div>	
			@if($eventsums->isEmpty())
				<div class="container_empty">
					Nog geen historie
				</div>
			@else	
				<div class="container_table">
					<table class="table table-striped">
						<tr>
							<th class="text-center">Tafel</th>
							<th class="text-center">Aantal fout</th>
							<th class="text-center">Antwoord</th>
							<th class="text-center">Resultaat</th>
							<th class="text-center">Tijd (s)</th>
							<th class="hide-date">Laatste keer</th>
						</tr>
						@foreach( $eventsums as $eventsum)
							<tr>
								<td class="text-center"><div class="table_field-width">{{ $eventsum->number }} X {{ $eventsum->table }}</div></td>
								<td class="text-center faultsJs">{{ $eventsum->faults }}</td>
								<td class="text-center">{{ $eventsum->answer }}</td>
								<td class="text-center">@if ( $eventsum->result == 1 ) <span class="green icon"><i class="fas fa-check"></i></span>
									@elseif ( $eventsum->result == 0 ) <span class="red icon"><i class="fas fa-times"></i></span>
									@else
										<span class="orange icon"><i class="far fa-pause-circle"></i></span>
									@endif
								<td class="text-center timeJs">{{ $eventsum->time }}</td>
								<td class="hide-date" title="Aangemaakt op {{ $eventsum->created_at }}">{{ $eventsum->updated_at }}</td>
							</tr>
						@endforeach	
					</table>
				</div>	{{-- container table --}}
			@endif
		</div>	{{-- container results --}}
		<div class="buttons_container">
			<div><a class="button-click" href="/">Terug</a></div>
			@if ( $event->finished != 1 && $eventsums->isNotEmpty()) 
				<div>
					<a class="button-click" href="/play/{{ $event->id }}">Start</a>
				</div>
			@endif
		</div>
		@if($eventsums->isNotEmpty())
			<div class="container_main_order-new">
				<div  class="container_order-new">
					<div  class="container_order-new-title">
						<h2>Herhaal oefening toevoegen</h2>
					</div>
					<form name="myorder" class="container_form" method="POST" action="/nieuweopdracht/{{ $event->id }}">
						@csrf
						<div class="checkbox-title">
							<span class="text-bold">Selecteer de sommen:</span>&nbsp;
							<span>(geen keuze zijn alle sommen)</span>
						</div>	
						<div class="container-checkbox">
							<input id="checkboxFaultJs" class="checkboxen" type="checkbox" name="fault" 
								onclick="showSums()" title="Selecteer de foute sommen"
							{{ old('fault') ? 'checked':'' }}><span class="box-label">fout</span>
						</div>
						<div class="container-checkbox">
							<input id="checkboxTimeJs" class="checkboxen" type="checkbox" name="time" 
								onclick="showSums()" title="Selecteer tijdsoverschrijding"
							{{ old('time') ? 'checked':'' }}><span class="box-label">tijd</span>
							<span id="secondsDown" class="seconds" onkeyup="showSums()" onclick="seconds(-1)">-</span>
							<input id="timeFrameJs" class="width-number" type="number" name="timeframe" maxlength="3" 
								value="{{ old('timeframe', 6) }}" title="Stel tijdsoverschrijding in" 
								onkeyup="showSums()" oninput="maxLengthCheck(this)">
							<span id="secondsDown" class="seconds" onkeyup="showSums()" onclick="seconds(1)">+</span>
							<span class="box-label">seconden</span>

						</div>
						<div class="container_radiobox">
							<span class="text-bold">Selecteer de volgorde van de sommen:</span><br>
							<div class="box-width">
								<input type="radio" name="selectorder" value="normal" {{ old('selectorder','normal') == 'normal' ? 'checked':'' }}>
						  		<label class="box-label" for="male">Normaal</label>
							</div>
							<div class="box-width">
								<input type="radio" name="selectorder" value="reverse" {{ old('selectorder') == 'reverse' ? 'checked':'' }}>
								<label class="box-label" for="female">Omgekeerd</label>
							</div>
							<div class="box-width">
								<input type="radio" name="selectorder" value="random" {{ old('selectorder') == 'random' ? 'checked':'' }}>
								<label class="box-label" for="other">Willekeurig</label>
							</div>
						</div>
						<input type="submit" id="button2" class="button-click2" value="Toevoegen">
					</form>	
					@if ( $errors->any() )
						<div class="container_message-error">
							<div class="message_error">
								@foreach ($errors->all() as $error)
            	  	  				<li>{{ $error }}</li>
            					@endforeach
							</div>
						</div>	
					@endif
					@if (session('message'))
						<div class="container_message-error">
							<div class="message_error">
								{{ session('message') }}
							</div>
						</div>	
					@endif
				</div>
			</div>
		@endif
		<h6 class="blafco">gemaakt door<a href="https://www.blafco.nl">&nbsp;www.blafco.nl</a></h6>
	</div>	{{-- container main  --}}
</div>	{{-- container wrapper --}}

</body>
</html>