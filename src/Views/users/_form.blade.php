
@foreach(config('luna-rbac.user-attributes') as $attribute)
<div class="form-group">
    <label for="{{ $attribute }}">{{ ucfirst($attribute) }}</label>
    <input type="text" class="form-control form-control-sm" id="{{ $attribute }}" name="{{ $attribute }}" 
        value="@php if(isset($user)) { echo $user->{$attribute}; } @endphp">
</div>
@endforeach
