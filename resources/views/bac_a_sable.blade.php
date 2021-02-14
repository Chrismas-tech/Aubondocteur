@extends('layouts.app')
@section('content')

<ul>
@foreach ($medecins as $medecin)
    <li class="display-1">{{$medecin->medecin_first_name}}</li>
@endforeach
</ul>

<div class="d-flex justify-content-center display-4">
    {{$medecins->links()}}
</div>
@endsection