<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderby('id', 'desc')->paginate(5);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $start_date_discount = $this->getJalaliDate($product->start_date_discount);
        $end_date_discount = $this->getJalaliDate($product->end_date_discount);
        return view('products.edit', compact('product', 'categories', 'start_date_discount', 'end_date_discount'));
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
            'name' => 'required|string',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg',
            'category_id' => 'required|integer',
            'active' => 'required|integer',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'discount_price' => 'integer|nullable',
            'start_date_discount' => 'date_format:Y/m/d H:i:s|nullable',
            'end_date_discount' => 'date_format:Y/m/d H:i:s|nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg|nullable',
        ]);

        $primaryImageName = Carbon::now()->microsecond . '-' . $request['primary_image']->getClientOriginalName();
        $request['primary_image']->storeAs('images/', $primaryImageName);

        $slugName = $this->makeSlug($request['name']);

        DB::beginTransaction();
        $product = Product::create([
            'name' => $request['name'],
            'slug' => $slugName,
            'primary_image' => $primaryImageName,
            'category_id' => $request['category_id'],
            'description' => $request['description'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'active' => $request['active'],
            'discount_price' => $request['discount_price'] ?? 0,
            'start_date_discount' => $request['start_date_discount'] ? $this->getMiladiDate($request['start_date_discount']) : null,
            'end_date_discount' => $request['end_date_discount'] ? $this->getMiladiDate($request['end_date_discount']) : null,
        ]);


        if ($request->has('images') and !empty($request->images)) {
            foreach ($request->images as $image) {
                $imageName = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                $image->storeAs('images/', $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
        }

        DB::commit();
        return redirect()->route('product.index')->with('success', 'محصول با موفقیت ایجاد شد');
    }

    public function update(Product $product, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'primary_image' => 'nullable|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        if ($request->has('primary_image') && $request->images !== null) {
            Storage::delete('assets/images/' . $product->primary_image);

            $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
            $request->primary_image->storeAs('assets/images/', $primaryImageName);
        }

        if ($request->has('images') && $request->images !== null) {
            foreach($product->images as $image){
                Storage::delete('assets/images/'. $image->image);
                $image->delete();
            }

            $fileNameImages = [];
            foreach ($request->images as $image) {
                $fileNameImage = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                $image->storeAs('assets/images/', $fileNameImage);

                $fileNameImages[] = $fileNameImage;
            }
        }

        DB::beginTransaction();

        $product->update([
            'name' => $request->name,
            'slug' => $request->name != $product->name ? $this->makeSlug($request->name) : $product->slug,
            'category_id' => $request->category_id,
            'primary_image' => $request->primary_image !== null ? $primaryImageName : $product->primary_image,
            'description' => $request->description,
            'active' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'discount_price' => $request->sale_price !== null ? $request->sale_price : 0,
            'start_date_discount' => $request->date_on_sale_from !== null ? $this->getMiladiDate($request->date_on_sale_from) : null,
            'end_date_discount' => $request->date_on_sale_to !== null ? $this->getMiladiDate($request->date_on_sale_to) : null,
        ]);

        if ($request->has('images') && $request->images !== null) {
            foreach ($fileNameImages as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }
        }

        DB::commit();

        return redirect()->route('product.index')->with('success', 'محصول با موفقیت ویرایش شد');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with(['success' => 'محصول با موفقیت حذف شد']);
    }

    public function makeSlug($string)
    {
        $slugName = str_replace(' ', '-', $string);
        $count = Product::whereRaw("slug RLIKE '^{$slugName}(-[0-9]+)?$' ")->count();
        return $count ? "{$slugName}-{$count}" : $slugName;
    }

    public function getMiladiDate($miladiDate)
    {
        return Verta::parse($miladiDate)->formatGregorian('Y-m-d H:i:s');
    }

    public function getJalaliDate($miladiDate)
    {
        return verta($miladiDate)->format('Y/m/j H:i:s');
    }

}
