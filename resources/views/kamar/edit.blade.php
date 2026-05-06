@extends('layouts.app')

@section('content')

<form action="{{ route('kos.kamar.update', [$kos->id, $kamar->id]) }}" method="POST">
    @csrf
    @method('PUT')

```
<input type="text" name="nama_kamar" value="{{ $kamar->nama_kamar }}" class="form-control mb-2">
<input type="number" name="harga" value="{{ $kamar->harga }}" class="form-control mb-2">

<select name="status" class="form-control mb-2">
    <option value="kosong">Kosong</option>
    <option value="terisi">Terisi</option>
</select>

<button class="btn btn-success">Update</button>
```

</form>

@endsection
