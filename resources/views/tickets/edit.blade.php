<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Ticket</title>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main">
            @include('layouts.navbar')
            <main class="content">
                <div class="container mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h1>Edit Ticket</h1>
                        </div>
                        <div class="card-body">
                            <form id="editTicketForm" action="{{ route('tickets.update', $ticket->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Title Field -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control form-control-lg mb-3" value="{{ $ticket->title }}" required>
                                    <span class="text-danger" id="titleError"></span>
                                </div>

                                <!-- Description Field -->
                                <div class="form-group mt-2">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control form-control-lg mb-3" required>{{ $ticket->description }}</textarea>
                                    <span class="text-danger" id="descriptionError"></span>
                                </div>

                                <!-- Priority Field -->
                                <div class="form-group mt-2">
                                    <label for="priority_id">Priority</label>
                                    <select name="priority_id" id="priority_id"
                                        class="form-control form-control-lg mb-3" required>
                                        <option value="">-- Select Priority --</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $ticket->priority_id == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="priorityError"></span>
                                </div>

                                @if (auth()->user()->hasRole('Administrator'))
                                    <div class="form-group mt-2">
                                        <label for="agent_id">Assign Agent</label>
                                        <select name="agent_id" id="agent_id"
                                            class="form-control form-control-lg mb-3">
                                            <option value="">-- Select Agent --</option>
                                            @foreach ($agents as $agent)
                                                <option value="{{ $agent->id }}"
                                                    {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Categories Checkboxes -->
                                <div class="form-group mt-2">
                                    <label>Categories</label>
                                    <div>
                                        @foreach ($allCategories as $cat)
                                            <label class="mr-3">
                                                <input type="checkbox" class="form-check-input mb-3" name="categories[]"
                                                    value="{{ $cat->id }}"
                                                    {{ in_array($cat->id, $ticket->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                {{ $cat->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="text-danger" id="categoriesError"></span>
                                </div>

                                <!-- Labels Checkboxes -->
                                <div class="form-group mt-2">
                                    <label>Labels</label>
                                    <div>
                                        @foreach ($allLabels as $label)
                                            <label class="mr-3">
                                                <input type="checkbox" class="form-check-input mb-3" name="labels[]"
                                                    value="{{ $label->id }}"
                                                    {{ in_array($label->id, $ticket->labels->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                {{ $label->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="text-danger" id="labelsError"></span>
                                </div>

                                <!-- File Uploads -->
                                <div class="form-group mt-2">
                                    <label for="files">Attachments</label>
                                    <input type="file" name="files[]" id="files" multiple>
                                    <!-- Container for hidden inputs for existing files -->
                                    <div id="existing-files" class="mt-2">
                                        @foreach ($ticket->files as $file)
                                            <input type="hidden" name="existing_files[]" value="{{ $file->id }}">
                                        @endforeach
                                    </div>
                                    <span class="text-danger" id="filesError"></span>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update Ticket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <!-- JavaScript dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        $(document).ready(function() {
            const pond = FilePond.create(document.getElementById('files'), {
                instantUpload: false,
                allowMultiple: true,
                server: {

                }
            });
            @foreach ($ticket->files as $file)
                pond.addFile('{{ Storage::url($file->file_path) }}', {
                    metadata: {
                        id: '{{ $file->id }}',
                        origin: 'server'
                    },
                    options: {
                        type: 'local',
                        origin: 3
                    }
                });
            @endforeach
            pond.on('removefile', (error, file) => {
                if (error) {
                    console.error('Error removing file:', error);
                    return;
                }
                const fileId = file.getMetadata('id');
                $('#existing-files input').filter(function() {
                    return $(this).val() == fileId;
                }).remove();
            });

            const notyf = new Notyf();

            $('#editTicketForm').submit(function(e) {
                e.preventDefault();
                $('.text-danger').text('');
                const formData = new FormData(this);
                pond.getFiles().forEach(file => {
                    if (file.origin === 1) { // new files
                        formData.append('files[]', file.file);
                    }
                });
                const removedFiles = pond.getFiles().filter(file => {
                    return file.status === 2 && file.getMetadata('origin') === 'server';
                });
                removedFiles.forEach(file => {
                    formData.append('removed_files[]', file.getMetadata('id'));
                });

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        localStorage.setItem('ticketSuccess', response.success);
                        window.location.href = '{{ route('tickets.index') }}';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(field => {
                                $(`#${field}Error`).text(errors[field][0]);
                                notyf.error(errors[field][0]);
                            });
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
