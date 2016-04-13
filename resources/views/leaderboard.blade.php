@extends('layouts.master')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@stop

@section('content')
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