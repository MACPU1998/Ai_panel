@extends('layouts.project-master')

@section('title', 'پروفایل')

@section('content')
            <div class="col-lg-12">
                <div class="d-flex justify-content-center flex-column  align-items-center">

                    <!-- -------------------------------------------- -->
                    <!-- Revenue by Product -->
                    <!-- -------------------------------------------- -->
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0">
                                <img src="../assets/images/backgrounds/profilebg.jpg" alt="matdash-img"
                                     class="img-fluid">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 order-lg-1 order-2">
                                        <div class="d-flex align-items-center justify-content-around m-4">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                                        <div class="mt-n5">
                                            <div class="d-flex align-items-center justify-content-center mb-2">
                                                <div class="d-flex align-items-center justify-content-center round-110">

                                                 <form action=""  enctype="multipart/form-data">
                                                     @csrf

                                                     <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100">

                                                         {{--profile image default--}}
                                                         <img src= '../assets/images/profile/user-1.jpg' alt="profile-img"
                                                              class="rounded-circle w-100 h-100" id="image-preview">
                                                         <label for="image-input"
                                                                class="edit-icon position-absolute d-flex align-items-center justify-content-center">
                                                             <img src='../assets/images/icon/edit-profile.png' alt="Edit" style=" width:20px; height: 20px;">
                                                         </label>
                                                     </div>
                                                     {{-- ورودی انتخاب عکس --}}
                                                     <div class="text-center mt-3">
                                                         <input type="file" name="image" id="image-input" class="d-none">
                                                     </div>
                                                 </form>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="col-lg-12">
                        <div class="card">
                            {{--   profile form--}}
                            <form class="col-lg-16" action=""
                                @csrf
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <label for="exampleInputname" class="form-label">نام</label>
                                        <input type="text" name="first_name"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               id="exampleInputname"
                                               value="">

                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputtext1" class="form-label">نام خانوادگی</label>
                                        <input type="text" name="last_name"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               id="exampleInputtext1"
                                               value="">

                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputtext1" class="form-label">ایمیل</label>
                                        <div class="input-group">
                                            <input type="text" name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary">ویرایش</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

{{--        upload pic--}}
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

{{--            <script>--}}
{{--        document.getElementById('image-input').addEventListener('change', function(event) {--}}
{{--            const input = event.target;--}}
{{--            const preview = document.getElementById('image-preview');--}}
{{--            const headerAvatar = document.getElementById('header-avatar'); // تصویر موجود در header--}}
{{--            const topbarAvatar = document.getElementById('topbar-avatar'); // تصویر موجود در topbar--}}

{{--            if (input.files && input.files[0]) {--}}
{{--                const file = input.files[0];--}}
{{--                const formData = new FormData();--}}

{{--                // اضافه کردن فایل به FormData--}}
{{--                formData.append('image', file);--}}

{{--                // ارسال درخواست AJAX به سرور--}}
{{--                fetch('{{ route("upload.image") }}', {--}}
{{--                    method: 'POST',--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF Token--}}
{{--                    },--}}
{{--                    body: formData--}}
{{--                })--}}
{{--                    .then(response => {--}}
{{--                        console.log(response);--}}
{{--                        if (!response.ok) {--}}
{{--                            throw new Error('HTTP status ' + response.status);--}}
{{--                        }--}}
{{--                        return response.json();--}}
{{--                    })--}}
{{--                    .then(data => {--}}
{{--                        if (data.success) {--}}
{{--                            // به‌روزرسانی پیش‌نمایش تصویر--}}
{{--                            const newAvatarUrl = data.avatar + '?t=' + new Date().getTime(); // جلوگیری از کش--}}
{{--                            preview.src = newAvatarUrl;--}}

{{--                            // به‌روزرسانی تصویر topbar--}}
{{--                            topbarAvatar.src = newAvatarUrl;--}}

{{--                            // به‌روزرسانی تصویر header--}}
{{--                            headerAvatar.src = newAvatarUrl;--}}
{{--                            Toastify({--}}
{{--                                text: 'عکس با موفقیت آپلود شد!'  ,--}}
{{--                                duration: 1500,--}}
{{--                                newWindow: true,--}}
{{--                                gravity: "top",--}}
{{--                                position: "right",--}}
{{--                                stopOnFocus: true,--}}
{{--                                style: {--}}
{{--                                    background: "linear-gradient(to right, #00b09b, #96c93d)",--}}
{{--                                }--}}
{{--                            }).showToast();--}}
{{--                        } else {--}}
{{--                            Toastify({--}}
{{--                                text: 'آپلود عکس ناموفق بود. لطفاً دوباره تلاش کنید.'  ,--}}
{{--                                duration: 1500,--}}
{{--                                newWindow: true,--}}
{{--                                gravity: "top",--}}
{{--                                position: "right",--}}
{{--                                stopOnFocus: true,--}}
{{--                                style: {--}}
{{--                                    background: "linear-gradient(to right, #00b09b, #96c93d)",--}}
{{--                                }--}}
{{--                            }).showToast();--}}
{{--                        }--}}
{{--                    })--}}
{{--                    .catch(() => {--}}
{{--                        Toastify({--}}
{{--                            text: 'آپلود عکس ناموفق بود !'  ,--}}
{{--                            duration: 900,--}}
{{--                            newWindow: true,--}}
{{--                            gravity: "top",--}}
{{--                            position: "right",--}}
{{--                            stopOnFocus: true,--}}
{{--                            style: {--}}
{{--                                background: "linear-gradient(to right, #00b09b, #96c93d)",--}}
{{--                            }--}}
{{--                        }).showToast();--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}


{{--    </script>--}}
@endsection
