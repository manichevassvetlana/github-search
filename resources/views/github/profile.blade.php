@extends('layouts.app')

@section('content')
    {{--Vue component: user's profile with list of the followers--}}
    <search-component :name="'{{$name}}'"></search-component>

@endsection