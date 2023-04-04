@extends('luna-permissions::template.layout')

@section('content')

@include('luna-permissions::roles._navigation')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Role {{ $role->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <fieldset disabled>

        @include('luna-permissions::roles._form')

        </fieldset>

        @include('luna-permissions::roles._routes')
    </div>
</div>

@endsection
