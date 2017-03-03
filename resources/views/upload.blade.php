@extends('layouts.app') 
@section('title') 
Upload Media | {{$setting->website_name}} 
@endsection 
@section('content')
<div class="container">
    <div class="row upload">
        <div class="upload-area">
            <main> @if(Session::has('success'))
                <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('anonymous_vid'))
                <div class="alert alert-success" role="alert"> Video has been successfully submitted, But it's not published in media page, You can only access it with a direct link: <b><a href="{{Session::get('anonymous_vid')}}">{{Session::get('anonymous_vid')}}</a></b> </div> @endif @if(Session::has('anonymous_img'))
                <div class="alert alert-success" role="alert"> Image was successfully submitted, But it's not published in media page, You can only access it with a direct link: <b><a href="{{Session::get('anonymous_img')}}">{{Session::get('anonymous_img')}}</a></b> </div> @endif @if(Session::has('error'))
                <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                <form enctype="multipart/form-data" action="{{ url('/')}}/upload" method="POST"> {!! csrf_field() !!}
                    <input id="tab1" type="radio" name="tabs" checked>
                    <label for="tab1" class="label-style active_tab" id="active_tab1 " style="margin-left: 0px"> {{Lang::get('upload.upload_image')}}</label>
                    <input id="tab2" type="radio" name="tabs">
                    <label for="tab2" class="label-style" id="active_tab2" style="margin-left: 20px">{{Lang::get('upload.upload_video')}}</label>
                    <section id="content1">
                        <p style="text-align: center;">
                            <input data-validation="required length" data-validation-length="max200" data-validation-error-msg="The maximum number of characters allowed is 200." name="titleofimg" class="text_input form-control" placeholder="{{Lang::get('upload.image_title')}}" type="text"> </p>
                        <p style="text-align: center;">
                            <select data-validation="required" data-validation-error-msg="Please select category." name="img_categories" class="text_input">
                                <option selected="" disabled="">{{Lang::get('upload.category')}}</option> @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option> @endforeach </select>
                            <br> </p>
                        <p>
                            <div id="img_upload" style="margin-bottom:15px;"> <i class="fa fa-picture-o" style="font-size:50px; color:#aaa; float:left"></i>
                                <p class="res_img_up" style="margin-left:65px; margin-bottom:6px;">
                                    <input name="img_file" type="file" data-validation="required mime size" data-validation-allowing="jpg, png, gif,jpeg" data-validation-max-size="{{ $setting->max_img_mb }}M" data-validation-optional="true">
                                </p>
                                <h4 style="color: #EFEFEF;margin-left:65px; padding-top:0px;">{{Lang::get('upload.or_url')}}</h4>
                                <p>
                                    <input data-validation="url" data-validation-optional="true" class="text_input form-control" name="img_url" placeholder="{{Lang::get('upload.image_url')}}" type="text">
                                </p>
                            </div>
                        </p> <span style="color: rgb(182, 182, 182);" id="maxlength">200</span>
                        <p>
                            <textarea data-validation="required" data-validation-error-msg="Please add an image description." id="img_description" name="img_description" class="text_input" style="resize: none;height: 120px !important" placeholder="{{Lang::get('upload.image_description')}}"></textarea>
                        </p>
                        <input class="btn-submit-post form-control" name="submit_image" value="{{Lang::get('upload.submit_image')}}" type="submit"> </section>
                    <section id="content2">
                        <input data-validation="required" name="vid_title" class="text_input form-control" placeholder="{{Lang::get('upload.video_title')}}" type="text">
                        <select name="vid_categories" class="text_input">
                            <option selected="" disabled="">{{Lang::get('upload.category')}}</option> @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option> @endforeach </select>
                        <input class="text_input form-control" name="vid_url" style="" placeholder="{{Lang::get('upload.video_url')}}" type="text"> @if ( $setting->allow_vid_up == 0)
                        <div class="form-group">
                            <p style="color: rgb(227, 227, 227);font-size: 15px;" for="exampleInputFile">{{Lang::get('upload.or_upload_vid')}}</p>
                            <input name="uploaded_video" class="text_input" style="padding: 0px 12px;" id="exampleInputFile" type="file"> </div>
                        <div class="form-group">
                            <p style="color: rgb(227, 227, 227);font-size: 15px;" for="exampleInputFile">{{Lang::get('upload.video_image')}}</p>
                            <input name="uploaded_video_img" class="text_input" style="padding: 0px 12px;" id="exampleInputFile" type="file"> </div> @endif
                        <textarea name="vid_description" class="text_input" style="resize: none;height: 120px !important;" placeholder=""> </textarea>
                        <input class="btn-submit-post form-control" name="submit_video" value="{{Lang::get('upload.submit_video')}}" type="submit"> </section> @if ( $setting->recaptcha == 0 )
                    <div style="margin: 20px auto;"> {!! app('captcha')->display(); !!} </div> @endif </form>
            </main>
        </div>
        <div class="upload-rules">
            <div class="alert alert-block">
                <h4 class="alert-heading"><i class="fa fa-video-camera"></i> {{Lang::get('upload.videos_rules')}}!</h4>{{Lang::get('upload.supported_sites')}}: <b>Youtube</b>, <b>Vimeo</b>, <b>Dailymotion</b>, <b>Vine</b> and <b>Metacafe</b>.
                <br>
                <br> {{Lang::get('upload.upload_video_types')}}: <b>MP4</b>/<b>AVI</b>/<b>MPEG</b>/<b>FLV</b>
                <br> @if ($setting->allow_vid_up == 0) {{Lang::get('upload.max_vid_size')}}: <b>{{ $setting->max_vid_mb }} MB</b>. @endif </div>
            <div class="alert alert-block">
                <h4 class="alert-heading"><i class="fa fa-camera"></i> {{Lang::get('upload.images_rules')}}!</h4> {{Lang::get('upload.max_img_size')}} : <b>{{ $setting->max_img_mb }} MB</b>
                <br> {{Lang::get('upload.image_types')}} : <b>JPG</b>, <b>JPEG</b>, <b>GIF</b> and <b>PNG</b> </div>
        </div>
    </div>
</div> @endsection