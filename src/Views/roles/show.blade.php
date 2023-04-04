@extends('luna-permissions::template.layout')

@section('content')

@include('luna-permissions::roles._navigation')

<fieldset disabled>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Role {{ $role->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-permissions::roles._form')

            @include('luna-permissions::roles._routes')
        </div>
    </div>

    @include('luna-permissions::roles._users')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Routes</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-permissions::roles._routes')
        </div>
    </div>

</fieldset>

@endsection
