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
  	<a href="javascript:;" class="u-flex-space-between"><span>Personal Stuff</span></a>
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
  	<a href="/match" class="u-flex-space-between"><span>MY MATCHES</span></a>
  </div>

  <div class="panel-body">

	@foreach ($matches as $match)
	<ul class="list-group">

	    <li class="list-group-item match-card-team-name">
	      <div class="u-flex-start"><span>#{{$match->id}} - {{ucfirst($match->game->name)}}</span></div>
	    </li>

		@foreach ($match->teams as $team)
		    <li class="list-group-item match-card-teammates">
		      <div class="u-flex-start"><span class="img-circle team-logo team_style_{{$team->style}}"></span><span>{{$team->name}}</span></div>
		    </li>

		    @if ($team->user_on_team)
		    <li class="list-group-item text-center">
				@if ($match->status == 'won')
					<strong>You won this game!</strong><br>{{$user->today_points}}
				@elseif ($match->status == 'complete')

				@elseif ($match->status == 'in-progress')
			      <div class="btn-group btn-group-sm match-card-team-form" role="group" aria-label="Small button group">
		            <a href="/match/{{$match->id}}" class="btn btn-default match-card-team-btn">View this Match</a>
			      </div>
				@endif
			</li>
			
			@endif
		@endforeach
	</ul>
	<div class="game-timestamp">{{$match->created_at->diffForHumans()}}</div>
  	@endforeach
</div>

<div class="container footer">
  Made with <i class="material-icons">favorite_border</i> by SR Product Engineering
</div>

@stop
