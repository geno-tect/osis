@extends('layouts.public')

@section('title', $article['title'])
@section('page', 'berita')
@section('meta_description', $article['excerpt'])

@section('content')
    <section class="page-hero article-hero" aria-labelledby="article-title">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li><a href="{{ route('beranda') }}#berita">Berita &amp; Event</a></li>
                    <li aria-current="page">{{ $article['title'] }}</li>
                </ol>
            </nav>

            <div class="article-meta">
                <span class="chip">{{ $article['category'] }}</span>
                <time datetime="{{ $article['date'] }}">{{ $article['date_label'] }}</time>
            </div>

            <h1 id="article-title">{{ $article['title'] }}</h1>
            <p class="page-lede">{{ $article['excerpt'] }}</p>
        </div>
    </section>

    <article class="article">
        <div class="container">
            <div class="article-media" aria-hidden="true">
                @if (!empty($article['image']))
                    <img src="{{ asset($article['image']) }}" alt="" class="article-media__img" width="1280" height="720">
                @else
                    <span class="news-media__ring"></span>
                    <span class="news-media__label">Foto liputan</span>
                @endif
            </div>

            <div class="article-body">
                @foreach ($article['body'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach

                <a class="back-link" href="{{ route('beranda') }}#berita">
                    <x-ikon-situs name="arrow-left" :size="18" />
                    Kembali ke berita
                </a>
            </div>
        </div>
    </article>
@endsection
