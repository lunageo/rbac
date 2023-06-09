@extends('luna-rbac::template.layout')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Route {{ $route->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>

        <fieldset disabled>

            <div class="form-group">
                <label for="method">Method</label>
                <input type="text" class="form-control form-control-sm" id="method" name="method" 
                    value="@if(isset($route)) {{ $route->method }} @endif">
            </div>

            <div class="form-group">
                <label for="uri">Uri</label>
                <input type="text" class="form-control form-control-sm" id="uri" name="uri"
                    value="@php if(isset($route)) { echo $route->uri; } @endphp">
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name"
                    value="@if(isset($route)) {{ $route->name }} @endif">
            </div>

            <div class="form-group">
                <label for="action">Action</label>
                <input type="text" class="form-control form-control-sm" id="action" name="action"
                    value="@if(isset($route)) {{ $route->action }} @endif">
            </div>

            <div class="form-group">
                <label for="namespace">Namespace</label>
                <input type="text" class="form-control form-control-sm" id="namespace" name="namespace"
                    value="@if(isset($route)) {{ $route->namespace }} @endif">
            </div>

            <div class="form-group">
                <label for="protect">Protect</label>
                <input type="text" class="form-control form-control-sm" id="protect" name="protect"
                    value="@if(isset($route)) {{ $route->protect }} @endif">
            </div>

            <div class="form-group">
                <label for="protect">Roles</label>
                <div>
                @if ($route->roles()->exists())

                    @foreach ($route->roles as $role)
                    <?php $role_route = route(config('luna-rbac.routes-as') . "roles.show", [$role]);?>
                    <a class="btn-sm btn-outline-secondary" href="{{ $role_route }}">{{ $role->name }}</a>  
                    @endforeach

                @endif
                </div>
                
            </div>

        </fieldset>
        
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title">Assign roles</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>

        <?php $route_update = route(config('luna-rbac.routes-as') . "routes.update", [$route]); ?>
        <form method="POST" action="{{ $route_update }}">

            @csrf

            @method('PUT')

            <div class="d-flex">            
            @if (!$route->role_list->isEmpty())

                @foreach ($route->role_list as $role)
                <div class="form-group me-1">
                    <label for="{{ $role->id }}">{{ $role->name }}</label>
                    <select class="form-select form-select-sm" id="{{ $role->id }}" name="roles[{{ $role->id }}]">
                        <option></option>
                        <option value="{{ $role->id }}" @if($route->haveRole($role->id)) selected @endif>Can Access</option>
                    </select>
                </div>
                @endforeach

            @endif
            </div>

            <button type="submit" class="btn btn-warning btn-sm mt-3">Assign</button>

        </form>

    </div>
</div>        

@endsection
