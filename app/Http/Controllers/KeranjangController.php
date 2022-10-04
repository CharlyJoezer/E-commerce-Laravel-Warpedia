<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return back();
        }
        $dataKeranjang = Keranjang::where('user_id', auth()->user()->id)->with(['toko', 'product'])->get();
        return view('keranjang', [
            'title' => 'Warpedia | Keranjang',
            'css' => 'keranjang.css',
            'js' => 'keranjang.js',
            'data' => $dataKeranjang
        ]);
    }
    public function insertKeranjang(Request $request)
    {
        try {
            if (!auth()->user()) {
                return ['status' => false];
            }
            if (!is_numeric($request->order) || $request->order == null) {
                return response()->json(['status' => 'fail']);
            }
            if (!is_numeric($request->product_item) || $request->product_item == null) {
                return response()->json(['status' => 'fail']);
            }
            $id_product = $request->product_item / 3625;
            $getProduct = Product::where('id', $id_product)->first();
            $getJumlahOrder = $request->order;

            $finaldata = [
                'nama_produk' => $getProduct->nama_produk,
                'user_id' => auth()->user()->id,
                'toko_id' => $getProduct->toko_id,
                'product_id' => $getProduct->id,
                'harga' => $getProduct->harga_produk,
                'jumlah_order' => $getJumlahOrder
            ];

            $checkAlready = Keranjang::where('product_id', $id_product)->get();
            if (count($checkAlready) > 0) {
                Keranjang::where('product_id', $id_product)->update(['jumlah_order' => $checkAlready[0]['jumlah_order'] + $getJumlahOrder]);
                return response()->json(['status' => true]);
            }

            Keranjang::create($finaldata);
            return response()->json(['status' => 'true']);
        } catch (Exception $e) {
            return response()->json(['status' => 'Server Error 500']);
        }
    }

    public function ubahJumlahPesanan(Request $request)
    {
        try {
            if (Auth::check()) {
                if (is_numeric($request->produk['id_produk']) && is_numeric($request->produk['afterChange'])) {
                    $getKeranjangItem = Keranjang::where('id', $request->produk['id_produk'])->update(['jumlah_order' => $request->produk['afterChange']]);
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'ERROR_T'];
                }
            } else {
                return ['status' => 'ERROR_A'];
            }
        } catch (Exception) {
            return ['status' => 'Server Error'];
        }
    }

    public function deleteItemKeranjang($id)
    {
        if (Auth::check()) {
            Keranjang::where(['id' => $id, 'user_id' => auth()->user()->id])->delete();
            return back();
        } else {
            return redirect('/login');
        }
    }

    public function prosesCheckoutKeranjang(Request $request)
    {
        $request->validate([
            'item1' => 'numeric|string',
            'item2' => 'numeric|string',
            'item3' => 'numeric|string',
            'item4' => 'numeric|string',
            'item5' => 'numeric|string'
        ]);
        $arg = [];
        $item = [
            $request->item1,
            $request->item2,
            $request->item3,
            $request->item4,
            $request->item5,
        ];
        for ($i = 0; $i < 5; $i++) {
            if ($item[$i] == null) {
                break;
            }
            // if (!is_numeric($item[$i])) {
            //     return back();
            // }
            $arg[$i] = $item[$i];
        }

        return Keranjang::whereIn('id', $arg)->get();
    }
}
