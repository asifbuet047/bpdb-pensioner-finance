@extends('layouts.layout')

@section('title', 'Contact')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Login form-->
            <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                            class="bi bi-envelope"></i></div>
                    <h1 class="fw-bolder">Provide Your Officer's Credential</h1>
                    <p class="lead fw-normal text-muted mb-0">Let's work together!</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        {{-- Successful message area --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                <ul class="mb-0">
                                    @foreach (session('data') as $data)
                                        @if ($loop->first)
                                        @else
                                            <li>{{ $data }}</li>
                                        @endif
                                        @if ($loop->last)
                                            <li>Successfully message is posted</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Error message section --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="contactForm" method="POST" action="{{ route('login.success') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Name input-->
                            <div class="mb-3">
                                @if (session('success'))
                                    <label for="name" class="form-label">Full name</label>
                                    <input class="form-control" id="name" name="name" type="text"
                                        placeholder="Enter your name..." disabled value="{{ session('data')['name'] }}" />
                                @else
                                    <label for="name" class="form-label">Full name</label>
                                    <input class="form-control" id="name" name="name" type="text"
                                        placeholder="Enter your name..." data-sb-validations="required" />
                                @endif

                            </div>
                            <!-- Email address input-->
                            <div class="mb-3">
                                @if (session('success'))
                                    <label for="email" class="form-label">Email address</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="name@example.com" disabled value="{{ session('data')['email'] }}" />
                                @else
                                    <label for="email" class="form-label">Email address</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="name@example.com" data-sb-validations="required,email" />
                                @endif

                            </div>
                            <!-- Phone number input-->
                            <div class="mb-3">
                                @if (session('success'))
                                    <label for="phone" class="form-label">Phone number</label>
                                    <input class="form-control" id="phone" name="phone" type="tel"
                                        placeholder="01*******" disabled value="{{ session('data')['phone'] }}" />
                                @else
                                    <label for="phone" class="form-label">Phone number</label>
                                    <input class="form-control" id="phone" name="phone" type="tel"
                                        placeholder="01*******" data-sb-validations="required" />
                                @endif

                            </div>
                            <!-- Message input-->
                            <div class="mb-3">
                                @if (session('success'))
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" type="text" placeholder="Enter your message here..."
                                        style="height: 10rem" disabled>{{ session('data')['message'] }}</textarea>
                                @else
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" type="text" placeholder="Enter your message here..."
                                        style="height: 10rem" data-sb-validations="required"></textarea>
                                @endif

                            </div>
                            <!-- File input-->
                            <div class="mb-3">
                                @if (session('success'))
                                    <label for="file" class="form-label">Uploaded file</label>
                                    <input class="form-control" id="file" name="file" type="file"
                                        placeholder="Attch your file here" disabled />
                                @else
                                    <label for="file" class="form-label">Uploaded file</label>
                                    <input class="form-control" id="file" name="file" type="file"
                                        placeholder="Attch your file here" />
                                @endif

                            </div>
                            <div class="d-none" id="submitErrorMessage">
                                <div class="text-center text-danger mb-3">Error sending message!</div>
                            </div>
                            <!-- Submit Button-->
                            <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton"
                                    type="submit">Submit</button>
                            </div>
                    </div>

                </div>

                </form>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
