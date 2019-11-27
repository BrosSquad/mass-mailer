@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <img style="height: 350px" src="{{ asset('images/horizon.png') }}" class="card-img-top" alt="Laravel horizon">
                    <div class="card-body text-center">
                        <h5 class="card-title text-center mb-5 mt-5">Laravel Horizon</h5>
                        <p class="card-text">
                            Horizon provides a beautiful dashboard and code-driven configuration for your Laravel powered Redis queues. Horizon allows you to easily monitor key metrics of your queue system such as job throughput, runtime, and job failures.
                        </p>
                        <a href="/horizon" class="btn text-center btn-outline-info">Go to horizon dashboard</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img style="height: 350px" src="{{ asset('images/telescope.png') }}" class="card-img-top" alt="Laravel Telescope">
                    <div class="card-body text-center">
                        <h5 class="card-title text-center mb-5 mt-5">Laravel Telescope</h5>
                        <p class="card-text">Laravel Telescope is an elegant debug assistant for the Laravel framework. Telescope provides insight into the requests coming into your application, exceptions, log entries, database queries, queued jobs, mail, notifications, cache operations, scheduled tasks, variable dumps and more.</p>
                        <a href="/telescope" class="text-center btn btn-outline-info">Go to telescope dashboard</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
