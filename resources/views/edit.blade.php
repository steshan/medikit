@extends('layouts.app')

@section('content')
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! $edit !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection