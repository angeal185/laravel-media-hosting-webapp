<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="utf-8" />
<?php
$get_settings = DB::table('settings')->where('id', 1)->first();
$favicon = $get_settings->favicon;
$logo    = $get_settings->logo;
$title   = $get_settings->website_name;
?>
<title>{{$title}} | Dashboard</title>
<meta name="robots" content="noindex">
@if ($favicon == "nofavicon.png")
<link rel="icon" href="{{ url('/') }}/uploads/settings/nofavicon.png"> @else
<link rel="icon" href="{{$favicon}}"> @endif
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
@include('includes.back.head')
</head>
<body class="page-md page-header-fixed page-quick-sidebar-over-content">
<div class="page-container">
@include('includes.back.header')
@include('includes.back.sidebar')

@yield('content')
@include('includes.back.footer')
</div>
@include('includes.back.scripts')
</body>
</html>