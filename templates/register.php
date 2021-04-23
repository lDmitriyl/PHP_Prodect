<div class="row justify-content-center">
    <div class="col-3">
        <form method="post" action="/register">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email адрес</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       value="<?= isset($_SESSION['res']['email']) ? htmlspecialchars($_SESSION['res']['email']) : ''?>">
            </div>
            <div class="mb-3">
                <label for="autoSizingInputGroup" class="form-label">Имя</label>
                <input type="name" name="name" class="form-control" id="autoSizingInputGroup"
                       value="<?= isset($_SESSION['res']['name']) ? htmlspecialchars($_SESSION['res']['name']) : ''?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Повторите пароль</label>
                <input type="password" name="password2" class="form-control" id="exampleInputPassword1">
            </div>
            <input type="hidden" name="_token" value="<?=$this->_token?>">
            <button type="submit" class="btn btn-primary">Регистрация</button>
        </form>
    </div>
</div>
