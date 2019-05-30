<a class="nav-link" href="<?= $baseUrl;?>/create"><button class="btn btn-success">Создать новую задачу</button></a>
<table id="taskTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
    <tr>
        <th>Id</th>
        <th>Имя пользователя</th>
        <th>E-mail</th>
        <th>Текст задачи</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
<script>
    $(document).ready(function () {
        $('#taskTable').DataTable({
            "data": <?= $tasks; ?>,
            "bLengthChange": false,
            "searching": false,
            "pageLength": 3,
            "columns": [
                {}, //id
                {}, //Имя пользователя
                {}, //Email
                {'orderable': false}, //Текст задачи
                {}, //Статус
                {'orderable': false}, //Действия
            ]
        });
    });
</script>