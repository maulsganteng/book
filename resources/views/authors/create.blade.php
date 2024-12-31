@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Penulis Baru</h1>

    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Penulis</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>


        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
