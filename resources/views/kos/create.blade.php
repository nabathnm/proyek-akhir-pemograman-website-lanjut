@extends('layouts.app')

@section('content')

<form action="{{ route('kos.store') }}" method="POST">
    @csrf

```
<div class="mb-3">
    <label>Nama Kos</label>
    <input type="text" name="nama_kos" class="form-control">
</div>

<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control"></textarea>
</div>

<button class="btn btn-success">Simpan</button>
```

</form>

@endsection
