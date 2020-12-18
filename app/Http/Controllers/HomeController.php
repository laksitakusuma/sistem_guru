<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $data = [
            'nama_sekolah' => 'SMP 1 SEMARANG',
            'alamat' => 'jalan ronggolawe'
        ];
        return view('v_home', $data);
    }
    public function about($id) {
        return 'Ini Halaman About<br>'. $id;
    }
}
