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
            'price' => 'required',
            'tax'=>'required',
            'sales_quantity' => 'required',
        ]);
        if ($request->ajax()) {
            $sales = new Salescart();
            $sales->product_id = $request->product_id;
            $sales->quantity = $request->sales_quantity;
            // if($sales->quantity<)
            $total=$request->price * $request->sales_quantity;
            $taxPer=$request->tax*$total;
            $taxAmt=$taxPer/100;
            $sales->price = $total+$taxAmt;
            $sales->tax=$request->tax;
            $sales->sales_status = $request->sales_status;
            $sales->saller_name = Auth::user()->username;
            $sales->sales_date = date('Y-m-d');
            if ($sales->save()) {
                $product = Product::find($request->product_id);
                $product->stock = $product->stock - $request->sales_quantity;
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
            ->select('sales.*', 'products.name')
            ->orderBy('sales.created_at', 'DEC')
            ->get();
        return view('backend.sales.list', compact('sales'));
    }

    public function ajaxlist()
    {
        $sales = Salescart::join('products', 'products.id', '=', 'salescarts.product_id')
            ->select('salescarts.*', 'products.name')
            ->orderBy('salescarts.created_at', 'DEC')
            ->get();
        return view('backend.sales.ajaxlist', compact('sales'));
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

    public function getprice(Request $request)
    {
        $product = Product::where('id', $request->product_id)->get();
        echo $product[0]->price;
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
            ->select('salescarts.*', 'products.name')
            ->get();
            // echo "<pre>"; print_r($report); die;
        return view('backend.pdfbill.salesbill', compact('report'));
    }

    public function getcustomreport(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $report = Sale::join('products', 'products.id', 'sales.product_id')
            ->select('sales.*', 'products.name')
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
            ->select('sales.*', 'products.name')
            ->whereBetween('sales.sales_date', [$start, $end])
            ->get();
            
        return view('backend.pdfbill.allreport', compact('report', 'start', 'end'));
        
    } 


    public function savetosales(Request $request)
    {
        for ($i = 0; $i < $request->input('total_product'); $i++) {
            $od = [
                'product_id' => $request['product_id'][$i],
                'quantity' => $request['quantity'][$i],
                'price' => $request['price'][$i],
                'tax' => $request['tax'][$i],
                'sales_status' => $request['sales_status'][$i],
                'saller_name' => Auth::user()->username,
                'sales_date' => date('Y-m-d'),
            ];
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
        $product->stock = $product->stock + $salescart->quantity;
        if ($product->update()) {
            $salescart->delete();
            return redirect()->back()->with('success_message', 'Seccessfully Deleted Item');
        }else {
            return redirect()->back()->with('error_messsage', 'Failed To Delete Item');
        }
    }
}
