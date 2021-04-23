<div class="row justify-content-center">
    <div class="col-3">
        <form method="post" action="/login">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email адрес</label>
                <input type="email" name="mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       value="<?= isset($_SESSION['res']['mail']) ? htmlspecialchars($_SESSION['res']['mail']) : ''?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
            </div>
            <input type="hidden" name="_token" value="<?=$this->_token?>">
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</div>
