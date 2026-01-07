<x-layouts.auth>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card card-bg-fill mt-4">

                <div class="card-body p-4">
                    <div class="mt-2 text-center">
                        <h5 class="text-primary">Login Admin Dashboard</h5>
                        <p class="text-muted">Masukkan Email dan Password untuk melanjutkan</p>
                        @error('login')
                            <div class="alert alert-danger material-shadow" role="alert">
                                <strong> Login Failed </strong> <br />
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                    <div class="mt-4 p-2">
                        <form action="{{ route('loginProcess') }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="float-end">
                                </div>
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" name="password" class="form-control password-input pe-5"
                                        placeholder="Enter password" id="password-input">
                                    <button
                                        class="btn btn-link position-absolute text-decoration-none text-muted password-addon material-shadow-none end-0 top-0"
                                        type="button" id="password-addon"><i
                                            class="ri-eye-fill align-middle"></i></button>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="remember" type="checkbox" checked id="auth-remember-check">
                                <label class="form-check-label" for="auth-remember-check">Remember</label>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Sign In</button>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">

            </div>

        </div>
    </div>
</x-layouts.auth>
