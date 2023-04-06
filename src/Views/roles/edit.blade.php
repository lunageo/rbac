@extends('luna-rbac::template.layout')

@section('content')

@include('luna-rbac::roles._navigation')

<?php $route = route(config('luna-rbac.routes-as') . "roles.update", [$role]); ?>
<form method="POST" action="{{ $route }}">

    @csrf

    @method('PUT')

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Role {{ $role->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-rbac::roles._form')


        </div>
    </div>

    @include('luna-rbac::roles._users')

    <div class="card mt-3 mb-3">
        <div class="card-body">
            <h5 class="card-title">Routes</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>        

            @include('luna-rbac::roles._routes')

        </div>
    </div>

    <button type="submit" class="btn btn-warning btn-sm">Update</button>

</form>

@endsection
