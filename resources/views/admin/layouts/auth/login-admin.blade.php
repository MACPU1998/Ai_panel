<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../assets/css/styles.css" />

    <title>ورود به پنل مدیریت</title>
</head>

<body>
<div class="preloader"></div>

<div id="main-wrapper">
    <div class="auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center p-3">

        <div class="card bg-body shadow-sm border-0 rounded-4 w-100"
             style="max-width: 440px;">

            <div class="card-body p-4 p-md-5">

                <!-- Logo / Brand -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle rounded-3 p-3 mb-3">
                        <iconify-icon icon="solar:shield-user-linear"
                                      class="text-primary"
                                      width="32"
                                      height="32">
                        </iconify-icon>
                    </div>

                    <h4 class="fw-bold mb-2">ورود به پنل مدیریت</h4>

                    <p class="text-muted mb-0">
                        برای ادامه، اطلاعات حساب کاربری خود را وارد کنید.
                    </p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">
                            ایمیل
                        </label>

                        <input
                            type="email"
                            class="form-control py-2"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="example@domain.com"
                            autocomplete="username"
                            dir="ltr"
                            required
                            autofocus
                        />

                        @error('email')
                        <div class="text-danger fs-2 mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">
                            رمز عبور
                        </label>

                        <input
                            type="password"
                            class="form-control py-2"
                            id="password"
                            name="password"
                            placeholder="رمز عبور خود را وارد کنید"
                            autocomplete="current-password"
                            required
                        />

                        @error('password')
                        <div class="text-danger fs-2 mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="remember"
                            name="remember"
                            value="1"
                        />

                        <label class="form-check-label text-muted"
                               for="remember">
                            مرا به خاطر بسپار
                        </label>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="btn btn-primary w-100 py-2 rounded-2 fw-semibold mb-3">
                        ورود به حساب
                    </button>

                    <div class="text-center">
                            <span class="text-muted fs-2">
                                ورود امن به پنل مدیریت
                            </span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
<script src="../assets/js/theme/app.init.js"></script>
<script src="../assets/js/theme/theme.js"></script>
<script src="../assets/js/theme/app.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
