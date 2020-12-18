<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuruModel;

class GuruController extends Controller
{
    public function __construct() {
        $this->GuruModel = new GuruModel();
    }

    public function index() {
        $data = [
            'guru' => $this->GuruModel->allData(), 
        ];
        return view('v_guru', $data);
    }

    public function detail($id_guru) {
        if (!$this->GuruModel->detailData($id_guru)) {
            abort(404);
        } 

        $data = [
            'guru' => $this->GuruModel->detailData($id_guru), 
        ];
        return view('v_detailguru', $data);
    }

    public function add() {
        return view('v_addguru');
    }

    public function insert() {
        Request()->validate([
            'nip' => 'required|unique:tbl_guru,nip|min:4|max:5',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'required|mimes:jpeg,bmp,png,jpg|max:1024',
        ],
        [
            'nip.required' => 'wajib diisi',
            'nip.unique' => 'nip sudah ada',
            'nip.min' => 'nip minimal 4 karakter',
            'nip.max' => 'nip maksimal 5 karakter',
            'nama_guru.required' => 'nama guru wajib diisi',
            'mapel.required' => 'mata pelajaran wajib diisi',
            'foto_guru.required' => 'wajib diisi'
        ]);

        $file = Request()->foto_guru;
        $fileName = Request()->nip . '.' . $file->extension();
        //nama file foto stlh di upload
        $file->move(public_path('foto_guru'), $fileName);
    
        $data = [
            'nip' => Request()->nip,
            'nama_guru' => Request()->nama_guru,
            'mapel' => Request()->mapel,
            'foto_guru' => $fileName,
        ];
        $this->GuruModel->addData($data);
        return redirect()->route('guru')->with('pesan', 'Data berhasil ditambahkan !!!');
        //ini disambung ke Route::get('/guru',[GuruController::class, 'index'])->name('guru');
        //juga nyambung ke {{ session('pesan') }} di v_guru
    }

    public function edit($id_guru) {
        //biar link ($id_guru) ga diakses
        if (!$this->GuruModel->detailData($id_guru)) {
            abort(404);
        }
        $data = [
            'guru' => $this->GuruModel->detailData($id_guru), 
        ];
        return view('v_editguru', $data);
    }

    public function update($id_guru) {
        Request()->validate([
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'mimes:jpeg,bmp,png,jpg|max:1024',
        ],
        [
            'nip.required' => 'wajib diisi',
            'nip.min' => 'nip minimal 4 karakter',
            'nip.max' => 'nip maksimal 5 karakter',
            'nama_guru.required' => 'nama guru wajib diisi',
            'mapel.required' => 'mata pelajaran wajib diisi'
        ]);

        if(Request()->foto_guru <> "") { //kalo foto nya mau di edit
            $file = Request()->foto_guru;
            $fileName = Request()->nip . '.' . $file->extension();
            //nama file foto stlh di upload
            $file->move(public_path('foto_guru'), $fileName);
        
            $data = [
                'nip' => Request()->nip,
                'nama_guru' => Request()->nama_guru,
                'mapel' => Request()->mapel,
                'foto_guru' => $fileName,
            ];
            $this->GuruModel->editData($id_guru, $data);
            //ini disambung ke Route::get('/guru',[GuruController::class, 'index'])->name('guru');
            //juga nyambung ke {{ session('pesan') }} di v_guru
        } else { //mau foto nya tetap dengan foto yg sama
            $data = [
                'nip' => Request()->nip,
                'nama_guru' => Request()->nama_guru,
                'mapel' => Request()->mapel
            ];
            $this->GuruModel->editData($id_guru, $data);
        }
        return redirect()->route('guru')->with('pesan', 'Data berhasil di update !!!');
    }

    public function delete($id_guru) {
        //hapus foto di local
        $guru = $this->GuruModel->detailData($id_guru);
        if ($guru->foto_guru <> "") {
            unlink(public_path('foto_guru').'/'.$guru->foto_guru);
        }
        
        $this->GuruModel->deleteData($id_guru);
        return redirect()->route('guru')->with('pesan', 'Data berhasil di hapus !!!');
    }
}
