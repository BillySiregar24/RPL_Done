@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Form Ubah Menu</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{route('menu.prosesUbah')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama_menu" placeholder="Nama Menu" value="{{$menu->nama_menu}}"
                               class="form-control @error('nama_menu')is-invalid @enderror">
                        @error('nama_menu')
                        <span style="color: red; font-weight: 600; font-size: 9pt">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Menu</label>
                        <div class="custom-radio">
                            <input type="radio" value="page" name="jenis_menu" id="page">
                            <label>Page</label>
                            <input type="radio" value="url" name="jenis_menu" id="url">
                            <label>URL</label>
                        </div>
                        @error('jenis_menu')
                        <span style="color: red; font-weight: 600; font-size: 9pt">{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Elemen HTML Formulir -->
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <div id="url_tampil">
                            <input type="url" name="link_url" id="link_url" class="form-control" placeholder="URL">
                        </div>

                        <div id="page_tampil">
                            <select name="link_page" class="form-control" id="link_page">
                                @foreach($page as $row)
                                    <option value="{{$row->id_page}}">{{$row->judul_page}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Menu</label>
                        <div class="custom-radio">
                            <input type="radio" value="_self" name="target_menu" id="_self">
                            <label>Tab saat ini</label>
                            <input type="radio" value="_blank" name="target_menu" id="_blank">
                            <label>Tab Baru</label>
                        </div>
                        @error('jenis_menu')
                        <span style="color: red; font-weight: 600; font-size: 9pt">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent Menu</label>
                        <select name="parent_menu" class="form-control" id="parent_menu">
                            <option selected value="">Pilih Parent</option>
                            @foreach($parent->sortBy('urutan_menu') as $row)
                                <option value="{{$row->id_menu}}">{{$row->nama_menu}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Menu</label>

                        @php
                            $aktif = "";
                            $tidakAktif = "";
                            if ($menu->status_menu ==1){
                                $aktif ="selected";
                            }else{
                                $tidakAktif = "selected";
                            }
                        @endphp
                        <select name="status_menu" class="form-control" id="status_menu">
                            <option value="1" {{$aktif}}>Aktif</option>
                            <option value="0" {{$tidakAktif}}>Tidak Aktif</option>
                        </select>
                    </div>

                    <input type="hidden" name="id_menu" value="{{$menu->id_menu}}">
                    <input type="hidden" id="jenis_menu_old" value="{{$menu->jenis_menu}}">
                    <input type="hidden" id="url" value="{{$menu->url_menu}}">
                    <input type="hidden" id="target_menu_old" value="{{$menu->target_menu}}">
                    <input type="hidden" id="parent_menu_old" value="{{$menu->parent_menu}}">

                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="{{route('menu.index')}}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Skrip JavaScript -->
    <script>
        $(function () {
            // Set nilai input URL atau dropdown halaman sesuai dengan data dari database
            var url_menu_old = "{{ $menu->url_menu }}"; // Ganti dengan variabel yang sesuai
            var page_menu_old = "{{ $menu->parent_menu }}"; // Ganti dengan variabel yang sesuai

            $("#link_url").val(url_menu_old);
            $("#link_page").val(page_menu_old);

            // Lakukan hal yang sama untuk jenis menu
            var jenis_menu_old = "{{ $menu->jenis_menu }}";
            if (jenis_menu_old == 'page') {
                $('#page').prop("checked", true);
                $("#url_tampil").hide();
                $("#page_tampil").show();
            } else {
                $('#url').prop("checked", true);
                $("#url_tampil").show();
                $("#page_tampil").hide();
            }

            $("#page").click(function () {
                $("#url_tampil").hide();
                $("#page_tampil").show();
            });

            $("#url").click(function () {
                $("#url_tampil").show();
                $("#page_tampil").hide();
            });
        });

    </script>
@endsection

