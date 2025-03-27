@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tickets</h3>
            <p>All Tickets List</p>
            @if (auth()->user()->hasAnyRole(['Administrator', 'Agent']))
                <a href="{{ route('tickets.create') }}" class="btn btn-primary float-end">Create Ticket</a>
            @elseif(auth()->user()->hasRole('User'))
                <a href="{{ route('tickets.create') }}" class="btn btn-primary float-end">New Ticket</a>
            @endif
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
            $('#tickets-table').on('click', '.delete-ticket', function() {
                var ticketId = $(this).data('id');
                if (confirm('Are you sure you want to delete this ticket?')) {
                    $.ajax({
                        url: '/tickets/' + ticketId,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            localStorage.setItem('ticketSuccess', response.success);
                            window.location.href = '{{ route('tickets.index') }}';
                        },
                        error: function(xhr) {
                            var notyf = new Notyf();
                            notyf.error('An error occurred. Please try again.');
                        }
                    });
                }
            });
            var successMsg = localStorage.getItem('ticketSuccess');
            if (successMsg) {
                var notyf = new Notyf();
                notyf.success(successMsg);
                localStorage.removeItem('ticketSuccess');
            }
        });
    </script>
@endsection
