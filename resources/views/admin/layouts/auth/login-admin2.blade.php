<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="../assets/css/styles.css" />

  <title>ورود ادمین</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
{{--    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />--}}
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
      <div class="position-relative z-index-5">
        <div class="row gx-0">

          <div class="col-lg-6 col-xl-5 col-xxl-4">
            <div class="min-vh-100 bg-body row justify-content-center align-items-center p-5">
              <div class="col-12 auth-card">
                <a href="../main/index.html" class="text-nowrap logo-img d-block w-100">
{{--                  <img src="../assets/images/logos/logo-icon.svg" class="dark-logo" alt="Logo-Dark" />--}}
                </a>
                <h2 class="mb-2 mt-4 fs-7 fw-bolder">صفحه ورود</h2>
                <p class="mb-9">پنل ادمین</p>

                <div class="position-relative text-center my-4">
                  <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div>
                  <br>
                  <form action="{{route('admin.login')}}" method="POST">
                      @csrf

                      <div class="mb-3">
                          <label for="email" class="form-label">ایمیل</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="ایمیل خود را وارد کنید" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-4">
                          <div class="d-flex align-items-center justify-content-between">
                              <label for="password" class="form-label">رمز</label>
                          </div>
                          <input type="password" class="form-control" name="password" id="password" placeholder="رمز خود را وارد کنید">
                      </div>
                      <div class="d-flex align-items-center justify-content-between mb-4">
                          <div class="form-check">
                              <input class="form-check-input primary" type="checkbox" value="" id="remember" name="remember" checked>
                              <label class="form-check-label text-dark" for="flexCheckChecked">
                                  این دستگاه را به خاطر بسپارید
                              </label>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-dark w-100 py-8 mb-4 rounded-2">ورود</button>
                      <div class="d-flex align-items-center">
                          <p class="fs-12 mb-0 fw-medium">حساب کاربری ندارید ؟</p>
                          <a class="text-primary fw-semibold ms-2" href="#">ساخت حساب جدید</a>
                      </div>
                  </form>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden bg-dark d-none d-lg-block rounded-end-5">
            <div>
{{--              <img src="../assets/images/logos/logo-icon.svg" class="circle-bottom" alt="Logo-Dark" />--}}
            </div>
            <div class="d-lg-flex align-items-center z-index-5 position-relative h-n80">
              <div class="row justify-content-center w-100">
                <div class="col-lg-6">
                  <h2 class="text-white fs-10 mb-3 lh-base">
                    به پنل مدیریت
                    <br />
                    خوش آمدید
                  </h2>
                  <span class="opacity-75 fs-4 text-white d-block mb-3">MatDash helps developers to build organized
                    and well
                    <br />
                    coded dashboards full of beautiful and rich modules.
                  </span>
                  <a href="../landingpage/index.html" class="btn btn-primary">Learn More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="../assets/js/theme/app.init.js"></script>
  <script src="../assets/js/theme/theme.js"></script>
  <script src="../assets/js/theme/app.min.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
