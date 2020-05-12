


@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    les hopitaux

                </div>
                <br>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">address</th>
                        <th scope="col">operations</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($hospitals) && $hospitals->count() >0)
                        @foreach($hospitals as $hospital)
                    <tr>
                        <th scope="row">{{$hospital->id}}</th>
                        <td>{{$hospital->name}}</td>
                        <td>{{$hospital->address}} </td>
                        <td>
                            <a href="{{route('hospital.doctors',$hospital ->id)}}" class="btn btn-success"> afficher les medecins</a>
                            <a href="{{route('hospital.delete',$hospital ->id)}}" class="btn btn-danger"> supprimer hopital</a>
                        </td>
                    </tr>
                    @endforeach
                     @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@stop

