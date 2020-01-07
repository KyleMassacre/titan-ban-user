@extends('titan::layouts.app')
@section('content')
    <div class="container-fluid">
        <h3>Your {{ $type }} is banned</h3>

        @if($ban->forever)
            <p>You are permanently banned</p>
        @else
            <p>Your are banned for {{ $ban->ban_until->diffForHumans(['parts' => 3]) }}</p>
        @endif
        <p class="text-muted"><b>Reason: </b>{{ $ban->reason }}</p>
    </div>
@endsection
