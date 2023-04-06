
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control form-control-sm" id="name" name="name" 
        value="@if(isset($user)) {{ $user->name }} @endif">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control form-control-sm" id="email" name="email"
        value="@php if(isset($user)) { echo $user->email; } @endphp">
</div>