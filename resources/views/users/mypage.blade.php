@extends('layouts.layout')

@section('title', 'マイページ | Apprentory')

@section('content')
    <main>
        <p><strong>ユーザーID:</strong> {{ $profile->user->userid }}</p>
        <p><strong>ユーザーネーム:</strong> {{ $profile->username }}</p>
        <p><strong>プロフィール画像:</strong></p>
        <img src="{{ asset($profile->profile_image) }}" alt="プロフィール画像" width="50">

        <a href="/">トップページへ戻る</a>
        <a href="{{ route('logout') }}">ログアウト</a>
    </main>@endsection