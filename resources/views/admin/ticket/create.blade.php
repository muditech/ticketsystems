@extends('layouts.admin')

@section('title', 'Create New Ticket')

@section('h1', 'Create New Ticket')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-8">
            @include('partials.notification')

            <div class="card card-primary">
                <form action="{{ route('ticket.store') }}" method="POST" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Title" required value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="country" class="form-control select2bs4" id="country" style="width: 100%;" required>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if (($loop->first && empty(old('country'))) || $country->id == old('country')) selected="selected" @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="5" id="description" placeholder="Description ..." required>{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" class="form-control select2bs4" id="priority" style="width: 100%;" required>
                                @foreach($priorities as $priority)
                                    <option value="{{ $priority->id }}" @if (($loop->first && empty(old('priority'))) || $priority->id == old('priority')) selected="selected" @endif>{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endpush
