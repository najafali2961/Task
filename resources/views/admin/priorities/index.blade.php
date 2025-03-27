@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Priority Management</h3>
            <p>All Priorities List</p>
            <a href="{{ route('priorities.create') }}" class="btn btn-primary float-end">Create Priority</a>
        </div>
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection
@section('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function() {
            var notyf = new Notyf();
            var successMsg = localStorage.getItem('prioritySuccess');
            if (successMsg) {
                notyf.success(successMsg);
                localStorage.removeItem('prioritySuccess');
            }
            $('#priorities-table').on('click', '.delete-priority', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this priority?')) {
                    $.ajax({
                        url: '/priorities/' + id,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            localStorage.setItem('prioritySuccess', response.success);
                            window.location.href = '{{ route('priorities.index') }}';
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
