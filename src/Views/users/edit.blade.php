@extends('luna-rbac::template.layout')

@section('content')

@include('luna-rbac::users._navigation')

<?php $route = route(config('luna-rbac.routes-as') . "users.update", [$user]); ?>
<form method="POST" action="{{ $route }}">

    @csrf

    @method('PUT')

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">User {{ $user->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-rbac::users._form')

        </div>
    </div>

    @include('luna-rbac::users._roles')

    <button type="submit" class="btn btn-warning btn-sm">Update</button>

</form>

@endsection
