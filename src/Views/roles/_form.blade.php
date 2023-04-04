
<div class="form-group">
    <label for="key">Key</label>
    <input type="text" class="form-control form-control-sm" id="key" name="key" 
        value="@if(isset($role)) {{ $role->key }} @endif">
    <small id="keyHelp" class="form-text text-muted">Role unique key (for example: reader, creator, super-admin).</small>
</div>

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control form-control-sm" id="name" name="name"
        value="@php if(isset($role)) { echo $role->name; } @endphp">
</div>

<div class="form-group">
    <label for="description">Description</label>
    <input type="text" class="form-control form-control-sm" id="description" name="description"
        value="@if(isset($role)) {{ $role->description }} @endif">
</div>
