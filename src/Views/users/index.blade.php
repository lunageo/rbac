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
                            <a class="btn-sm btn-outline-secondary" href="{{ $route }}">
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