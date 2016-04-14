<html>
    <head>
        <title><?=Config::get('app.name')?></title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">        
 
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- GameNight CSS -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Oswald:300,400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/gamenight.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
       

    </head>
    <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><span style="color:#C73B28">Game</span>Night</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
	            <li class="{{($tab=="leaderboard") ? 'active' : ''}}"><a href="/">Leaderboard</a></li>
	            <li class="{{($tab=="matches") ? 'active' : ''}}"><a href="/match">Matches</a></li>
	            @if (Auth::check())
	            <li class="{{($tab=="profile") ? 'active' : ''}}"><a href="/user">Profile</a></li>
				@else
	            <li><a href="/login">Login</a></li>
				@endif
			</ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    
@if (!empty($message))
    <div class="alert alert-info">{{$message}}</div>
@endif

@yield('content')



    </body>
<script type="text/javascript">
$( document ).ready(function() {

@yield('refreshers')

function overlyComplexButBeautifulFunction(url, numericValue, inputName) {
console.log('y');
    $.ajax({
        url: url,
        success: function(data) {
            var inputValue = $('input[name='+inputName+']').val();
console.log(data.updatedAt);
console.log(inputValue);

            if (data.updatedAt !== inputValue) {
                location.reload();
            }
        },
        always: function() {
console.log('x');
            setTimeout(overlyComplexButBeautifulFunction, (numericValue * 1000));
        }
    });
}
});
</script>

</html>