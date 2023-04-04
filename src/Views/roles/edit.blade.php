@extends('luna-permissions::template.layout')

@section('content')

@include('luna-permissions::roles._navigation')

<?php $route = route(config('luna-permissions.routes-as') . "roles.update", [$role]); ?>
<form method="POST" action="{{ $route }}">

    @csrf

    @method('PUT')

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Role {{ $role->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-permissions::roles._form')


        </div>
    </div>

    @include('luna-permissions::roles._users')

    <button type="submit" class="btn btn-warning btn-sm">Update</button>

</form>

<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title">Routes</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>        

        @include('luna-permissions::roles._routes')

    </div>
</div>

@endsection
