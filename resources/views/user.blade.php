@extends('layouts.master')

<!--
Display one match
	- the teams on each with the members
	- button to select a winner
-->

@section('content')

<div class="container page-heading" id="startchange">
  <h1>MY PROFILE</h1>
</div>

<div class="container no-side-padding">

<div class="panel panel-default match-card personal-info">
  <div class="panel-heading">
  	<a href="/match/20" class="u-flex-space-between"><span>Personal Stuff</span></a>
  </div>
  <div class="panel-body">
	<ul class="list-group">
		<li class="list-group-item match-card-teammates">
	      <div class="u-flex-start"><img class="img-circle" src="{{$user->avatar}}"><span>{{$user->name}}</span></div>
	    </li>
	</ul>
  </div>
</div>

<div class="panel panel-default match-card personal-info">

  <div class="panel-heading">
  	<a href="/match/20" class="u-flex-space-between"><span>MY GAMES</span></a>
  </div>

  <div class="panel-body">

	@foreach ($matches as $match)

	<ul class="list-group">

	    <li class="list-group-item match-card-team-name">
	      <div class="u-flex-start"><span>{{$match->game->name}}</span></div>
	    </li>

		@foreach ($match->teams as $team)
		    <li class="list-group-item match-card-teammates">
		      <div class="u-flex-start"><span class="img-circle team-logo team_style_3"></span><span>{{$team->name}}&#039;s Team</span></div>
		    </li>

		    <li class="list-group-item text-center">
				@if ($match->status == 'won')
					<strong>You won this game!</strong><br>{{$user->today_points}}
				@elseif ($match->status == 'complete')
			      <div class="btn-group btn-group-sm match-card-team-form" role="group" aria-label="Small button group">
			        <form action="/team/29" method="POST">
			          <input type="hidden" name="_token" value="U6IIhveE3D8HAkT6MiJRcWXT94nCwYSEkMlmV2oy">
			          <input type="hidden" name="_method" value="PUT">
			          <input type="hidden" name="mode" value="leave" />
			            <input type="submit" type="button" value="View this Game" class="btn btn-default match-card-team-btn" />
			        </form>
			      </div>
				@elseif ($match->status == 'in-progress')

				@endif
			</li>
		@endforeach
			</ul>
		<div class="game-timestamp">{{$match->created_at->diffForHumans()}}</div>
  	@endforeach
</div>

<div class="container footer">
  Made with <i class="material-icons">favorite_border</i> by SR Product Engineering
</div>

@stop
