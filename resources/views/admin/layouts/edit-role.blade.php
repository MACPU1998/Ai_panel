@extends('admin.layouts.project-master-admin')

@section('title', 'ویرایش نقش')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_role")}}</h5>

                <form action="{{route('roles.update',$role->id)}}" method="POST" class="my-10">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{__("general.name")}}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               value="{{ old('name', $role->name) }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="guard_name" class="form-label">{{__("general.guard_name")}} </label>
                        <select name="guard_name" id="guard_name" class="form-control">
                            @foreach($guards as $guard)
                                <option value="{{$guard}}">{{$guard}}</option>
                            @endforeach
                        </select>
                        @error('guard_name')
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
