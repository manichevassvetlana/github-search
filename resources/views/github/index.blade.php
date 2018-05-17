@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{route('search')}}">
            {{csrf_field()}}
            <h1>Find user on GitHub</h1>
            {{csrf_field()}}
            <div class="col-md-11 col-lg-11">
                <input type="text" id="searchUser" name="name" class="form-control" placeholder="Username...">
            </div>
            <div class="col-md-1 col-lg-1">
                <button class="btn btn-primary" style="float:right">Search</button>
            </div>
        </form>
        <br>
        <div>
            @if(count($users) > 0)
                <h3 class="page-header"><strong>Users: </strong></h3>
                @foreach($users->items as $user)
                    <div id="follower">
                        <div class="well">
                            <div class="row" style="cursor: pointer">
                                <div class="col-md-2">
                                    <img src="{{$user->avatar_url}}" alt="" width="70%">
                                </div>
                                <div class="col-md-5">
                                    <strong>{{$user->login}}</strong>
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-2">
                                    <a href="{{url('/user-'.$user->login)}}" class="btn btn-success">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection