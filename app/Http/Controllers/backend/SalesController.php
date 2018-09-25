<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Salescart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;
use PDF;

class SalesController extends Controller
{
    public function create()
    {
        $this->checkpermission('sales-create');
        $salescart = Salescart::all();
        return view('backend.sales.create', compact('sales', 'salescart'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'sell_price' => 'required',
            'tax'=>'required',
            'sale_quantity' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
        ]);
        if ($request->ajax()) {
            $sales = new Salescart();
            $sales->product_id = $request->product_id;  
            $sales->sale_quantity = $request->sale_quantity;
            // if($sale->quantity<)
            $total=$request->sell_price * $request->sale_quantity;
            $taxPer=$request->tax*$total;
            $tax_amt=$taxPer/100;
            $sales->tax_amt=$tax_amt;
            $sales->price = $total+$tax_amt;
            $sales->sales_status = $request->sales_status;
            $sales->customer_name=$request->customer_name;
            $sales->customer_address=$request->customer_address;
            $sales->seller_name = Auth::user()->username;
            $sales->sales_date = date('Y-m-d');
            if ($sales->save()) {
                $product = Product::find($request->product_id);
                $product->stock = $product->stock - $request->sale_quantity;
                if ($product->update()) {
                    return response(['success_message' => 'Successfully Made Sales']);
                }
            }

        } else {
            return response(['error_message' => 'Failed To Make Sales']);
        }
    }

    public function index()
    {
        $this->checkpermission('sales-list');
        $sales = Sale::join('products', 'products.id', '=', 'sales.product_id')
            ->select('sales.*', 'products.*')
            ->orderBy('sales.created_at', 'DEC')
            ->get();
        return view('backend.sales.list', compact('sales'));
    }

    public function ajaxlist()
    {
        $sales = Salescart::join('products', 'products.id', '=', 'salescarts.product_id')
            ->select('salescarts.*', 'products.*')
            ->orderBy('salescarts.created_at', 'DEC')
            ->get();
        return view('backend.sales.ajaxlist', compact('sales'));
    }
    public function readname()
    {
      $salescart = Salescart::where($request->customer_name)->get();
        echo $salescart[0]->customer_name;
    }

    public function ajaxform()
    {
        $salescart = Salescart::all();
        return view('backend.sales.ajaxform', compact('salescart'));
    }

    public function refreshproduct()
    {
        $product = Product::where('stock', '>=', 1)->get();
        return view('backend.sales.refreshproduct', compact('product'));
    }

    public function getquantity(Request $request)
    {
        $product = Product::where('id', $request->product_id)->get();
        echo $product[0]->stock;

    }

    public function getsell_price(Request $request)
    {
        $product = Product::where('id', $request->product_id)->get();
        echo $product[0]->sell_price;
    }

     public function gettax(Request $request)
    {
        $product = Product::where('id', $request->product_id)->get();
        echo $product[0]->tax;
    }

    public function getproductname(Request $request)
    {
        $product = Product::where('id', $request->product_id)->get();
        echo $product[0]->name;
    }


    public function getallpdf()
    {
        $report = Salescart::join('products', 'products.id', '=', 'salescarts.product_id')
            ->select('salescarts.*', 'products.*')
            ->get();
            // echo "<pre>"; print_r($report); die;
        return view('backend.pdfbill.salesbill', compact('report'));
    }

    public function getcustomreport(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $report = Sale::join('products', 'products.id', 'sales.product_id')
            ->select('sales.*', 'products.*')
            ->whereBetween('sales.sales_date', [$start, $end])
            ->get();
        $pdf = PDF::loadview('backend.pdfbill.allreport', compact('report', 'start', 'end'));
        return $pdf->download('salesreport.pdf');
    }

    public function viewCustomReport(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $report = Sale::join('products', 'products.id', 'sales.product_id')
            ->select('sales.*', 'products.*')
            ->whereBetween('sales.sales_date', [$start, $end])
            ->get();
            
        return view('backend.pdfbill.allreport', compact('report', 'start', 'end'));
        
    } 


    public function savetosales(Request $request)
    {
        for ($i = 0; $i < $request->input('total_product'); $i++) {
            $od = [
                'product_id' => $request['product_id'][$i],
                'sale_quantity' => $request['sale_quantity'][$i],
                'tax_amt' => $request['tax_amt'][$i],
                'price' => $request['price'][$i],                
                'customer_name' => $request['customer_name'][$i],
                'customer_address' => $request['customer_address'][$i],
                'sales_status' => $request['sales_status'][$i],
                'seller_name' => Auth::user()->username,
                'sales_date' => date('Y-m-d'),
            ];
            //dd($od);
            Sale::create($od);
        }
        DB::table('salescarts')->delete();
        return redirect()->back()->with('success_message', 'Successfuly Cleared Your Bucket and Sales Item store in Sales Record');

    }
     public function editcart($id)
    {
         $this->checkpermission('salescart-edit');
         $salescart = Salescart::find($id);
        return view('backend.sales.edit',compact('salescart'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
        ]);
        $pc = Productcategory::find($id);
        $pc->name = $request->name;
        $pc->slug = $request->slug;
        $pc->status = $request->status;
        $pc->modified_by = Auth::user()->username;
        $pc->updated_at = date('Y-m-d H:i:s');
        $message = $pc->update();
        if ($message) {
            return redirect()->route('productcategory.list')->with('success_message', 'Successfully Updated');
        } else {
            return redirect()->route('productcategory.update')->with('error_message', 'Failed to Update');
        }
    }

    public function deletecart($id, $pid)
    {
        $product = Product::find($pid);
        $salescart = Salescart::find($id);
        $product->stock = $product->stock + $salescart->sale_quantity;
        if ($product->update()) {
            $salescart->delete();
            return redirect()->back()->with('success_message', 'Seccessfully Deleted Item');
        }else {
            return redirect()->back()->with('error_messsage', 'Failed To Delete Item');
        }
    }

    public function clearcart(Request $request)
    {
        
        DB::table('salescarts')->delete();
        
        return redirect()->back()->with('success_message', 'Seccessfully Cleared Bucket');
       
    }
}
