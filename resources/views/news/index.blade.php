@extends('layouts.main')

@section('container')
    <h1 class="text-3xl font-bold mb-6">Daftar Berita</h1>
    <div class="space-y-6">
        @foreach ($news_list as $news)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-2">
                    <a href="{{ route('news.show', $news->id) }}" class="text-blue-600 hover:underline">
                        {{ $news->judul }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">Oleh: {{ $news->wartawan->nama }} | Dipublikasikan pada: {{ $news->created_at->format('d M Y') }}</p>
                <p class="text-gray-800">{{ Str::limit($news->ringkasan, 150, '...') }}</p>
                <a href="{{ route('news.show', $news->id) }}" class="text-blue-500 hover:underline mt-4 inline-block">Baca Selengkapnya</a>
            </div>
        @endforeach
    </div>
@endsection