@extends('layouts.app')

@section('content')

<form action="{{ route('kos.kamar.store', $kos->id) }}" method="POST">
    @csrf

```
<input type="text" name="nama_kamar" placeholder="Nama kamar" class="form-control mb-2">
<input type="number" name="harga" placeholder="Harga" class="form-control mb-2">
<textarea name="fasilitas" class="form-control mb-2"></textarea>

<button class="btn btn-success">Simpan</button>
```

</form>

@endsection
