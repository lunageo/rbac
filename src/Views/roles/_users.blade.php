<div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title">Users</h5>
    @if (!$role->user_list->isEmpty())

        @foreach ($role->user_list as $user)
        <div class="form-group">
            <label for="{{ $user->id }}">{{ $user->name }}</label>
            <select class="form-control form-control-sm" id="{{ $user->id }}" name="users[{{ $user->id }}]">
                <option></option>
                <option value="{{ $user->id }}" @if($role->haveUser($user->id)) selected @endif>Selected</option>
            </select>
        </div>
        @endforeach

    @endif
  </div>
</div>