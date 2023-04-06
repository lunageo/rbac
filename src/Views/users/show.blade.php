@extends('luna-rbac::template.layout')

@section('content')

@include('luna-rbac::users._navigation')

<fieldset disabled>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">User {{ $user->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>

            @include('luna-rbac::users._form')

        </div>
    </div>

    @include('luna-rbac::users._roles')

</fieldset>

@endsection
