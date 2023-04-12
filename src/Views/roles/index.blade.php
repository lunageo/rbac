@extends('luna-rbac::template.layout')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/sb-1.4.2/datatables.min.css" 
            rel="stylesheet"/>
@endsection

@section('content')

@include('luna-rbac::roles._navigation')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Roles</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <div class="table-responsive">
            <table id="roles" class="table table-hover table-sm">
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
                            <?php $route = route(config('luna-rbac.routes-as') . "roles.show", [$role]); ?>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ $route }}">
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

@section('js')
<script>
    $(document).ready(function () {
        $('#roles').DataTable();
    });
</script>
@endsection