@extends('template')

@section('main')
    <br>
    <br>
    <form action="{{ url('/search') }}">
        <input name="search" id="search" type="text">
        <input type="submit" value="Поиск">
    </form>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <th>Наименование</th>
            <th>Активное вещество</th>
            <th>Форма выпуска</th>
            <th>Годен до</th>
            <th>Комментарий</th>
        </tr>
        @foreach ($data as $entry)
            <tr>
                <td>
                    <span style="float:left; padding-right:5pt;">{{ $entry['name'] }}</span>
                    <snap style="float:right;">
                        <a href="{{ url('/update') }}/{{ $entry['id'] }}">редактировать</a>
                        &nbsp;/&nbsp;
                        <a href="{{ url('/delete') }}/{{ $entry['id'] }}" onclick="return confirm('Вы подтверждаете удаление?');">удалить</a>
                    </snap>
                </td>
                <td>{{ $entry['component'] }}</td>
                <td>{{ $entry['form'] }}</td>
                <td>{{ $entry['expiration'] }}</td>
                <td>{{ $entry['comment'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection
