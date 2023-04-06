@extends('luna-rbac::template.layout')

@section('content')

@include('luna-rbac::roles._navigation')

<fieldset disabled>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Role {{ $role->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-rbac::roles._form')

        </div>
    </div>

    @include('luna-rbac::roles._users')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Routes</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-rbac::roles._routes')
            
        </div>
    </div>

</fieldset>

@endsection
