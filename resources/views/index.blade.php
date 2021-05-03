<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="De tafels oefenen voor de basisschool met resultaat analyse en selectie">
	<meta name="keywords" content="tafels oefenen basisschool">
	<script src="{{ asset('js/jquery.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="{{ asset('js/index.js') }}"></script>
	<script src="https://kit.fontawesome.com/a5576b9dc6.js" crossorigin="anonymous"></script>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>De tafels</title>
</head>
<body>
	
<div class="container_wrapper">
	<div class="container_main">	
		<div class="container_login">
			<div class="container_login-name"><span id="greetingJs"></span>&nbsp; {{ Auth::user()->name }}</div>
			<div class="container_login-button"><a class="button-logout" href="/logout">uitloggen</a></div>
		</div>
		<div class="container_index">
			<div class="container_title">
				<h1 class="title">De tafels oefenen</h1>
				<div class="container_image-absolute-left">
					<img class="image" src="{{ asset('img/tafeluil2.png') }}" alt="tafels">
				</div>
			</div>
			<div class="container_table">
				<table class="table table-striped">
					<tr>
						<th class="text-center">Oefening</th>
						<th>Tafels</th>
						<th class="hide-field">Volgorde</th>
						<th class="show-field">V</th>
						{{-- <th>Tijdslimiet</th> --}}
						<th class="text-center">Totaal</th>
						<th class="text-center">Gedaan</th>
						<th class="text-center">Klaar</th>
						<th class="text-center">Start</th>
						<th class="text-center">Bekijk</th>
						<th class="hide-field">Laatste keer</th>
					</tr>
					@foreach( $events as $event)
						<tr>
							<td class="text-center">{{ $event->id }}</td>
							<td title="selected tables:F=Fault:T=time:..s=seconds">{{ $event->tables }}</td>
							<td class="hide-field">@if( $event->selectorder == "normal" ) Normaal
								@elseif( $event->selectorder == "reverse" ) Omgekeerd
								@else Willekeurig
								@endif
							</td>	
							<td class="show-field">@if( $event->selectorder == "normal" ) N
								@elseif( $event->selectorder == "reverse" ) O
								@else W
								@endif
							</td>	
							{{-- <td>{{ $event->timelimit }}</td> --}}
							<td class="text-center">{{ $event->totalsums }}</td>
							<td class="text-center">{{ $event->status }}</td>
							<td class="text-center">@if ( $event->finished == 1 ) 
									<span class="green icon-freeze"><i class="fas fa-check"></i></span>
								@else
									<span class="orange icon-freeze"><i class="far fa-pause-circle"></i></span>
								@endif
							</td>	
							<td class="text-center">@if ( $event->finished != 1 ) 
									<a class="icon" href="/play/{{ $event->id }}"><span><i class="fas fa-play"></i></span></a>
								@endif
							</td>
							<td class="text-center"><a class="icon1" href="/showresults/{{ $event->id }}"><span><i class="fas fa-eye"></i></span></a></td>
							<td class="hide-field" title="Aangemaakt op {{ $event->created_at }}">{{ $event->updated_at }}</td>
						</tr>
					@endforeach	
				</table>
			</div>	{{-- container table  --}}
			<div class="container_pagination">
				<div id="pagination center" class="col-12 text-center justify-content-center">{{ $events->links() }}</div>
			</div>
			@if(empty($events)) 
				<div class="container_empty">
					Nog geen historie
				</div>
			@endif
			<div>
				<a class="button-click" href="\events\create">Nieuwe oefening</a>
			</div>
		</div>	{{-- container index --}}
		<h6 class="blafco">gemaakt door<a href="https://www.blafco.nl">&nbsp;www.blafco.nl</a></h6>
	</div>	{{-- container main  --}}
</div>	{{-- container wrapper --}}

</body>
</html>