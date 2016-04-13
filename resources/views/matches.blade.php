@extends('layouts.master')

<!--
Display all matches currently in action showing 
	- the teams on each with the members 
	- button to join team
	- form to create a new team
	
Form to create a new match 
	- just select a game - only input
	- automatically also makes a team and puts you on it
	- redirects you to the match view 
-->

@section('content')
<h4>Matches</h4>

@foreach ($matches as $match)
<div class="panel panel-default">
  <div class="panel-heading"><a href="/match/{{$match->id}}">Match {{$match->id}} - {{ucfirst($match->game->name)}}</a></div>
  <div class="panel-body">

	<ul class="list-group">
	  @foreach ($match->teams as $team)
	  <li class="list-group-item">
	    <span class="badge">{{$team->members}}</span>
	    <div class="btn-group btn-group-sm" role="group" aria-label="Small button group"> 
			<form action="/team/{{$team->id}}" method="POST">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
		    @if ($team->user_on_team)
				<input type="hidden" name="mode" value="leave" />
			    <input type="submit" type="button" value="Leave Team" class="btn btn-default" />
		    @else 
			    <input type="submit" type="button" value="Join Team" class="btn btn-default" /> 
		    @endif
			</form>
		</div>
	    {{$team->name}}
	  </li>
	  @endforeach
	</ul>
	<form action="/team" method="POST">
		{{ csrf_field() }}
		<input type="hidden" name="match_id" value="{{$match->id}}" />
		<input type="submit" value="New Team" class="btn btn-default" />
	</form>
  </div>
</div>
@endforeach

<form action="/match" method="POST">
	{{ csrf_field() }}
	<h6>New Match</h6>
	<select name="game_id" class="form-control">
	  @foreach ($games as $game)
		  <option value="{{$game->id}}">{{ucfirst($game->name)}}</option>
	  @endforeach
	</select>

	<input type="submit" value="Create" class="btn btn-default" />
</form>


@stop

