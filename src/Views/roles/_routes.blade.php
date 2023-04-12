<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Uri</th>
                <th cope="col">Roles</th>
                <th cope="col">Namespace</th>
                <th cope="col">Role access</th>
            </tr>
        </thead>
        <tbody>
        @foreach($role->route_list as $route)
            <tr>
                <td>
                    <?php $show_route = route(config('luna-rbac.routes-as') . "routes.show", [$route]);?>
                    <a class="btn btn-sm btn-outline-secondary" href="{{ $show_route }}">{{ $route->name }}</a>
                </td>
                <td>{{ $route->uri }}</td>
                <td>
                @if ($route->roles()->exists())

                    @foreach ($route->roles as $user_role)
                    <?php $role_route = route(config('luna-rbac.routes-as') . "roles.show", [$user_role]);?>
                    <a class="btn btn-sm btn-outline-secondary" href="{{ $role_route }}">{{ $user_role->name }}</a> 
                    @endforeach

                @endif
                </td>
                <td>{{ $route->namespace }}</td>
                <td>
                    <select class="form-select form-select-sm" id="{{ $route->id }}" name="routes[{{ $route->id }}]">
                        <option></option>
                        <option value="{{ $route->id }}" @if($route->haveRole($role->id)) selected @endif>Can Access</option>
                    </select>
                </td>
            </tr>
        @endforeach                 
        </tbody>
    </table>
</div>