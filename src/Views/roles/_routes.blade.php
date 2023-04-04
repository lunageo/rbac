<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Uri</th>
                <th cope="col">Roles</th>
                <th cope="col">Namespace</th>
            </tr>
        </thead>
        <tbody>
        @if ($role->routes()->exists())

            @foreach($role->routes as $route)
            <tr>
                <td>
                    <?php $show_route = route(config('luna-permissions.routes-as') . "routes.show", [$route]);?>
                    <a href="{{ $show_route }}">{{ $route->name }}</a>
                </td>
                <td>{{ $route->uri }}</td>
                <td>
                @if ($route->roles()->exists())

                    @foreach ($route->roles as $user_role)
                    <?php $role_route = route(config('luna-permissions.routes-as') . "roles.show", [$user_role]);?>
                    <a href="{{ $role_route }}">{{ $user_role->name }}</a> 
                    @endforeach

                @endif
                </td>
                <td>{{ $route->namespace }}</td>
            </tr>
            @endforeach

        @endif                        
        </tbody>
    </table>
</div>