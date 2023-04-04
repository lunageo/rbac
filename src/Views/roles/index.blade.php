@extends('luna-permissions::template.layout')

@section('content')

<div class="mb-3 d-flex justify-content-between">

    <div>
        <?php $route = route(config('luna-permissions.routes-as') . "roles.create"); ?>
        <a href="{{ $route }}" class="btn btn-success btn-sm">Create</a>
    </div> 

</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Roles</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">Key</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                @if (!$roles->isEmpty())

                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <?php $route = route(config('luna-permissions.routes-as') . "roles.show", [$role]); ?>
                            <a class="btn-sm btn-outline-secondary" href="{{ $route }}">
                                {{ $role->key }}
                            </a>
                        </td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                    </tr>
                    @endforeach

                @endif                        
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection