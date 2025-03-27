<a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info">View</a>
@if (auth()->user()->can('update tickets'))
    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
@endif
@if (auth()->user()->can('delete tickets'))
    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this ticket?')">Delete</button>
    </form>
@endif
