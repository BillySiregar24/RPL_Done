<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->get()->take(6);
        $mostViews = Berita::with('kategori')->orderByDesc('total_view')->get()->take(3);
        return view('frontend.content.home', compact('menu', 'berita', 'mostViews'));
    }

    public function detailBerita($id){
        $menu = $this->getMenu();
        $berita = Berita::findOrFail($id);

        $berita ->total_view = $berita ->total_view + 1;
        $berita->save();
        return view('frontend.content.detailBerita', compact('menu', 'berita'));
    }

    public function detailPage($id){
        $menu = $this->getMenu();
        $page = Page::findOrFail($id);
        return view('frontend.content.detailPage', compact('menu', 'page'));
    }

    public function semuaBerita(){
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->get();
        return view('frontend.content.semuaBerita', compact('menu', 'berita'));
    }

    private function getMenu(){
        $menu = Menu::whereNull('parent_menu')
            ->with(['submenu' => fn($q) => $q->where('status_menu', '=', 1)->orderBy('urutan_menu', 'asc')])
            ->where('status_menu', '=', 1)
            ->orderBy('urutan_menu', 'asc')
            ->get();

        $dataMenu = [];
        foreach ($menu as $m) {
            $jenis_menu = $m->jenis_menu;
            $url_menu = "";

            if ($jenis_menu == "url"){
                $url_menu = $m->url_menu;
            }else{
                $url_menu = route('home.detailPage', $m->url_menu);
            }

            $dItemMenu = [];
            foreach ($m->submenu as $im){
                $jenisItemMenu = $im->jenis_menu;
                $urlItemMenu = "";

                if ($jenisItemMenu == "url"){
                    $urlItemMenu = $im->url_menu;
                }else{
                    $urlItemMenu = route('home.detailPage', $im->url_menu);
                }

                $dItemMenu[] = [
                    'sub_menu_nama' => $im->nama_menu,
                    'sub_menu_target' => $im->target_menu,
                    'sub_menu_url' => $urlItemMenu,
                ];
            }

            $dataMenu[] = [
                'menu' => $m->nama_menu,
                'target' => $m->target_menu,
                'url' => $url_menu,
                'itemMenu' => $dItemMenu
            ];
        }

        return $dataMenu;
    }
}
