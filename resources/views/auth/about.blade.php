@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col text-center">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>


    <!-- Navbar -->



    <!-- Hero Section -->
    <section class="hero" style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
        <div class="container">
            <h3 class="heading-about">A Team That's Making Magic Happen</h3>


        </div>
    </section>

    <section class="Team">
        <div class="container text-center pt-2">
            <h3 class="heading-about pt-4">Meet Our Team</h3>
        </div>


    </section>


@endsection
