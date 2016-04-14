@extends('layouts.master')

<!--
Display one match
	- the teams on each with the members 
	- button to select a winner	
-->

@section('content')


<div class="container page-heading" id="startchange">
  <!-- <a href="" class="prev-pg-link">&larr; ALL MATCHES</a> -->
  <h1> MATCH #{{$match->id}}</h1>
</div>
<div class="container no-side-padding">
	<div class="panel panel-default match-card match-detail-card">
		<div class="panel-heading">
			<h2>{{ucfirst($match->game->name)}}</h2>
		</div>
		<div class="panel-body">
		@foreach ($match->teams as $idx=>$team)  
			<ul class="list-group">
				<li class="list-group-item match-card-team-name">
					  <div class="u-flex-start">
						  <span class="img-circle team-logo team_style_1"></span>
						  <span>{{$team->name}}</span>
					  </div>
				</li>
				@foreach ($team->users as $team_idx=>$team_user)
					<li class="list-group-item match-card-teammates">
					  <div class="u-flex-start">
						  @if ($team_idx == 0)
							  <img class="img-circle team-captain-avatar" src="{{$team_user->user->avatar}}">
						  @else 
							  <img class="img-circle" src="{{$team_user->user->avatar}}">
						  @endif
						  <span>{{$team_user->user->name}}</span>
					  </div>
					</li>
				@endforeach
				<li class="list-group-item text-center">
					<div class="btn-group btn-group-sm match-card-team-form" role="group" aria-label="Small button group">
						@if ($user_in_match)
						<form action="/match/win/{{$match->id}}" method="POST">
							{{ csrf_field() }}
							<input type="hidden" name="winning_team_id" value="{{$team->id}}" />
							@if($have_i_voted)
							<button type="button" class="btn disabled btn-primary btn-lg btn-block">Vote already cast</button>
							@else
							<button type="submit" class="btn btn-default match-card-team-btn">Declare This Team The Winner</button>
							@endif
						</form>
						@endif
					</div>
				</li>
			</ul>
			@if ($idx < count($match->teams) - 1)
				<div class="text-center vs">VS.</div>
			@endif
		@endforeach
	</div>
</div>
<div class="container footer">
	Made with <i class="material-icons">favorite_border</i> by SR Product Engineering
</div>

<input type="hidden" name="hidden_leaderboard_time" value="{{$match->competition->updated_at}}" />
<input type="hidden" name="hidden_match_time" value="{{$match->updated_at}}" />

@stop


@section('refreshers')
overlyComplexButBeautifulFunction('/refresher/leaderboard/', 5, 'hidden_leaderboard_time');
overlyComplexButBeautifulFunction('/refresher/match/{{$match->id}}', 12, 'hidden_match_time');
@stop