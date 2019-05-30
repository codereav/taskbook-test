<div class="container">
    <div class="card">
        <div class="card-body">
            <form id="taskForm" action="/save" method="post">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" class="form-control" id="username" name="username"
                           placeholder="Введите имя пользователя" value="<?= isset($task) ? $task['username'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Введите e-mail" value="<?= isset($task) ? $task['email'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="content">Текст задачи</label>
                    <textarea class="form-control" id="content" name="content" required
                              placeholder="Введите текст задачи"><?= isset($task) ? $task['content'] : '' ?></textarea>
                </div>
                <?php if (isset($task)) { ?>
                    <div class="form-group">
                        <label for="status">Статус</label>
                        <select class="form-control" id="status" name="status">
                            <option value="0" <?= !$task['status']?'selected':''?>>В работе</option>
                            <option value="1" <?= $task['status']?'selected':''?>>Выполнена</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?= $task['id']; ?>">
                <?php } ?>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
</div>