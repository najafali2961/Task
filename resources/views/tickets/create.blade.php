<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Create Ticket</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('assets/img/icons/icon-48x48.png') }}" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .card {
            margin-top: 2rem;
        }

        .supported-files {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main">
            @include('layouts.navbar')
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="container">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Ticket</h3>
                            </div>
                            <div class="card-body">
                                <form id="ticketForm" action="{{ route('tickets.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <!-- Ticket Title -->
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title"
                                            class="form-control form-control-lg mb-3" required>
                                        <span class="text-danger" id="titleError"></span>
                                    </div>
                                    <!-- Ticket Description -->
                                    <div class="form-group mt-2">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control form-control-lg mb-3" required></textarea>
                                        <span class="text-danger" id="descriptionError"></span>
                                    </div>
                                    <!-- Ticket Priority -->
                                    <div class="form-group mt-2">
                                        <label for="priority_id">Priority</label>
                                        <select name="priority_id" id="priority_id"
                                            class="form-control form-control-lg mb-3" required>
                                            <option value="">-- Select Priority --</option>
                                            @foreach ($priorities as $priority)
                                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="priorityError"></span>
                                    </div>
                                    <!-- Categories Checkboxes -->
                                    <div class="form-group mt-2">
                                        <label>Categories</label>
                                        <div>
                                            @foreach ($categories as $category)
                                                <label class="mr-3">
                                                    <input class="form-check-input mb-3" type="checkbox"
                                                        name="categories[]" value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                        <span class="text-danger" id="categoriesError"></span>
                                    </div>
                                    <!-- Labels Checkboxes -->
                                    <div class="form-group mt-2">
                                        <label>Labels</label>
                                        <div>
                                            @foreach ($labels as $label)
                                                <label class="mr-3">
                                                    <input class="form-check-input" type="checkbox" name="labels[]"
                                                        value="{{ $label->id }}">
                                                    {{ $label->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                        <span class="text-danger" id="labelsError"></span>
                                    </div>
                                    <!-- File Attachments -->
                                    <div class="form-group mt-2">
                                        <label for="files">Attachments</label>
                                        <!-- Managed by FilePond -->
                                        <input type="file" class="filepond" name="files[]" id="files" multiple>
                                        <!-- Supported file types message -->
                                        <div class="supported-files">
                                            Supported file types: jpg, jpeg, png, pdf, doc, docx.
                                        </div>
                                        <span class="text-danger" id="filesError"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Submit Ticket</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            const pond = FilePond.create(document.getElementById('files'), {
                instantUpload: false,
                allowMultiple: true,
                acceptedFileTypes: ['image/jpeg', 'image/png', 'application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ]
            });
            var notyf = new Notyf();
            $('#ticketForm').submit(function(e) {
                e.preventDefault();
                $('#titleError, #descriptionError, #priorityError, #filesError, #categoriesError, #labelsError')
                    .text('');

                var formData = new FormData(this);
                let files = pond.getFiles();
                if (files.length > 0) {
                    files.forEach(fileItem => {
                        formData.append('files[]', fileItem.file);
                    });
                }

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        localStorage.setItem('ticketSuccess', response.success);
                        window.location.href = '/tickets';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.title) {
                                notyf.error(errors.title[0]);
                                $('#titleError').text(errors.title[0]);
                            }
                            if (errors.description) {
                                notyf.error(errors.description[0]);
                                $('#descriptionError').text(errors.description[0]);
                            }
                            if (errors.priority_id) {
                                notyf.error(errors.priority_id[0]);
                                $('#priorityError').text(errors.priority_id[0]);
                            }
                            if (errors.categories) {
                                notyf.error(errors.categories[0]);
                                $('#categoriesError').text(errors.categories[0]);
                            }
                            if (errors.labels) {
                                notyf.error(errors.labels[0]);
                                $('#labelsError').text(errors.labels[0]);
                            }
                            if (errors.files) {
                                notyf.error(errors.files[0]);
                                $('#filesError').text(errors.files[0]);
                            }
                        } else {
                            notyf.error('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
