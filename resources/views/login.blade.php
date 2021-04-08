@extends('layouts.app', ['body_class' => 'login-page'])

@section('title', 'Login')

@section('body')

    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Ticket</b>Systems</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"></p>
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                    @include('partials.notification')
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body login-card-body text-center">
                @if(count($users))
                <table class="table table-bordered">
                    <tr>
                        <th class="text-left">E-mail</th>
                        <th>Password</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-left">{{ $user->email }}</td>
                            <td>password</td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <span class="alert alert-danger m-auto">Run "php artisan migrate --seed"</span>
                @endif
            </div>
        </div>

    </div>

@endsection
