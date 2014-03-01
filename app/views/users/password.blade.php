@extends('layouts.index')

@section('stylesheets')
    <link href="/css/signin.css" rel="stylesheet">
    <style>
        .alert {
            cursor: pointer;
        }
    </style>
@stop

@section('content')
    <section id="edit-user">
        <div class="container">
            <div class="row top60">
                <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1">
                    <div class="text-center">
                        @if($user->photo == null)
                            <a id="profile-image" href="#">
                                <img class="img-circle" src="http://placehold.it/300x300&text=Photo+Soon">
                            </a>
                        @else
                            <a id="profile-image" href="#">
                                <img class="img-circle" src="{{ $user->photo }}">
                            </a>
                        @endif
                    </div>

                    

                    {{ Form::open(['route'=>'passwordStore', 'class'=>'form-signin'])}}
                        <div class="alert alert-success">Almost there! You just need to create a password.</div>
                        @if($errors->has())
                            <div class="alert alert-danger">                                
                                <p>{{ $errors->first() }}</p>
                            </div>
                        @endif
                        {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) }}
                        {{ Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Password Confirmation']) }}
                        {{ Form::submit('Save Password', ['class'=>'btn btn-lg btn-primary btn-block']) }}
                    {{ Form::close() }}
                    <hr>
                </div>
            </div><!-- /row -->
        </div><!-- /container -->
    </section><!-- /#edit-user -->
@stop

@section('scripts')
    <!-- start: load filepicker async -->
    <script type="text/javascript">
    (function(a){if(window.filepicker){return}var b=a.createElement("script");b.type="text/javascript";b.async=!0;b.src=("https:"===a.location.protocol?"https:":"http:")+"//api.filepicker.io/v1/filepicker.js";var c=a.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c);var d={};d._queue=[];var e="pick,pickMultiple,pickAndStore,read,write,writeUrl,export,convert,store,storeUrl,remove,stat,setKey,constructWidget,makeDropPane".split(",");var f=function(a,b){return function(){b.push([a,arguments])}};for(var g=0;g<e.length;g++){d[e[g]]=f(e[g],d._queue)}window.filepicker=d})(document); 
    </script>
    <!-- end: load filepicker async -->
    <script>
        $(document).ready(function(){
            $('.alert').click(function(){
                $(this).hide();
            });
        });
    </script>
@stop