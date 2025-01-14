@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <h3 class="text-center my-2">kirim email</h3>
        <div class="col-md-4 p-4">
            {{-- send email --}}
            @if (session('status'))
            <div class="alert alert-primary" role="alert">
                {{ session('status') }}
            </div>

            @endif
            <form action="{{ route('post-email') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama">
                </div>
                <div class="form-group my-3">
                    <label for="email">Email Tujuan</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Tujuan">
                </div>
                <div class="form-group my-3">
                    <label for="name">Body Deskripsi</label>
                    <textarea name="body" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Kirim Email</button>
                </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
@endsection