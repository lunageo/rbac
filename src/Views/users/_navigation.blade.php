
<div class="mb-3 d-flex justify-content-between">

    <div>
        @if (Route::is(config('luna-rbac.routes-as') . "users.index") 
            || Route::is(config('luna-rbac.routes-as') . "users.show")  
            || Route::is(config('luna-rbac.routes-as') . "users.edit"))
        <?php $route = route(config('luna-rbac.routes-as') . "users.create"); ?>
        <a href="{{ $route }}" class="btn btn-success btn-sm">Create</a>
        @endif

        @if (Route::is(config('luna-rbac.routes-as') . "users.create") 
            || Route::is(config('luna-rbac.routes-as') . "users.show") 
            || Route::is(config('luna-rbac.routes-as') . "users.edit"))
        <?php $route = route(config('luna-rbac.routes-as') . "users.index"); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">List</a>
        @endif

        @if (Route::is(config('luna-rbac.routes-as') . "users.update") 
            || Route::is(config('luna-rbac.routes-as') . "users.edit"))
        <?php $route = route(config('luna-rbac.routes-as') . "users.show", [$user]); ?>
        <a href="{{ $route }}" class="btn btn-info btn-sm">Show</a>
        @endif

        @if (Route::is(config('luna-rbac.routes-as') . "users.show"))
        <?php $route = route(config('luna-rbac.routes-as') . "users.edit", [$user]); ?>
        <a href="{{ $route }}" class="btn btn-warning btn-sm">Edit</a>
        @endif
    </div>    

    @if (Route::is(config('luna-rbac.routes-as') . "users.show") 
        || Route::is(config('luna-rbac.routes-as') . "users.edit"))
    <?php $route_detele = route(config('luna-rbac.routes-as') . "users.update", [$user]); ?>
    <form method="POST" action="{{ $route_detele }}">

        @csrf

        @method('DELETE')

        <button type="submit" class="btn btn-danger btn-sm">Delete</button>

    </form>
    @endif
</div>
