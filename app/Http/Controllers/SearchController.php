<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Original_product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('search', ''));

        $keywords = array_filter(preg_split('/\s+/', mb_convert_kana($query, 's')));

        $materials = $this->searchMaterials($keywords); 
        $products = $this->searchProducts($keywords);

        $materialsCount = $materials->count();
        $productsCount = $products->count();

        return view('search.result_search', compact('materials', 'products', 'query', 'materialsCount', 'productsCount'));
    }

    private function searchMaterials(array $keywords)
    {
        return Material::when(!empty($keywords), function ($query) use ($keywords) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%");
                }
            })
            ->orWhereHas('technologies', function ($techQuery) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $techQuery->where('name', 'LIKE', "%{$keyword}%");
                }
            });
        })->get();
    }
    
    private function searchProducts(array $keywords)
    {
        return Original_product::when(!empty($keywords), function ($query) use ($keywords) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%")
                      ->orWhere('subtitle', 'LIKE', "%{$keyword}%")
                      ->orWhere('product_detail', 'LIKE', "%{$keyword}%");
                }
            })
            ->orWhereHas('technologies', function ($techQuery) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $techQuery->where('name', 'LIKE', "%{$keyword}%");
                }
            });
        })->get();
    }
    
    
}
