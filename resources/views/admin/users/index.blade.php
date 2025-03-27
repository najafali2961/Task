@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Management</h3>
            <p>All Users List</p>
        </div>
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script>
        $(document).ready(function() {
            var notyf = new Notyf();
            var successMsg = localStorage.getItem('userSuccess');
            if (successMsg) {
                notyf.success(successMsg);
                localStorage.removeItem('userSuccess');
            }
            $('#users-table').on('click', '.delete-user', function() {
                var userId = $(this).data('id');
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: '/users/' +
                            userId,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            localStorage.setItem('userSuccess', response.success);
                            window.location.href = '{{ route('users.index') }}';
                        },
                        error: function() {
                            notyf.error('An error occurred. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
