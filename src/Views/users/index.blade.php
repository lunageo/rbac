@extends('luna-rbac::template.layout')

@section('content')

@include('luna-rbac::users._navigation')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Users</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                @if (!$users->isEmpty())

                    @foreach($users as $user)
                    <tr>
                        <td>
                            <?php $route = route(config('luna-rbac.routes-as') . "users.show", [$user]); ?>
                            <a class="btn-sm btn-outline-secondary" href="{{ $route }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @endforeach

                @endif                        
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection