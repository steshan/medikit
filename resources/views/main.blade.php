@extends('rapyd::demo.master')

@section('title','Аптечка')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif


    <h1>Аптечка</h1>
    <p>

        {!! $filter !!}

        {!! $grid !!}


    </p>
@stop