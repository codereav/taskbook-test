<div class="container">
    <div class="card">
        <div class="card-body">
            <form id="taskForm" action="/login" method="post">
                <div class="form-group">
                    <label for="username">Логин</label>
                    <input type="text" class="form-control" id="username" name="username"
                           placeholder="Введите имя пользователя">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
                </div>
                <button type="submit" class="btn btn-danger">Авторизоваться</button>
            </form>
        </div>
    </div>
</div>