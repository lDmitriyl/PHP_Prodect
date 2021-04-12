<div class="row justify-content-center">
    <div class="col-3">
        <form method="post" action="/register">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email адрес</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       value="<?= isset($_SESSION['res']['email']) ? htmlspecialchars($_SESSION['res']['email']) : htmlspecialchars($this->data['email'])?>">
            </div>
            <div class="mb-3">
                <label for="autoSizingInputGroup" class="form-label">Имя</label>
                <input type="name" name="name" class="form-control" id="autoSizingInputGroup"
                       value="<?= isset($_SESSION['res']['name']) ? htmlspecialchars($_SESSION['res']['name']) : htmlspecialchars($this->data['name'])?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
            </div>
            <button type="submit" class="btn btn-primary">Регистрация</button>
        </form>
    </div>
</div>
