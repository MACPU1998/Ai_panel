@extends('admin.layouts.project-master-admin')

@section('title', 'ویرایش محصول')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_category")}}</h5>

                <form action="{{route('categories.update',$category->id)}}" method="POST" class="my-10">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{__("general.name")}}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               value="{{ old('name', $category->name) }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">{{__("general.slug")}}</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                               name="slug"
                               value="{{ old('slug', $category->slug) }}" required>
                        @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{__("general.status")}} </label>
                        <select name="status" id="status" class="form-control">

                            <option value="0" {{$category->status == '0' ? 'selected' :''}}>0</option>
                            <option value="1" {{$category->status == '1' ? 'selected' :''}}>1</option>

                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">{{__("general.edit_btn")}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
