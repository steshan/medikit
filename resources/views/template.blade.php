<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Medikit</title>
    <meta charset="utf-8">

    @section('script')

    @show

    <style>
        body {
            font-family: Arial, SansSerif;
        }

        table {
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid;
            padding: 5px;
        }

        th {
            background-color: #d3d3d3 !important;
        }
    </style>

</head>
<body>
    <p><a href="{{ url('/') }}">На главную</a></p>
    <p><a href="{{ url('/expired') }}">Просроченные лекарства</a></p>
    <p><a href="{{ url('/add') }}">Добавить лекарство</a></p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @section('main')

    @show
</body>
</html>