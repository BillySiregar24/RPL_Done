<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('kategori')->get();
        return view('backend.content.berita.list', compact('berita'));
    }
    public function tambah()
    {

    }
    public function prosesTambah(Request $request)
    {

    }
    public function ubah()
    {

    }
    public function prosesUbah(Request $request)
    {

    }
    public function hapus()
    {

    }
}
