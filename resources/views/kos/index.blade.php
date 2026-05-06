@extends('layouts.app')

@section('content')

<a href="{{ route('kos.create') }}" class="btn btn-primary mb-3">Tambah Kos</a>

<table class="table table-bordered">
    <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

```
@foreach($kos as $item)
<tr>
    <td>{{ $item->nama_kos }}</td>
    <td>{{ $item->alamat }}</td>
    <td>
        <a href="{{ route('kos.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
        <a href="{{ route('kos.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

        <form action="{{ route('kos.destroy', $item->id) }}" method="POST" style="display:inline;">
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
