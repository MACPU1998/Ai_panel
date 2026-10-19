@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش ادمین')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">ویرایش ادمین: {{ $admin->first_name }} {{ $admin->last_name }}</h5>

                <form method="POST" action="{{ route('admins.update', $admin) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نام</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $admin->first_name) }}"
                                   class="form-control @error('first_name') is-invalid @enderror">
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نام خانوادگی</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $admin->last_name) }}"
                                   class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ایمیل</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">شماره تماس</label>
                            <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نقش</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        @selected(old('role', $admin->roles->first()?->name) === $role->name)>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">ذخیره</button>
                    <a href="{{ route('admins.index') }}" class="btn btn-secondary">انصراف</a>
                </form>
            </div>
        </div>
    </div>
@endsection
