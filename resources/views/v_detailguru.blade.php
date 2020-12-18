@extends('layout.v_template')
@section('title', 'Detail Guru')
@section('content')
<table class="table">
    <tr>
        <th>NIP</th>
        <th>:</th>
        <th>{{ $guru->nip }}</th>
    </tr>
    <tr>
        <th>Nama Guru</th>
        <th>:</th>
        <th>{{ $guru->nama_guru }}</th>
    </tr>
    <tr>
        <th>Mata Pelajaran</th>
        <th>:</th>
        <th>{{ $guru->mapel }}</th>
    </tr>
    <tr>
        <th>Foto Guru</th>
        <th>:</th>
        <th><img src=" {{ url('foto_guru/'.$guru->foto_guru) }} " width="70px"></th>
    </tr>
    <tr>
        <th><a href="/guru" class="btn btn-success btn-sm">Kembali</a></th>
    </tr>
</table>

@endsection