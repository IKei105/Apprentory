<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; // 教材のモデル
use App\Models\Original_product; // オリプロのモデル

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 送信されたデータから取得する
        $query = trim($request->input('search', ''));

        // 半角・全角スペースを統一して分割し、空の要素を除外
        $keywords = array_filter(preg_split('/\s+/', mb_convert_kana($query, 's')));

        $materials = $this->searchMaterials($keywords); 
        $products = $this->searchProducts($keywords);

        // 検索結果の件数を取得
        $materialsCount = $materials->count();
        $productsCount = $products->count();

        return view('search.result_search', compact('materials', 'products', 'query', 'materialsCount', 'productsCount'));
    }

    /**
     * 教材を検索するメソッド
     */
    private function searchMaterials(array $keywords)
    {
        return Material::when(!empty($keywords), function ($query) use ($keywords) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%");
                }
            });
        })->get();
    }

    /**
     * オリジナルプロダクトを検索するメソッド
     */
    private function searchProducts(array $keywords)
    {
        return Original_product::when(!empty($keywords), function ($query) use ($keywords) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%");
                }
            });
        })->get();
    }
}
