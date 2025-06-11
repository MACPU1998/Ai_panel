    @extends('admin.layouts.project_master_admin')

    @section('title', 'ایمپورت زیرمحصولات با اکسل')

    @section('content')
        <div class="container mt-1">
            <h6>{{__("general.import_SP_with_excel")}}</h6>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('import_errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-4">
                <a href="{{ route('subProducts.download.excel') }}" class="btn btn-outline-primary mt-3">
                    {{__("general.download_excel_sample")}}
                </a>
            </div>

            <form action="{{ route('subProducts.store.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="import_file" class="form-label">{{__("general.select_excel")}}</label>
                    <input type="file" name="import_file" id="import_file" class="form-control @error('import_file') is-invalid @enderror">
                    @error('import_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">  {{__("general.upload_and_save")}}</button>
            </form>
        </div>
    @endsection
