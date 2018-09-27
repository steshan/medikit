@extends('template')

@section('script')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
        $(function () {
            $("#medicine_name").autocomplete({
                source: '/namelist',
                change: function (event, ui) {
                    updateMedicineForm();
                },
                close: function (event, ui) {
                    updateMedicineForm();
                }
            });
        });

        function updateMedicineForm() {
            $("#medicine_form").html("<option>не задана</option>");
            $("#medicine_component").val('');
            $.getJSON("/formlist", {term: $("#medicine_name").val()}, function (data) {
                $.each(data, function (key, val) {
                    if (key == 0) {
                        $("#medicine_component").val(val);
                    } else {
                        $("#medicine_form").append("<option>" + val + "</option>");
                    }
                });
            });
        }
    </script>
@endsection


@section('main')
    <form  action="/add" method="POST">
        {{ csrf_field() }}
        <label for="medicine_name">Наименование</label>
        <input name="medicine_name" id="medicine_name" type="text">
        <br>
        <br>
        <label for="medicine_component">Действующее вещество</label>
        <input name="medicine_component" id="medicine_component" type="text">
        <br>
        <br>
        <label for="medicine_form">Форма выпуска</label>
        <select size="1" name="medicine_form" id="medicine_form"> </select>
        <br>
        <br>
        <label for="medicine_date">Годен до</label>
        <input name="medicine_date" id="medicine_date" type="date">
        <br>
        <br>
        <label for="medicine_comment">Комментарий</label>
        <input name="medicine_comment" id="medicine_comment" type="text">
        <br>
        <br>
        <input type="submit" name="submit" value="Сохранить">
    </form>
@endsection
