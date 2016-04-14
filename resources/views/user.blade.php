@extends('layouts.master')

<!--
Display one match
	- the teams on each with the members 
	- button to select a winner	
-->

@section('content')


<div class="col-xs-4">
<img width="50" class="img-rounded" src="{{$user->avatar}}" alt="" />
<h4>{{$user->name}}</h4>
</div>
        
<div class="col-xs-8" style="border-left:1px solid #ccc;">

<ul class="list-group">
	@foreach ($matches as $match)
	<li class="list-group-item">
		<h5>{{$match->game->name}}
		@if ($match->win) 
		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>		
		@else 
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>		
		@endif	
			
			
		@foreach ($match->teams as $team)
			<div class="well" style="padding:5px">
				<a class="btn btn-default" href="javascript:;" role="button">{{$team->name}}</a>
				<br />
				<p>{{$team->users->implode('user.name', ',')}}</p>
			</div>
		@endforeach
		
		{{$match->created_at->diffForHumans()}}		
		
	</li>
  	@endforeach
</ul>

</div>
        
@stop

