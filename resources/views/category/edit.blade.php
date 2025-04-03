@extends('.layouts.master')

@section('title' , 'ویرایش دسته بندی')

@section('content')

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">اطلاعات</h4>
    </div>

    <form action="{{ route('category.update' , ['category' => $category->id]) }}" class="row gy-4" method="post">
        @csrf
        @method('put')

        <div class="col-md-6">
            <label class="form-label">نام</label>
            <input name="name" value="{{ $category->name }}" type="text" class="form-control"/>
            <div class="Form-text text-danger">@error('name') {{ $message }} @enderror</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">وضعیت</label>
            <select class="form-select" name="status">
                <option {{ $category->status ? 'selected':'' }} value="1">فعال</option>
                <option {{ $category->status ? '':'selected' }} value="0">غیرفعال</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش دسته بندی
            </button>
        </div>
    </form>

@endsection

