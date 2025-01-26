@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن مجوز جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">اضافه کردن مجوز</h5>

                <form action="{{route('permissions.store')}}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="guard_name" class="form-label">نام گارد</label>
                        <input type="text" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name"
                               name="guard_name" autocomplete="new-password"
                               required>
                        @error('guard_name')
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
