@extends('layouts.admin')

@section('title', 'Ticket Preview')

@section('h1', 'Ticket Preview')

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="card card-primary*">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Ticket Id:</span>
                                    <span class="info-box-number h4">#{{ $ticket->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status:</span>
                                    <span class="info-box-number h4">{{ $ticket->status->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Priority:</span>
                                    <span class="info-box-number h4">{{ $ticket->priority->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Country:</span>
                                    <span class="info-box-number h4">{{ $ticket->country->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <dl>
                        <dt>User</dt>
                        <dd>{{ $ticket->user->name }}</dd>
                        <dt>Title</dt>
                        <dd>{{ $ticket->title }}</dd>
                        <dt>Description</dt>
                        <dd>{{ $ticket->description }}</dd>
                    </dl>

                </div>

                <div class="card-footer">
                    <a href="javascript:window.history.go(-1)" class="btn btn-sm btn-info float-left" title="Back">Back</a>

                    @if ($ticket->status->id != \App\Models\TicketStatus::CLOSED)
                        <button type="button" class="btn btn-sm btn-danger float-right" data-url="{{ route('ticket.close', $ticket->id) }}" data-toggle="modal" data-target="#confirm-close">Close It!</button>
                    @else
                        &nbsp;
                    @endif
                </div>
            </div>

            @include('partials.confirmTicketDelete')

        </div>
    </div>

@endsection
