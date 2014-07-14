<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Title</title>
		<meta charset="UTF-8">
		<meta name=description content="">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/css/site.css" rel="stylesheet" media="screen"/>
	</head>
	<body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <a class="navbar-brand" href="#">Migration Status Tool</a>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Status Utility <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('tools/status-update-utility') }}">Run Utility</a></li>
                            <li><a href="{{ URL::to('tools/status-update-utility/logs') }}">Logs</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

		<div class="container">
            @yield('content')
		</div>

		@include('layouts/partials/footer')
	</body>
</html>