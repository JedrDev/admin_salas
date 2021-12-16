@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar sala num :{{$boardroom->id}} </div>

                <div class="card-body">
                    <div class="container">
                        <form action="{{route('boardrooms.update',$boardroom->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$boardroom->name}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <input type="text" name="description" id="description" class="form-control" value="{{$boardroom->description}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-3">
            <a href="{{route('boardrooms.index')}}" class="btn btn-danger">Atras</a>
        </div>
    </div>
</div>
@endsection
