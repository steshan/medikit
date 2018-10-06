@extends('rapyd::demo.master')

@section('title','Аптечка')

@section('content')
    @if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif

    <script>
        function updateMedicineForm() {
            $("#form").html("<option>не задана</option>");
            $("#component").val('');
            $.getJSON("{{ url('/data/component') }}", {q: $("#auto_name").val()}, function (data) {
                $("#component").val(data);
            });
            $.getJSON("{{ url('/data/forms') }}", {q: $("#auto_name").val()}, function (data) {
                $.each(data, function (key, val) {
                    $("#form").append("<option>" + val + "</option>");
                });
            });
        }
    </script>

    <h1>Аптечка</h1>
    <p>

        {!! $edit !!}

    </p>
@stop