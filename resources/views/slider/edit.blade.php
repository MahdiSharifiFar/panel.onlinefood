@extends('.layouts.master')

@section('title' , 'ویرایش اسلایدر')

@section('content')

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">اطلاعات</h4>
    </div>

    <form action="{{ route('slider.update' , ['slider' => $slider->id]) }}" class="row gy-4" method="post">
        @csrf
        @method('put')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" value="{{ $slider->title }}" type="text" class="form-control"/>
            <div class="Form-text text-danger">@error('title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">عنوان لینک</label>
            <input name="link_title" value="{{ $slider->link_title }}" type="text" class="form-control"/>
            <div class="Form-text text-danger">@error('link_title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">آدرس لینک</label>
            <input name="link" dir="ltr" value="{{ $slider->link }}" type="text" class="form-control"/>
            <div class="Form-text text-danger">@error('link') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3">{{ $slider->content }}</textarea>
            <div class="Form-text text-danger">@error('body') {{ $message }} @enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش اسلایدر
            </button>
        </div>
    </form>

@endsection

