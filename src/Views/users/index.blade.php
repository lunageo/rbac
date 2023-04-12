@extends('luna-rbac::template.layout')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/sb-1.4.2/datatables.min.css" 
            rel="stylesheet"/>
@endsection

@section('content')

@include('luna-rbac::users._navigation')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Users</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <div class="table-responsive">
            <table id="users" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th></th>
                    @foreach(config('luna-rbac.user-attributes') as $attribute)
                        <th scope="col">{{ $attribute }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                @if (!$users->isEmpty())

                    @foreach($users as $user)
                    <tr>
                        <td>
                            <?php $route = route(config('luna-rbac.routes-as') . "users.show", [$user]); ?>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ $route }}">
                                View
                            </a>
                        </td>
                        @foreach(config('luna-rbac.user-attributes') as $attribute)
                        <td>{{ $user->{$attribute} }}</td>
                        @endforeach
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
        $('#users').DataTable();
    });
</script>
@endsection