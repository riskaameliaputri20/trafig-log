<x-layouts.auth>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card card-bg-fill mt-4">

                <div class="card-body p-4">
                    <div class="mt-2 text-center">
                        <h5 class="text-primary">Welcome Back !</h5>
                        <p class="text-muted">Sign in to continue to Velzon.</p>
                    </div>
                    <div class="mt-4 p-2">
                        <form action="https://themesbrand.com/velzon/html/master/index.html">

                            <div class="mb-3">
                                <label
                                    for="username"
                                    class="form-label"
                                >Username</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    placeholder="Enter username"
                                >
                            </div>

                            <div class="mb-3">
                                <div class="float-end">
                                    <a
                                        href="auth-pass-reset-basic.html"
                                        class="text-muted"
                                    >Forgot password?</a>
                                </div>
                                <label
                                    class="form-label"
                                    for="password-input"
                                >Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input
                                        type="password"
                                        class="form-control password-input pe-5"
                                        placeholder="Enter password"
                                        id="password-input"
                                    >
                                    <button
                                        class="btn btn-link position-absolute text-decoration-none text-muted password-addon material-shadow-none end-0 top-0"
                                        type="button"
                                        id="password-addon"
                                    ><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="auth-remember-check"
                                >
                                <label
                                    class="form-check-label"
                                    for="auth-remember-check"
                                >Remember me</label>
                            </div>

                            <div class="mt-4">
                                <button
                                    class="btn btn-success w-100"
                                    type="submit"
                                >Sign In</button>
                            </div>

                            <div class="mt-4 text-center">
                                <div class="signin-other-title">
                                    <h5 class="fs-13 title mb-4">Sign In with</h5>
                                </div>
                                <div>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-icon waves-effect waves-light"
                                    ><i class="ri-facebook-fill fs-16"></i></button>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-icon waves-effect waves-light"
                                    ><i class="ri-google-fill fs-16"></i></button>
                                    <button
                                        type="button"
                                        class="btn btn-dark btn-icon waves-effect waves-light"
                                    ><i class="ri-github-fill fs-16"></i></button>
                                    <button
                                        type="button"
                                        class="btn btn-info btn-icon waves-effect waves-light"
                                    ><i class="ri-twitter-fill fs-16"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Don't have an account ? <a
                        href="auth-signup-basic.html"
                        class="fw-semibold text-primary text-decoration-underline"
                    > Signup </a> </p>
            </div>

        </div>
    </div>
</x-layouts.auth>
