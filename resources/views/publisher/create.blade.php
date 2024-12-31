@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Test</h1>

    <form action="{{ route('publisher.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <label for="description">description</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection