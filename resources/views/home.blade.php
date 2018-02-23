@extends('layouts.app')

@section('content')
    <div class="container">
        <transition>
            <router-view></router-view>
        </transition>
    </div>
@endsection
