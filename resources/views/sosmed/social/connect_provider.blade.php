@extends('layouts.sosmed')

@section('content')
<style>
        .btn-center{
            width: 50%;
            text-align: center;
            margin: inherit;
        }

        .social-login-btn {
            margin: 5px;
            width: 20%;
            font-size: 250%;
            padding: 0;
        }

        .social-login-more {
            width: 45%;
        }

        .social-google {
            background-color: #da573b;
            border-color: #be5238;
            color:#fff;
        }
        .social-google:hover{
            background-color: #be5238;
            border-color: #9b4631;
        }

        .social-twitter {
            background-color: #1daee3;
            border-color: #3997ba;
            color:#fff;
        }
        .social-twitter:hover {
            background-color: #3997ba;
            border-color: #347b95;
        }

        .social-facebook {
            background-color: #4c699e;
            border-color: #47618d;
            color:#fff;
        }
        .social-facebook:hover {
            background-color: #47618d;
            border-color: #3c5173;
        }

        .social-linkedin {
            background-color: #4875B4;
            border-color: #466b99;
        }
        .social-linkedin:hover {
            background-color: #466b99;
            border-color: #3b5a7c;
        }
    </style>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6>{{$provider}}</h6>
        </div>
        <div class="panel-body">
            @switch($provider)
                @case('facebook')
                    <a href="{{URL::to('sosmed/connect/facebook')}}" class="btn social-facebook">
                        <i class="icon-facebook"></i>
                        Connect Facebook
                    </a>
                @break

                @case('twitter')
                    <a href="{{URL::to('sosmed/connect/twitter')}}" class="btn social-twitter">
                        <i class="icon-twitter"></i>
                        Connect Twitter
                    </a>
                @break

                @case('youtube')
                    <a href="{{URL::to('sosmed/connect/google')}}" class="btn social-google">
                        <i class="icon-google-plus"></i>
                        Connect Youtube
                    </a>
                @break

                @case('instagram')
                    <a href="{{URL::to('sosmed/instagram')}}" class="btn social-instagram">
                        <i class="icon-instagram-plus"></i>
                        Connect Instagram
                    </a>
                @break
            @endswitch
        </div>
    </div>
@stop