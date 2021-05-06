<div class="col-md-12">
    <?php if(isset($this->parameters['category_id'])):?>
        <h1>Редактировать Категорию <b><?=$category['name']?></b></h1>
    <?php else:?>
        <h1>Добавить Категорию</h1>
    <?php endif;?>

    <form method="POST" enctype="multipart/form-data" action="<?= !isset($this->parameters['category_id']) ? '/admin/add_category' : '/admin/update_category';?>">
        <?php if(!empty($this->parameters['category_id'])):?>
            <input type="hidden" name="id" value="<?=$category['id']?>">
        <?php endif;?>
        <div>
            <div class="input-group row">
                <label for="code" class="col-sm-2 col-form-label">Код: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="code" id="code"
                           value="<?= empty($this->parameters) ? (isset($_SESSION['res']['code']) ? $_SESSION['res']['code'] : '') : $category['code']?>">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="name" class="col-sm-2 col-form-label">Название: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name"
                           value="<?= empty($this->parameters) ? (isset($_SESSION['res']['name']) ? $_SESSION['res']['name'] : '') : $category['name']?>">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                <div class="col-sm-6">
                    <textarea name="description" id="description" cols="72" rows="7"><?= empty($this->parameters) ? (isset($_SESSION['res']['description']) ? $_SESSION['res']['description'] : '') : $category['description']?></textarea>
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                <div class="col-sm-10">
                    <div class="card-img">
                        <?php if(isset($this->parameters['category_id'])):?>
                            <img class="img_item" src="<?= PATH . UPLOAD_DIR . $category['image']?>">
                        <?php endif;?>
                    </div>
                    <label class="btn btn-default btn-file">
                        Загрузить <input type="file" style="display: none;" name="image" id="image">
                    </label>
                </div>
            </div>
            <input type="hidden" name="_token" value="<?=$this->_token?>">
            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>
