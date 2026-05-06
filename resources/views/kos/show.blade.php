@extends('layouts.app')

@section('content')

<h3>{{ $kos->nama_kos }}</h3>
<p>{{ $kos->alamat }}</p>

<a href="{{ route('kos.kamar.create', $kos->id) }}" class="btn btn-primary mb-3">
    Tambah Kamar
</a>

<table class="table">
    <tr>
        <th>Nama</th>
        <th>Harga</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

```
@foreach($kos->kamar as $kamar)
<tr>
    <td>{{ $kamar->nama_kamar }}</td>
    <td>{{ $kamar->harga }}</td>
    <td>{{ $kamar->status }}</td>
    <td>
        <a href="{{ route('kos.kamar.edit', [$kos->id, $kamar->id]) }}" class="btn btn-warning btn-sm">Edit</a>

        <form action="{{ route('kos.kamar.destroy', [$kos->id, $kamar->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
```

</table>

@endsection
