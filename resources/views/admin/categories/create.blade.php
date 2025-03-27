@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Create Category</h1>
        </div>
        <div class="card-body">
            <form id="createCategoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <span class="text-danger" id="nameError"></span>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Create</button>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var notyf = new Notyf();

            $('#createCategoryForm').submit(function(e) {
                e.preventDefault();
                $('#nameError').text('');
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {

                        localStorage.setItem('categorySuccess', response.success);
                        window.location.href = '{{ route('categories.index') }}';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                notyf.error(errors.name[0]);
                                $('#nameError').text(errors.name[0]);
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
