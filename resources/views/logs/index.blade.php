@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Ticket Logs</h1>
        </div>
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
@endsection
