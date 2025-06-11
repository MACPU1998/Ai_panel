@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش منو')

@section('content')

    <div class="body-wrapper">
        <div class="container-fluid">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body p-4">
                        <form id="edit_menu" action="{{route('menus.update',$menu->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-4 col-lg-4">
                                    <label for="title" class="form-label">عنوان</label>
                                    <input type="text" name="title" required value="{{$menu->title}}"
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
                                    <input type="text" name="icon" value="{{$menu->icon}}"
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
                                        @foreach($menus as $item )
                                            <option value="{{ $item->id }}" {{ $menu->parent_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->title }}
                                            </option>
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
                                    <input type="text" name="link" value="{{$menu->link}}"
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
                                        <option value="1" {{$menu->status == 1 ? 'selected' :''}}>فعال</option>
                                        <option value="0" {{$menu->status == 0 ? 'selected' :''}}>غیرفعال</option>
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
@section('customjs')
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\MenuRequest', '#edit_menu') !!}
@endsection
