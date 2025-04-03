<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all()->sortByDesc('id');
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function edit(Coupon $coupon)
    {
        $expires_at = $this->getJalaliDate($coupon->expires_at);
        return view('coupons.edit', compact('coupon' , 'expires_at'));
    }

    public function show(Product $product)
    {
        $start_date_discount = $this->getJalaliDate($product->start_date_discount);
        $end_date_discount = $this->getJalaliDate($product->end_date_discount);
        return view('products.show', compact('product', 'start_date_discount', 'end_date_discount'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'code' => 'required|unique:coupons,code|max:255|string',
            'percentage' => 'required|numeric|min:1|max:100',
            'expires_at' => 'required|date_format:Y/m/d H:i:s',
        ]);

        Coupon::create([
            'code' => $request['code'],
            'percentage' => $request['percentage'],
            'expires_at' => Verta::parse($request['expires_at'])->formatGregorian('Y-m-d H:i:s'),
        ]);

        return redirect()->route('coupon.index')->with(['success' => 'کد تخفیف با موفقیت ایجاد شد']);

    }

    public function update(Request $request , Coupon $coupon)
    {

        $request->validate([
            'code' => 'required|max:255|string|unique:coupons,code,'.$coupon->id,
            'percentage' => 'required|numeric|min:1|max:100',
            'expires_at' => 'required|date_format:Y/m/d H:i:s',
        ]);

        $coupon->update([
            'code' => $request['code'],
            'percentage' => $request['percentage'],
            'expires_at' => $this->getMiladiDate($request['expires_at']),
        ]);


        return redirect()->route('coupon.index')->with('success', 'کد تخفیف با موفقیت ویرایش شد');

    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupon.index')->with(['success' => 'کد تخفیف با موفقیت حذف شد']);
    }

    public function getMiladiDate($shamsiDate)
    {
        return Verta::parse($shamsiDate)->formatGregorian('Y-m-d H:i:s');
    }

    public function getJalaliDate($miladiDate)
    {
        return verta($miladiDate)->format('Y/m/j H:i:s');
    }

}
