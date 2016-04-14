@extends('layouts.master')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@stop

@section('content_old')
<p class="well">There are {{count($matches)}} <a href="/match">matches</a> in progress in games like {{$matches->implode('game.name')}}.</p>
<div data-example-id="contextual-table">
<table class="table table-striped"> 
<thead> 
	<tr> 
		<th>Position</th>
		<th>Mugshot</th>
		<th>Name</th> 
		<th>Points</th>
	</tr> 
</thead> 
<tbody> 
@foreach ($leaderboard as $index => $entry)
	<tr class="{{($index == 0) ? 'success' : ''}}"> 
		<td>{{$index+1}}</td>
		<td><img width="50" class="img-rounded" src="{{$entry->user->avatar}}" alt="{{$entry->user->name}}" /></td> 
		<td>{{$entry->user->name}}</td> 
		<td>{{$entry->points_total}}</td>
	</tr> 
@endforeach
</tbody> 
</table>
</div>
@stop

@section('content')
<div class="container page-heading" id="startchange">
	<h1>Leaderboard</h1>
</div>
<div class="container no-side-padding">
<p class="current-matches-indicator"> <a href="/match">{{count($matches)}}{{(count($matches) > 1) ? 'matches' : 'match'}} matches in progress. Check 'em out <i class="material-icons">arrow_forward</i></a></p>
<div data-example-id="contextual-table" class="table-responsive">
<table class="table table-striped table-responsive leaderboard-table">
	<thead>
		<tr>
		<th class="text-center">Rank</th>
		<!-- <th>Mugshot</th> -->
		<th>Player</th>
		<th class="text-center">Points</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($leaderboard as $index => $entry)
		<tr class="{{($index == 0) ? 'success' : ''}} {{($entry->user->id == Auth::user()->id) ? 'current-user-row' : ''}}"> 
			<td>@if($index == 0)
				<i class="material-icons gold">looks_one</i>
				@elseif($index == 1)
				<i class="material-icons silver">looks_two</i>
				@elseif($index == 2)
				<i class="material-icons bronze">looks_3</i>
				@else
				{{$index}}
				@endif
			</td>
			<td><img class="img-circle" src="{{$entry->user->avatar}}" alt="{{$entry->user->name}}"/>{{($entry->user->id == Auth::user()->id) ? 'Me' : $entry->user->name}}</td>
			<td>{{$entry->points_total}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
</div>
<div class="container footer">
Made with <i class="material-icons">favorite_border</i> by SR Product Engineering
</div>

<input type="hidden" name="hidden_leaderboard_time" value="{{$competition->updated_at}}" />
@stop


@section('refreshers')
overlyComplexButBeautifulFunction('/refresher/leaderboard/', 5, 'hidden_leaderboard_time');
@stop