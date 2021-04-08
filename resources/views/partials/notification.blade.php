@if ($errors->any() || session('status'))
    <div class="row">
        <div class="col-12">
            <ul class="list-group mt-2">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}
                    </li>
                @endforeach
                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('status') }}
                    </div>
                @endif
            </ul>
        </div>
    </div>
@endif
