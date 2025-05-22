<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Original_product;
use App\Models\Original_product_image;
use App\Models\Original_product_technologie_tag;
use App\Models\Original_product_post;
use App\Models\User_follow;
use App\Models\Technologie;

class ProductService
{
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;

    public function index()
    {
        $products = Original_product::with(['technologies', 'images', 'posts.user.profile'])
            ->orderBy('created_at', 'desc')
            ->get();

        $popularTagIds = DB::table('original_product_technologie_tags')
            ->select('technologie_id', DB::raw('count(*) as count'))
            ->groupBy('technologie_id')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('technologie_id');

        $popularTags = Technologie::whereIn('id', $popularTagIds)->get();

        return [
            'products' => $products,
            'popularTags' => $popularTags,
        ];
    }

    public function getProductsByTag($tagId)
    {
        $products = Original_product::whereHas('technologies', function($query) use ($tagId) {
            $query->where('technologie_id', $tagId);
        })
        ->with(['technologies', 'images', 'posts.user.profile'])
        ->orderBy('created_at', 'desc')
        ->get();

        $popularTagIds = DB::table('original_product_technologie_tags')
            ->select('technologie_id', DB::raw('count(*) as count'))
            ->groupBy('technologie_id')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('technologie_id');

        $popularTags = Technologie::whereIn('id', $popularTagIds)->get();

        return [
            'products' => $products,
            'popularTags' => $popularTags,
        ];
    }

    public function create()
    {
        return view('products.create2');
    }

    public function store(array $data, array $images = [])
    {
        return DB::transaction(function () use ($data, $images) {
            $product = Original_product::create($data);

            $this->storeTags($product->id, $data['tags'] ?? []);
            $this->storeImages($product->id, $images);

            Original_product_post::create([
                'original_product_id' => $product->id,
                'posted_user_profile_id' => Auth::id(),
            ]);

            return $product;
        });
    }

    public function show(string $id)
    {
        $product = Original_product::with([
            'technologies', 'images', 'profile', 'comments.user.profile'
        ])->findOrFail($id);

        $user = Auth::user();
        if (!$user || !$user->profile) return null;

        $isFollow = $user->id !== $product->profile->user_id &&
            User_follow::where('follower_id', $user->id)
                ->where('following_id', $product->profile->user_id)
                ->exists();

        return compact('product', 'user', 'isFollow');
    }

    public function edit(string $id)
    {
        $product = Original_product::with(['technologies', 'images', 'posts'])->findOrFail($id);

        if (!$product->posts->contains('posted_user_profile_id', Auth::id()) || Auth::id() !== $product->profile->user_id) {
            return null;
        }

        return [
            'product' => $product,
            'technologieIds' => $product->technologies->pluck('id'),
        ];
    }

    public function update(array $validated, Original_product $product, array $requestData)
    {
        return DB::transaction(function () use ($validated, $product, $requestData) {
            $product->update($validated);

            $tags = array_unique($requestData['tags'] ?? []);
            $product->technologies()->sync($tags);

            $this->handleImageUpdate($product, $requestData);

            return $product;
        });
    }

    public function destroy(string $id): bool
    {
        $product = Original_product::findOrFail($id);
        if (Auth::id() !== $product->profile->user_id) {
            abort(403, '許可されていない操作です。');
        }
        return $product->delete();
    }

    private function storeTags(int $productId, array $tags): void
    {
        foreach (array_unique($tags) as $tagId) {
            Original_product_technologie_tag::create([
                'original_product_id' => $productId,
                'technologie_id' => $tagId,
            ]);
        }
    }

    private function storeImages(int $productId, array $images): void
    {
        foreach ($images as $image) {
            if ($image instanceof UploadedFile && $image->isValid()) {
                $path = $image->store('original_product_images', 'public');
                Original_product_image::create([
                    'original_product_id' => $productId,
                    'image_dir' => '/storage/' . $path,
                ]);
            }
        }
    }

    private function handleImageUpdate(Original_product $product, array $requestData): void
    {
        $deletedImageIds = array_map('intval', $requestData['deleted_image_ids'] ?? []);
        foreach ($deletedImageIds as $id) {
            $image = Original_product_image::find($id);
            if ($image) {
                Storage::delete(str_replace('/storage/', 'public/', $image->image_dir));
                $image->delete();
            }
        }

        $existingImageIds = $requestData['existing_image_ids'] ?? [];
        $newImages = $requestData['images'] ?? [];

        foreach ($existingImageIds as $index => $imageId) {
            if (isset($newImages[$index]) && $newImages[$index] instanceof UploadedFile && $newImages[$index]->isValid()) {
                $image = Original_product_image::find($imageId);
                if ($image) {
                    Storage::delete(str_replace('/storage/', 'public/', $image->image_dir));
                    $path = $newImages[$index]->store('original_product_images', 'public');
                    $image->update(['image_dir' => '/storage/' . $path]);
                }
            }
        }

        foreach ($newImages as $index => $file) {
            if ($file instanceof UploadedFile && $file->isValid() && empty($existingImageIds[$index])) {
                $path = $file->store('original_product_images', 'public');
                Original_product_image::create([
                    'original_product_id' => $product->id,
                    'image_dir' => '/storage/' . $path,
                ]);
            }
        }
    }
}
