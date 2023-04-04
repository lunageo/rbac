
<div class="mb-3 d-flex justify-content-between">

    <div>
        <?php $route = route(config('luna-permissions.routes-as') . "roles.index"); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">List</a>

        <?php $route = route(config('luna-permissions.routes-as') . "roles.show", [$role]); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">Show</a>

        <?php $route = route(config('luna-permissions.routes-as') . "roles.edit", [$role]); ?>
        <a href="{{ $route }}" class="btn btn-warning btn-sm">Edit</a>
    </div>    

    <?php $route_detele = route(config('luna-permissions.routes-as') . "roles.update", [$role]); ?>
    <form method="POST" action="{{ $route_detele }}">

        @csrf

        @method('DELETE')

        <button type="submit" class="btn btn-danger btn-sm">Delete</button>

    </form>

</div>
