
<div class="mb-3 d-flex justify-content-between">

    <div>
        @if (Route::is(config('luna-rbac.routes-as') . "roles.index") 
            || Route::is(config('luna-rbac.routes-as') . "roles.show")  
            || Route::is(config('luna-rbac.routes-as') . "roles.edit"))
        <?php $route = route(config('luna-rbac.routes-as') . "roles.create"); ?>
        <a href="{{ $route }}" class="btn btn-success btn-sm">Create</a>
        @endif

        @if (Route::is(config('luna-rbac.routes-as') . "roles.create") 
            || Route::is(config('luna-rbac.routes-as') . "roles.show") 
            || Route::is(config('luna-rbac.routes-as') . "roles.edit"))
        <?php $route = route(config('luna-rbac.routes-as') . "roles.index"); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">List</a>
        @endif

        @if (Route::is(config('luna-rbac.routes-as') . "roles.update") 
            || Route::is(config('luna-rbac.routes-as') . "roles.edit"))
        <?php $route = route(config('luna-rbac.routes-as') . "roles.show", [$role]); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">Show</a>
        @endif

        @if (Route::is(config('luna-rbac.routes-as') . "roles.show"))
        <?php $route = route(config('luna-rbac.routes-as') . "roles.edit", [$role]); ?>
        <a href="{{ $route }}" class="btn btn-warning btn-sm">Edit</a>
        @endif

    </div>    

    @if (Route::is(config('luna-rbac.routes-as') . "roles.show") 
        || Route::is(config('luna-rbac.routes-as') . "roles.edit"))
    <?php $route_detele = route(config('luna-rbac.routes-as') . "roles.update", [$role]); ?>
    <form method="POST" action="{{ $route_detele }}">

        @csrf

        @method('DELETE')

        <button type="submit" class="btn btn-danger btn-sm">Delete</button>

    </form>
    @endif
</div>
