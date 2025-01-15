<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') }} | Apprentory</title>
    <style>
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .image-gallery img {
            max-width: 300px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>{{ htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') }}</h1>
    <p><strong>サブタイトル:</strong> {{ htmlspecialchars($product->subtitle, ENT_QUOTES, 'UTF-8') }}</p>
    <p><strong>詳細:</strong> {!! nl2br(e($product->product_detail)) !!}</p>
    <p><strong>プロダクトURL:</strong> <a href="{{ $product->product_url }}" target="_blank">{{ $product->product_url }}</a></p>
    @if($product->github_url)
        <p><strong>GitHub URL:</strong> <a href="{{ $product->github_url }}" target="_blank">{{ $product->github_url }}</a></p>
    @endif
    <p><strong>投稿カテゴリ:</strong> 
        {{ $product->element === 'need-tester' ? 'テスター募集中' : 'レビュー募集中' }}
    </p>
    <p><strong>タグ:</strong>
        @foreach($product->technologies as $tag)
            <span>{{ htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8') }}</span>@if(!$loop->last), @endif
        @endforeach
    </p>    
    <div class="image-gallery">
        @foreach($product->images as $image)
            <img src="{{ asset('storage/' . str_replace('public/', '', $image->image_dir)) }}" alt="投稿画像">
        @endforeach
    </div>
</body>
</html>

