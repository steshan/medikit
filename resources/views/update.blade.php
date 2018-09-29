@extends('template')

@section('main')
    <p>Наименование: {{ $data['name'] }}</p>
    <p>Действующее вещество: {{ $data['component'] }}</p>
    <p>Форма выпуска: {{ $data['form'] }}</p>
    <p>Годен до: {{ $data['expiration'] }}</p>
    <form action="{{ url('/update') }}/{{$data['id']}}" method="POST">
        {{ csrf_field() }}
        <label for="comment">Комментарий</label>
        <input name="comment" id="comment" type="text" value = "{{ $data['comment'] }}">
        <br>
        <br>
        <input type="submit" name="submit" value="Сохранить">
</form>
@endsection
