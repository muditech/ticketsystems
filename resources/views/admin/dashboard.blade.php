@extends('layouts.admin')

@section('title', 'Dashboard')

@section('h1', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Last Tickets</h3>
                    <div class="card-tools form-group"></div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 200px">User</th>
                            <th>Title</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($tickets->last_ten as $key => $ticket)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>
                                    <a href="{{ route('ticket.preview', $ticket->id) }}" title="{{ $ticket->short_title }}">
                                        {{ $ticket->short_title }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No tickets with these criteria were found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">

                </div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Open & High Priority Tickets</h3>
                    <div class="card-tools form-group"></div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 80px">Status</th>
                            <th style="width: 80px">Priority</th>
                            <th>Title</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($tickets->open_and_high_priority_last_ten as $key => $ticket)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ticket->status->name }}</td>
                                <td>{{ $ticket->priority->name }}</td>
                                <td>
                                    <a href="{{ route('ticket.preview', $ticket->id) }}" title="{{ $ticket->short_title }}">
                                        {{ $ticket->short_title }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No tickets with these criteria were found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">More Than 7 Days Open Tickets</h3>
                    <div class="card-tools form-group"></div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 50px">Status</th>
                            <th style="width: 50px">OpenDays</th>
                            <th>Title</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($tickets->more_than_seven_days_open_last_ten as $key => $ticket)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ticket->status->name }}</td>
                                <td class="text-center">{{ $ticket->open_days }}</td>
                                <td>
                                    <a href="{{ route('ticket.preview', $ticket->id) }}" title="{{ $ticket->short_title }}">
                                        {{ $ticket->short_title }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No tickets with these criteria were found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">

                </div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Open by Countries Tickets</h3>
                    <div class="card-tools form-group"></div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 50px">Total</th>
                            <th style="width: 300px">Country</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($tickets->open_by_countries_last_ten as $key => $ticket)
                            <tr>
                                <td>{{ $ticket->total }}</td>
                                <td>{{ $ticket->country->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No tickets with these criteria were found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">

                </div>
            </div>

        </div>
    </div>

@endsection
