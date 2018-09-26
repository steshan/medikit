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
    <p><a href="/">На главную</a></p>
    <p><a href="/expired">Просроченные лекарства</a></p>
    <p><a href="/add">Добавить лекарство</a></p>

    @section('main')

    @show
</body>
</html>