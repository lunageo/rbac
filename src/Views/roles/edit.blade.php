@extends('luna-permissions::template.layout')

@section('content')

@include('luna-permissions::roles._navigation')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Role {{ $role->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <?php $route = route(config('luna-permissions.routes-as') . "roles.update", [$role]); ?>
        <form method="POST" action="{{ $route }}">

        @csrf

        @method('PUT')

        @include('luna-permissions::roles._form')

        <button type="submit" class="btn btn-warning btn-sm">Update</button>

        </form>

        @include('luna-permissions::roles._routes')
    </div>
</div>

@endsection
