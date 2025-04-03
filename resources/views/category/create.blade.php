@extends('.layouts.master')

@section('title' , 'ساخت دسته بندی جدید')

@section('content')

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">دسته بندی ها</h4>
    </div>

    <form action="{{ route('category.store') }}" class="row gy-4" method="post">

        @csrf
        <div class="col-md-6">
            <label class="form-label">نام</label>
            <input name="name" value="{{ old('name') }}" type="text" class="form-control"/>
            <div class="Form-text text-danger">@error('name') {{ $message }} @enderror</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">وضعیت</label>
            <select class="form-select" name="status">
                <option {{ old('status') == 1 ? 'selected':'' }} value="1">فعال</option>
                <option {{ old('status') == 0 ? 'selected':'' }} value="0">غیرفعال</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ایجاد دسته بندی
            </button>
        </div>

    </form>

@endsection

