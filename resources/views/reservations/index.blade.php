@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Haz una reservacion</div>
                <div class="card-body">
                    <form action="{{route('reservations.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="sala">Elige una sala</label>
                            <select name="boardroom_id" id="boardroom_id" class="form-control" required>
                                <option value="">Selecciona una sala</option>
                                @foreach ($boardrooms as $sala)
                                    <option value="{{ $sala->id }}">{{ $sala->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha inicial</label>
                            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha final</label>
                            <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                        </div>
                        <button class="btn btn-primary mt-2" type="submit">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
        @if (Auth::user()->isAdmin())
            @if (count($reservations)<=0)
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">Todas las reservaciones</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            No hay reservaciones
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            Todas las reservaciones
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope='col'>Usuario</th>
                                            <th scope='col'>Sala</th>
                                            <th scope='col'>Fecha inicial</th>
                                            <th scope='col'>Fecha final</th>
                                            <th scope='col'>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $reservation )
                                            <tr>
                                                <th scope="row">{{$reservation->id}}</th>
                                                <td>{{$reservation->user->name}}</td>
                                                <td>{{$reservation->boardroom->name}}</td>
                                                <td>{{$reservation->start_time}}</td>
                                                <td>{{$reservation->end_time}}</td>
                                                <td>
                                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @if (count($reservations)<=0)
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">Tus reservaciones</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            No tienes reservaciones
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            Tus reservaciones
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope='col'>Usuario</th>
                                            <th scope='col'>Sala</th>
                                            <th scope='col'>Fecha inicial</th>
                                            <th scope='col'>Fecha final</th>
                                            <th scope='col'>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $reservation )
                                            <tr>
                                                <th scope="row">{{$reservation->id}}</th>
                                                <td>{{$reservation->user->name}}</td>
                                                <td>{{$reservation->boardroom->name}}</td>
                                                <td>{{$reservation->start_time}}</td>
                                                <td>{{$reservation->end_time}}</td>
                                                <td>
                                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                                    </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
