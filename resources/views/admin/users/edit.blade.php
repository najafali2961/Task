@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Edit User Role</h1>
        </div>
        <div class="card-body">
            <form id="userForm" method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="role">Select Role</label>
                    <select name="role" id="role" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update Role</button>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script>
        $(document).ready(function() {
            var notyf = new Notyf();
            $('#userForm').submit(function(e) {
                e.preventDefault();
                $('#roleError').text('');
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        localStorage.setItem('userSuccess', response.success);
                        window.location.href = '{{ route('users.index') }}';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.role) {
                                notyf.error(errors.role[0]);
                                $('#roleError').text(errors.role[0]);
                            }
                        } else {
                            notyf.error('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
