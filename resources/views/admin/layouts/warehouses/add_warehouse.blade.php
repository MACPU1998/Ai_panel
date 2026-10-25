@extends('admin.layouts.project_master_admin')

@section('title', 'افزودن انبار جدید')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">

                <h5 class="mb-4">{{ __('general.add_warehouse') }}</h5>

                <form id="add_warehouse"
                      action="{{ route('warehouses.store') }}"
                      method="POST"
                      class="my-10">

                    @csrf

                    <div class="row">

                        {{-- نام انبار --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">نام انبار</label>

                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>

                                @error('name')
                                <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- آدرس --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">آدرس انبار</label>

                                <input type="text"
                                       class="form-control @error('address') is-invalid @enderror"
                                       id="address"
                                       name="address"
                                       value="{{ old('address') }}">

                                @error('address')
                                <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- توضیحات --}}
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">توضیحات</label>

                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="4">{{ old('description') }}</textarea>

                                @error('description')
                                <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- وضعیت --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">وضعیت</label>

                                <select class="form-control @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                        فعال
                                    </option>

                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                        غیرفعال
                                    </option>
                                </select>

                                @error('status')
                                <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- انبار پیش‌فرض --}}

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="make_default" class="form-label">
                                    انبار پیش‌فرض
                                </label>

                                <select class="form-control @error('make_default') is-invalid @enderror"
                                        id="make_default"
                                        name="make_default"
                                        required>

                                    <option value="0"
                                        {{ (string) old('make_default', isset($warehouse) ? $warehouse->make_default : '0') === '0' ? 'selected' : '' }}>
                                        خیر
                                    </option>

                                    <option value="1"
                                        {{ (string) old('make_default', isset($warehouse) ? $warehouse->make_default : '0') === '1' ? 'selected' : '' }}>
                                        بله
                                    </option>
                                </select>

                                @error('make_default')
                                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <button type="submit" class="btn btn-success">
                        {{ __('general.create_btn') }}
                    </button>

                    <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                        انصراف
                    </a>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>

        $(document).ready(function () {
            function toggleDefaultOption() {
                const status = $('#status').val();
                const defaultSelect = $('#make_default');

                if (status === '0') {
                    defaultSelect.val('0');
                    defaultSelect.find('option[value="1"]').prop('disabled', true);
                } else {
                    defaultSelect.find('option[value="1"]').prop('disabled', false);
                }
            }

            $('#status').on('change', toggleDefaultOption);

            toggleDefaultOption();
        });

@endsection
