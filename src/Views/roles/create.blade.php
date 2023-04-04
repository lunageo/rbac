@extends('luna-permissions::template.layout')

@section('content')

<div class="mb-3 d-flex justify-content-between">

    <div>
        <?php $route = route(config('luna-permissions.routes-as') . "roles.index"); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">List</a>
    </div> 

</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create Role</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <?php $route = route(config('luna-permissions.routes-as') . "roles.store"); ?>
        <form method="POST" action="{{ $route }}">

        @csrf

        @include('luna-permissions::roles._form')

        <button type="submit" class="btn btn-success btn-sm">Create</button>

        </form>
    </div>
</div>

@endsection
