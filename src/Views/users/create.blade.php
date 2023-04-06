@extends('luna-rbac::template.layout')

@section('content')

<div class="mb-3 d-flex justify-content-between">

    <div>
        <?php $route = route(config('luna-rbac.routes-as') . "users.index"); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">List</a>
    </div> 

</div>

<?php $route = route(config('luna-rbac.routes-as') . "users.store"); ?>
<form method="POST" action="{{ $route }}">

    @csrf

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Create User</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-rbac::users._form')

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-sm" id="password" name="password" 
                    value="">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" 
                    value="">
            </div>
            
        </div>
    </div>

    @include('luna-rbac::users._roles')

    <button type="submit" class="btn btn-success btn-sm mt-3">Create</button>

</form>

@endsection
