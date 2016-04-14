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
<div class="container page-heading" id="startchange">
  <h1>MATCHES</h1>
</div>

<div class="container no-side-padding">
@foreach ($matches as $match)
<div class="panel panel-default match-card">
  <div class="panel-heading">
  	<a href="/match/{{$match->id}}" class="u-flex-space-between"><span>#{{$match->id}} - {{ucfirst($match->game->name)}}</span> <i class="material-icons pull-right">arrow_forward</i></a></div>
  <div class="panel-body">
	  @foreach ($match->teams as $idx => $team)
	<ul class="list-group">
	  <li class="list-group-item match-card-team-name">
	    <div class="u-flex-start"><span class="img-circle team-logo team_style_{{$team->style}}"></span><span>{{$team->name}}</span></div>
	  </li>
	  <li class="list-group-item match-card-teammates">
		  @foreach ($team->users as $team_user)
		  <img class="img-circle team-captain-avatar" src="{{$team_user->user->avatar}}">
		  @endforeach
	  </li>
	  <li class="list-group-item text-center">
	  	<div class="btn-group btn-group-sm match-card-team-form" role="group" aria-label="Small button group"> 
			<form action="/team/{{$team->id}}" method="POST">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
		    @if ($team->user_on_team)
				<input type="hidden" name="mode" value="leave" />
			    <input type="submit" type="button" value="Leave Team" class="btn btn-default btn-red match-card-team-btn" />
		    @elseif (!$match->user_in_match)
			    <input type="submit" type="button" value="Join Team" class="btn btn-default" /> 
		    @endif
			</form>
		</div>
	  </li>
	</ul>
			@if ($idx < count($match->teams) - 1)
				<div class="text-center vs">VS.</div>
			@endif

	  @endforeach
	@if (!$match->user_in_match)
	<ul class="list-group make-new-team">
        <li class="list-group-item text-center">
            <div class="make-team-btn-desc">Want to start your own team?</div>
            <div class="btn-group btn-group-sm match-card-team-form" role="group" aria-label="Small button group">
	            <form action="/team" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="match_id" value="{{$match->id}}" />
					<input type="submit" type="button" value=" Make A New Team" class="btn btn-default match-card-team-btn" />
				</form>
            </div>
        </li>
    </ul>
	@endif
  </div>
</div>
@endforeach
	<div class="new-match-creator">
	<form action="/match" method="POST" class="u-flex-grow-auto">
	<span class="u-flex-grow-auto">

		<span style="font-weight: 500;font-size:13px;">Start&nbsp;New&nbsp;Game:</span>
		{{ csrf_field() }}
		<select name="game_id" class="form-control">
		  @foreach ($games as $game)
			  <option value="{{$game->id}}">{{ucfirst($game->name)}}</option>
		  @endforeach
		</select>
		</span>
		<input type="submit" value="Go" class="btn btn-default u-flex-grow-auto" />
	</form>
	</div>
	<div class="container footer">
        Made with <i class="material-icons">favorite_border</i> by SR Product Engineering
    </div>
</div>

@if (!empty($matches[0]))
<input type="hidden" name="hidden_leaderboard_time" value="{{$matches[0]->competition->updated_at}}" />
@endif

@stop



@section('refreshers')
@if (!empty($matches[0]))
overlyComplexButBeautifulFunction('/refresher/leaderboard/', 5, 'hidden_leaderboard_time');
@endif
@stop