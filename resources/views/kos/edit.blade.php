@extends('layouts.app')

@section('content')

<form action="{{ route('kos.update', $kos->id) }}" method="POST">
    @csrf
    @method('PUT')

```
<input type="text" name="nama_kos" value="{{ $kos->nama_kos }}" class="form-control mb-2">
<textarea name="alamat" class="form-control mb-2">{{ $kos->alamat }}</textarea>
<textarea name="deskripsi" class="form-control mb-2">{{ $kos->deskripsi }}</textarea>

<button class="btn btn-success">Update</button>
```

</form>

@endsection
