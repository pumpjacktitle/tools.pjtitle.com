<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
            @section('pageTitle')
            @show
        </title>
		<meta charset="UTF-8">
		<meta name=description content="">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/css/site.css" rel="stylesheet" media="screen"/>

        @section('styles')
        @show
	</head>
	<body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Data Entry Samples</a>
            </div>
        </nav>

		<div class="container-fluid">
            @yield('content')
		</div>

		@include('layouts/partials/footer')
	</body>
</html>