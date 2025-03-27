@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Edit Category</h1>
        </div>
        <div class="card-body">
            <form id="editCategoryForm" action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}"
                        required>
                    <span class="text-danger" id="nameError"></span>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var notyf = new Notyf();

            $('#editCategoryForm').submit(function(e) {
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
