<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Original_product;
use App\Models\Original_product_image;
use App\Models\Original_product_technologie_tag;
use App\Models\Original_product_post;
use Illuminate\Http\Request;

class ProductService
{
    public function index()
    {
        
        $products = Original_product::with(['technologies', 'images', 'posts.user.profile'])
                                ->orderBy('created_at', 'desc') // 作成日時で降順
                                ->get();

        //dd($products);

        return view('products.index', compact('products'));
    }
}