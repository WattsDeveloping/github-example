@extends('master')
@section('content')
    <div class="full_width_page_header">
        <div class="container fixed" style="display:block">
            <h1>Search Results - Top 5 starred Repos</h1>
            <div class="profile-image">
                <img src="{{$avatar_url}}">
            </div>
            <div class="profile-info">
                <ul>
                    <li>Username: {{$username}}</li>
                    <li>View Account: <a class="profile-link" href="{{$html_url}}" target="_blank">{{$html_url}}</a></li>
                </ul>
            </div>
        </div>
    </div>
    @include('partials._results', $results)
@endsection
