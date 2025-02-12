@extends('admin.layouts.project-master-admin')

@section('title', 'ایجاد منو')

@section('content')

    <div class="body-wrapper">
        <div class="container-fluid">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body p-4">
                        <form action="{{route('menus.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-4 col-lg-4">
                                    <label for="title" class="form-label">عنوان</label>
                                    <input type="text" name="title" required
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title">

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <div class="mb-4 col-lg-4">
                                    <label for="icon" class="form-label">آیکون</label>
                                    <input type="text" name="icon"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           id="icon" style="direction: ltr;">

                                    @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-4 col-lg-4">
                                    <label for="parent_id" class="form-label">زیر منو</label>
                                    <select type="text" name="parent_id"
                                            class="form-control @error('parent_id') is-invalid @enderror"
                                            id="parent_id">
                                        <option value="">هیچکدام</option>
                                        @foreach($menus as $menu )
                                            <option value="{{$menu->id}}">{{$menu->title}}</option>
                                        @endforeach
                                    </select>

                                    @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-lg-8">
                                    <label for="link" class="form-label">لینک</label>
                                    <input type="text" name="link"
                                           class="form-control @error('link') is-invalid @enderror"
                                           id="link">

                                    @error('link')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                         </span>
                                    @enderror
                                </div>

                                <div class="mb-4 col-lg-4">
                                    <label for="status" class="form-label">وضعیت</label>
                                    <select type="text" name="status" required
                                            class="form-control @error('status') is-invalid @enderror"
                                            id="status">
                                        <option value="1">فعال</option>
                                        <option value="0">غیرفعال</option>
                                    </select>

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit">{{__("general.create_btn")}}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
