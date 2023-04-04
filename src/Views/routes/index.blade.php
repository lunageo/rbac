@extends('luna-permissions::template.layout')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Routes</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Uri</th>
                    <th cope="col">Roles</th>
                </tr>
            </thead>
            <tbody>
            @if (!$routes->isEmpty())

                @foreach($routes as $route)
                <tr>
                    <td>
                        <?php $show_route = route(config('luna-permissions.routes-as') . "routes.show", [$route]);?>
                        <a class="btn-sm btn-outline-secondary" href="{{ $show_route }}">{{ $route->name }}</a>
                    </td>
                    <td>{{ $route->uri }}</td>
                    <td>
                    @if ($route->roles()->exists())

                        @foreach ($route->roles as $role)
                        <?php $role_route = route(config('luna-permissions.routes-as') . "roles.show", [$role]);?>
                        <a class="btn-sm btn-outline-secondary" href="{{ $role_route }}">{{ $role->name }}</a> 
                        @endforeach

                    @endif
                    </td>
                </tr>
                @endforeach

            @endif                        
            </tbody>
        </table>
    </div>
    </div>
</div>

@endsection
