@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Ticket Details</h1>
        </div>
        <!-- Ticket details card -->
        <div class="mb-4">
            <div class="card-body">
                <h3><strong>Title:</strong> {{ $ticket->title }}</h3>
                <p><strong>Description:</strong> {{ $ticket->description }}</p>
                <p><strong>Priority:</strong> {{ $ticket->priority ? $ticket->priority->name : 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                <p><strong>Created by:</strong> {{ $ticket->user->name ?? 'N/A' }}</p>
                <!-- List attachments if any -->
                @if ($ticket->files->count())
                    <hr>
                    <h5>Attachments:</h5>
                    <ul>
                        @foreach ($ticket->files as $file)
                            <li>
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                    {{ basename($file->file_path) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        <!-- Comments Section -->
        <div class="card">
            <div class="card-header">
                <h4>Comments</h4>
            </div>
            <div class="card-body">
                <div id="commentsList">
                    @foreach ($ticket->comments as $comment)
                        <div class="mb-3">
                            <strong>{{ $comment->user->name ?? 'Anonymous' }}:</strong>
                            <p>{{ $comment->comment }}</p>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
                <hr>
                <form id="commentForm" action="{{ route('tickets.comments.store', $ticket->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment">Add Comment</label>
                        <textarea name="comment" id="comment" class="form-control" required></textarea>
                        <span class="text-danger" id="commentError"></span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Post Comment</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include Notyf for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script>
        $(document).ready(function() {
            var notyf = new Notyf();
            $('#commentForm').submit(function(e) {
                e.preventDefault();
                $('#commentError').text('');
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        notyf.success(response.success);
                        window.location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.comment) {
                                notyf.error(errors.comment[0]);
                                $('#commentError').text(errors.comment[0]);
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
