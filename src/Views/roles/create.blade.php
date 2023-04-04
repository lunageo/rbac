@extends('luna-permissions::template.layout')

@section('content')

<div class="mb-3 d-flex justify-content-between">

    <div>
        <?php $route = route(config('luna-permissions.routes-as') . "roles.index"); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">List</a>
    </div> 

</div>

<?php $route = route(config('luna-permissions.routes-as') . "roles.store"); ?>
<form method="POST" action="{{ $route }}">

    @csrf

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Create Role</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-permissions::roles._form')
            
        </div>
    </div>

    @include('luna-permissions::roles._users')

    <button type="submit" class="btn btn-success btn-sm mt-3">Create</button>

</form>

@endsection
