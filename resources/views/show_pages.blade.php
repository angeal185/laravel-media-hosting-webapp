@extends('layouts.app')
@section('title')
{{ $page_title }} | {{$setting->website_name}}
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="row" style="margin-bottom: 50px">
			<div class="content_p">			
				<div class="p_title">
					<h3>{{ $page_title }}</h3>
				</div>
				<div class="content" style="text-align: left;">
					{!! $page_content !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

