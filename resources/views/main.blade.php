@extends('template')


@section('main')
    <br>
    <br>

    <form action="/search">

    <input name="search" id="search" type="text">
    <input type="submit" value="Поиск">

    </form>
    <br>
    <br>
    <br>
    <table border=" 4px black;">
        <tr>
            <th>Наименование</th>
            <th>Активное вещество</th>
            <th>Форма выпуска</th>
            <th>Годен до</th>
            <th>Комментарий</th>
        </tr>
        @foreach ($data as $entry)
            <tr>
                <td>{{ $entry['name'] }}</td>
                <td>{{ $entry['component'] }}</td>
                <td>{{ $entry['form'] }}</td>
                <td>{{ $entry['expiration'] }}</td>
                <td>{{ $entry['comment'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection

