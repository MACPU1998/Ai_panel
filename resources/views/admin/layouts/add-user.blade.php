@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن کاربر جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">اضافه کردن کاربر جدید</h5>

                <form action="{{route('users.store')}}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name" autocomplete="off"
                               required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email" autocomplete="off"
                               required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" autocomplete="new-password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">ایجاد</button>
                </form>
            </div>
        </div>
    </div>
@endsection
