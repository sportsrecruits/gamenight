@extends('layouts.master')

<!--
Display one match
	- the teams on each with the members 
	- button to select a winner	
-->

@section('content')
<h4>Match {{$match->id}} - {{ucfirst($match->game->name)}}</h4>
	

@foreach ($match->teams as $team)
<div class="panel panel-default">
  <div class="panel-heading">{{$team->name}}</div>
  <div class="panel-body">

	<ul class="list-group">
		@foreach ($team->users as $team_user)
			<li class="list-group-item">
				<img width="50" class="img-rounded" src="{{$team_user->user->avatar}}" alt="{{$team_user->user->name}}" />
				{{$team_user->user->name}}
			</li>
		@endforeach
	</ul>
	<form action="/match/win/{{$match->id}}" method="POST">
		{{ csrf_field() }}
		<input type="hidden" name="winning_team_id" value="{{$team->id}}" />
		@if ($have_i_voted)
		<button type="button" class="btn disabled btn-primary btn-lg btn-block">Vote already cast</button>
		@else
		<button type="submit" class="btn btn-primary btn-lg btn-block">Declare {{$team->name}} as the winner</button>
		@endif
	</form>
  </div>
</div>
@endforeach

@stop