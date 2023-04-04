@extends('luna-permissions::template.layout')

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
                    <?php $role_route = route(config('luna-permissions.routes-as') . "roles.show", [$role]);?>
                    <a href="{{ $role_route }}">{{ $role->name }}</a>  
                    @endforeach

                @endif
                </div>
                
            </div>

        </fieldset>
        <hr/>
        <label for="protect">Assign roles</label>
        <form method="POST" action="">

            @csrf

            @method('PUT')

            @if (!$route->role_list->isEMpty())

                @foreach ($route->role_list as $role)
                <div class="form-group">
                    <label for="{{ $role->id }}">{{ $role->name }}</label>
                    <select class="form-control form-control-sm" id="{{ $role->id }}" name="roles[{{ $role->id }}]">
                        <option></option>
                        <option value="{{ $role->id }}" @if($route->haveRole($role->id)) selected @endif>Can Access</option>
                    </select>
                </div>
                @endforeach

            @endif
            <button type="submit" class="btn btn-warning btn-sm">Update</button>

        </form>
    </div>
</div>

@endsection