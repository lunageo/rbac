@extends('luna-rbac::template.layout')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/sb-1.4.2/datatables.min.css" 
            rel="stylesheet"/>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Routes</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <div class="table-responsive">
        <table id="routes" class="table table-hover table-sm">
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
                        <?php $show_route = route(config('luna-rbac.routes-as') . "routes.show", [$route]);?>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ $show_route }}">{{ $route->name }}</a>
                    </td>
                    <td>{{ $route->uri }}</td>
                    <td>
                    @if ($route->roles()->exists())

                        @foreach ($route->roles as $role)
                        <?php $role_route = route(config('luna-rbac.routes-as') . "roles.show", [$role]);?>
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

@section('js')
<script>
    $(document).ready(function () {
        $('#routes').DataTable();
    });
</script>
@endsection
