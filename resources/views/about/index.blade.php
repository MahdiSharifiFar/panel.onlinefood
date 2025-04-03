@extends('.layouts.master')

@section('title' , 'درباره ما')

@section('content')

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">درباره ما</h4>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>عنوان</th>
                <th>متن</th>
                <th>لینک</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $about->title }}</td>
                    <td>{{ $about->description }}</td>
                    <td class="dir-ltr">{{ $about->link }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('about.edit' , ['about' => $about->id]) }}"
                               class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
