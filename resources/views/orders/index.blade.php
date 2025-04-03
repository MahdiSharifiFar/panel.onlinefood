@extends('.layouts.master')
@section('title', 'سفارشات')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">سفارشات</h4>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>شماره سفارش</th>
                <th>گیرنده</th>
                <th>وضعیت فعلی</th>
                <th>وضعیت پرداخت</th>
                <th>قیمت کل</th>
                <th>تاریخ</th>
                <th>عملیات</th>
                <th>تغییر وضعیت</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th>
                        {{ $order->id }}
                    </th>

                    <td>
                        <div class="d-flex">
                            <div>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ '99999999'.$order->address->id }}">
                                    مشاهده
                                </button>

                                <div class="modal fade" id="modal-{{ '99999999'.$order->address->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">اطلاعات گیرنده</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table align-middle">
                                                    <thead>
                                                    <tr>
                                                        <th>نام</th>
                                                        <th>شماره تلفن</th>
                                                        <th>ایمیل</th>
                                                        <th>آدرس</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <td>
                                                            {{ $order->user->name }}
                                                        </td>
                                                        <td class="fw-bold">{{ $order->address->cellphone }}</td>
                                                        <td>{{ $order->user->email }}</td>
                                                        <td>
                                                            {{ $order->address->address }}
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>{{ $order->status }}</td>
                    <td>
                            <span
                                class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">{{ $order->payment_status }}
                            </span>
                    </td>
                    <td>{{ number_format($order->paying_amount) }} تومان</td>
                    <td>{{ verta($order->created_at)->format('%B %d، %Y') }}</td>
                    <td>
                        <div class="d-flex">
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ $order->id }}">
                                    محصولات
                                </button>

                                <div class="modal fade" id="modal-{{ $order->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">محصولات سفارش
                                                    شماره {{ $order->id }}</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table align-middle">
                                                    <thead>
                                                    <tr>
                                                        <th>محصول</th>
                                                        <th>نام</th>
                                                        <th>قیمت</th>
                                                        <th>تعداد</th>
                                                        <th>قیمت کل</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($order->items()->with('product')->get() as $item)
                                                        <tr>
                                                            <th>
                                                                <img class="rounded"
                                                                     src="{{ asset('assets/images/' . $item->product->primary_image) }}"
                                                                     width="80" alt=""/>
                                                            </th>
                                                            <td class="fw-bold">{{ $item->product->name }}</td>
                                                            <td>{{ $item->price }} تومان</td>
                                                            <td>
                                                                {{ $item->quantity }}
                                                            </td>
                                                            <td>{{ number_format($item->subtotal) }} تومان</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($order->getRawOriginal('status') === 1)
                            <a href="{{ route('orders.sent' , ['order' => $order]) }}"
                               class="btn btn-sm btn-primary ms-2">ارسال شده</a>
                            <a href="{{ route('orders.cancel' , ['order' => $order]) }}"
                               class="btn btn-sm btn-danger ms-2">لغو</a>
                        @endif

                        @if($order->getRawOriginal('status') === 2)
                            <a href="{{ route('orders.return' , ['order' => $order]) }}"
                               class="btn btn-sm btn-dark ms-2">مرجوع</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $orders->links('layouts.paginate') }}
    </div>
@endsection
