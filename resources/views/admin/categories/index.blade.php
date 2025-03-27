@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category Management</h3>
            <p>All categories List</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary float-end">Create Category</a>
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
            var successMsg = localStorage.getItem('categorySuccess');
            if (successMsg) {
                notyf.success(successMsg);
                localStorage.removeItem('categorySuccess');
            }
            $('#categories-table').on('click', '.delete-category', function() {
                var categoryId = $(this).data('id');
                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        url: '/categories/' + categoryId,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            localStorage.setItem('categorySuccess', response.success);
                            window.location.href = '{{ route('categories.index') }}';
                        },
                        error: function(xhr) {
                            notyf.error('An error occurred. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
