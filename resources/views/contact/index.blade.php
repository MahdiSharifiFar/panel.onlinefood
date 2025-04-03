@extends('.layouts.master')

@section('title' , 'پیام های ارتباط با ما')

@section('content')

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">پیام های ارتباط با ما</h4>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>نام و نام خانوادگی</th>
                <th>ایمیل</th>
                <th>موضوع پیام</th>
                <th>متن پیام</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>

            @foreach($messages as $message)

                <tr>
                    <td>{{ $message->full_name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->subject }}</td>
                    <td>{{ $message->body }}</td>
                    <td>
                        <div class="d-flex">

                            <form action="{{ route('contact.delete' , ['contact' => $message->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-info me-2">حذف</button>
                            </form>

                        </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>

@endsection
