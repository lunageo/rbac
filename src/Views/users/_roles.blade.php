
<div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title">Roles</h5>
    @if (!$user->role_list->isEmpty())

        @foreach ($user->role_list as $role)
        <div class="form-group">
            <label for="{{ $role->id }}">{{ $role->name }}</label>
            <select class="form-select form-select-sm" id="{{ $role->id }}" name="roles[{{ $role->id }}]">
                <option></option>
                <option value="{{ $role->id }}" @if($user->haveRole($role->id)) selected @endif>Selected</option>
            </select>
        </div>
        @endforeach

    @endif
  </div>
</div>
