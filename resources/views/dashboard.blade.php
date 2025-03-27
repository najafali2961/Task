@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row">
            <!-- Total Tickets -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Tickets</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-layers align-middle">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                        <polyline points="2 17 12 22 22 17"></polyline>
                                        <polyline points="2 12 12 17 22 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalTickets }}</h1>

                    </div>
                </div>
            </div>

            <!-- Open Tickets -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Open Tickets</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-book-open align-middle">
                                        <path d="M2 7l10-5 10 5-10 5z"></path>
                                        <path d="M2 7v10l10 5 10-5V7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $openTickets }}</h1>

                    </div>
                </div>
            </div>

            <!-- Closed Tickets -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Closed Tickets</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-check-circle align-middle">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $closedTickets }}</h1>

                    </div>
                </div>
            </div>

            <!-- Unassigned Tickets -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Unassigned Tickets</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-alert-triangle align-middle">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                        </path>
                                        <line x1="12" y1="9" x2="12" y2="13"></line>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $unassignedTickets }}</h1>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
