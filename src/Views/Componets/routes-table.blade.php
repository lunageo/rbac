<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Method</th>
                <th scope="col">Uri</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                <th scope="col">Namespace</th>
                <th scope="col">Protect</th>
            </tr>
        </thead>
        <tbody>
        @if (!$routes->isEmpty())

            @foreach($routes as $route)
            <tr>
                <td>{{ $route->method }}</td>
                <td>{{ $route->uri }}</td>
                <td>{{ $route->name }}</td>
                <td>{{ $route->action }}</td>
                <td>{{ $route->namespace }}</td>
                <td>{{ $route->protect }}</td>
            </tr>
            @endforeach

        @endif                        
        </tbody>
    </table>
</div>