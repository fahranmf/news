<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // ini method controller untuk landing page news
    public function index()
    {
        $semua_berita = News::with('wartawan', 'komentar')
        ->latest()
        ->get();

        return view('news.index', [
            'news_list' => $semua_berita
        ]);
    }

    // ini method controller untuk menampilkan detail news
    // $news akan otomatis diisi oleh Laravel berdasarkan id news yang diakses di route
    // News $news artinya Laravel akan melakukan route model binding
    public function show(News $news)
    {
        // load relasi wartawan dan komentar
        $news->load('wartawan', 'komentar');

        // tampilkan view news.show dengan mengirim data news yang sudah di load relasinya
        return view('news.show', [
            'news' => $news
        ]);
    }
}
