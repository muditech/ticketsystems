@extends('layouts.admin')

@section('title', 'Ticket List')

@section('h1', 'Ticket List')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @include('partials.notification')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools form-group row">
                        <label for="status" class="col-form-label mr-3">Filter by Status</label>
                        <div class="">
                            <select name="status" id="status" class="form-control">
                                <option value="0">All</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @if ($filterByStatusId == $status->id) selected="selected" @endif>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 100px">Status</th>
                            <th style="width: 100px">OpenDays</th>
                            <th style="width: 200px">Country</th>
                            <th style="width: 200px">User</th>
                            <th>Title</th>
                            <th style="width: 50px"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($tickets as $key => $ticket)
                            <tr>
                                <td>{{ $tickets->firstItem() + $key }}</td>
                                <td class="status">{{ $ticket->status->name }}</td>
                                <td>{{ $ticket->open_days }}</td>
                                <td>{{ $ticket->country->name }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>
                                    <a href="{{ route('ticket.preview', $ticket->id) }}" title="{{ $ticket->short_title }}">
                                        {{ $ticket->short_title }}
                                    </a>
                                </td>
                                <td>
                                    @if ($ticket->status->name != 'Closed')
                                        <button type="button" class="btn btn-sm btn-danger" data-url="{{ route('ticket.close', $ticket->id) }}" data-toggle="modal" data-target="#confirm-close">Close</button>
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tickets with these criteria were found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">{{ $tickets->links() }}</div>
                </div>
            </div>

            @include('partials.confirmTicketDelete')

        </div>
    </div>

@endsection
