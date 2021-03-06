<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use App\Models\Productcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkpermission('product-list');
        $product = Product::join('productcategories', 'products.productcategory_id', '=', 'productcategories.id')
            ->select('products.*', 'productcategories.name as n')
            ->get();
        return view('backend.product.list', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkpermission('product-create');
        $productcategory = Productcategory::all();
        return view('backend.product.create', compact('productcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'productcategory_id' => 'required',
            'name' => 'required',
            'code' => 'required|unique:products',
            'quantity' => 'required',
            'measure'=>'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'tax' => 'required',
        ]);
        $message = Product::create([
            'productcategory_id' => $request->productcategory_id,
            'name' => $request->name,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'measure'=>$request->measure,
            'stock' => $request->quantity,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price,
            'tax' => $request->tax,
            'status' => $request->status,
            'created_by' => Auth::user()->username,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if ($message) {
            return redirect()->route('product.list')->with('success_message', 'Product Successfully Added ');
        } else {
            return redirect()->route('product.create')->with('error_message', 'Failed To create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->checkpermission('product-edit');
        $product = Product::find($id);
        $productcategory = Productcategory::all();
        return view('backend.product.edit', compact('product', 'productcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'productcategory_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'tax' => 'required',
        ]);
        $pc = Product::find($id);
        $pc->productcategory_id = $request->productcategory_id;
        $pc->name = $request->name;
        $pc->code = $request->code;
        $pc->buy_price = $request->buy_price;
        $pc->sell_price = $request->sell_price;
        $pc->tax = $request->tax;
        $pc->status = $request->status;
        $pc->modified_by = Auth::user()->username;
        $pc->updated_at = date('Y-m-d H:i:s');
        $message = $pc->update();
        if ($message) {
            return redirect()->route('product.list')->with('success_message', 'Product Successfully Updated');
        } else {
            return redirect()->route('product.update')->with('error_message', 'Failed to Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = $this->checkpermission('product-delete');
        if ($check) {
            $this->checkpermission('product-delete');
        } else {
            $product = Product::find($id);
            $message = $product->delete();
            if ($message) {
                return redirect()->route('product.list')->with('success_message', 'Product Successfully Deleted');
            } else {
                return redirect()->route('product.update')->with('error_message', 'Failed to Delete');
            }
        }
    }

    public function stockedit($id)
    {
        $product = Product::find($id);
        return view('backend.product.stockupdate', compact('product'));
    }

    public function stockupdate(Request $request, $id)
    {
        $this->validate($request, [
            'stock' => 'required',
        ]);
        $pc = Product::find($id);
        $pc->stock = $pc->stock + $request->stock;
        $pc->quantity = $pc->quantity + $request->stock;
        if ($pc->update()) {
            return redirect()->route('product.list')->with('success_message', 'Successfully Updated Your Stock');
        } else {
            return redirect()->route('stock.update')->with('error_message', 'Failed to Update');
        }
    }

      public function stockclear(Request $request, $id)
    {
        $pc = Product::find($id);
        $pc->quantity = 0;
        $pc->stock = 0;
       
        if ($pc->update()) {
            return redirect()->route('product.list')->with('success_message', 'Successfully Cleared the Stock');
        } else {
            return redirect()->route('product.update')->with('error_message', 'Failed to Clear Stock');
        }
    }
}
