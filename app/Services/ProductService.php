<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Original_product;
use App\Models\Original_product_image;
use App\Models\Original_product_technologie_tag;
use App\Models\Original_product_post;
use App\Models\Technologie;

use Illuminate\Http\Request;

class ProductService
{
    /**
     * 全オリジナルプロダクトを取得する
     * - 関連するタグ、画像、投稿者情報も一緒にロードする
     * - 作成日が新しい順に並べ替える
     */
    public function index()
    {
        $products = Original_product::with(['technologies', 'images', 'posts.user.profile'])
            ->orderBy('created_at', 'desc') // 作成日時で降順
            ->get();
        return $products; 
    }

    /**
     * 人気の技術タグを取得する
     * - 中間テーブル original_product_technologie_tags から
     * - technologie_id ごとの使用回数を集計
     * - 使用回数が多い順に並べて上位5個を取得
     */
    public function getPopularTags()
    {
        $popularTagIds = DB::table('original_product_technologie_tags')
            ->select('technologie_id', DB::raw('count(*) as count'))
            ->groupBy('technologie_id') // technologie_idごとにまとめる
            ->orderByDesc('count')       // 使用回数が多い順に並べる
            ->limit(5)                   // 上位5件だけ取得
            ->pluck('technologie_id');   // technologie_idだけ取り出す

            if ($popularTagIds->isEmpty()) { //nullの場合
                return collect(); // 空コレクション返す
            }
        

        // 取得したIDに該当するTechnologyレコードをまとめて取得
        return Technologie::whereIn('id', $popularTagIds)->get();
    }

    /**
     * 指定されたタグIDに紐づくオリジナルプロダクトを取得する
     *
     * @param int $tagId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProductsByTag($tagId)
    {
        return Original_product::whereHas('technologies', function($query) use ($tagId) {
                $query->where('technologie_id', $tagId);
            })
            ->with(['technologies', 'images', 'posts.user.profile'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

}