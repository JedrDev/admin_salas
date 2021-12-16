@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Salas de juntas</div>
                <div class="card-body">
                    <div class="container m-2">
                        @if (count($boardrooms) > 0)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($boardrooms as $boardroom)
                                        <tr>
                                            <th scope="row">{{ $boardroom->id }}</th>
                                            <td>{{ $boardroom->name }}</td>
                                            <td>{{ $boardroom->description }}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="{{ route('boardrooms.edit', $boardroom->id) }}" class="btn btn-warning btn-sm mx-1">Editar</a>
                                                    <form action="{{ route('boardrooms.destroy', $boardroom->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mx-1">Eliminar</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <div class="container text-center">
                                {{__('No hay salas de juntas registradas')}}
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Crear sala de juntas</div>
                <div class="card-body">
                    <form action="{{route('boardrooms.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripcion</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Descripcion">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
