@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Label Management</h3>
            <p>All Labels List</p>
            <a href="{{ route('labels.create') }}" class="btn btn-primary float-end">Create Label</a>
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
            var successMsg = localStorage.getItem('labelSuccess');
            if (successMsg) {
                notyf.success(successMsg);
                localStorage.removeItem('labelSuccess');
            }
        });
        $('#labels-table').on('click', '.delete-label', function() {
            var labelId = $(this).data('id');
            if (confirm('Are you sure you want to delete this label?')) {
                $.ajax({
                    url: '/labels/' + labelId,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        localStorage.setItem('labelSuccess', response.success);
                        window.location.href = '{{ route('labels.index') }}';
                    },
                    error: function(xhr) {
                        var notyf = new Notyf();
                        notyf.error('An error occurred. Please try again.');
                    }
                });
            }
        });
    </script>
@endsection
