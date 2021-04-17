<div class="col-md-12">
    <?php if(!empty($this->parameters)):?>
    <h1>Редактировать товар <b></b></h1>
    <?php else:?>
    <h1>Добавить товар</h1>
    <?php endif;?>

    <form method="POST" enctype="multipart/form-data" action="<?= empty($this->parameters) ? '/admin/add_product' : '/admin/update_product';?>">
        <div>
            <?php if(!empty($this->parameters)):?>
                <input type="hidden" name="id" value="<?=$product['id']?>">
            <?php endif;?>
            <div class="input-group row">
                <label for="code" class="col-sm-2 col-form-label">Код: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="code" id="code"
                           value="<?= empty($this->parameters) ? (isset($_SESSION['res']['code']) ? isset($_SESSION['res']['code']) : '') : $product['code']?>">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="name" class="col-sm-2 col-form-label">Название: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="prodName" id="name"
                           value="<?= empty($this->parameters) ? (isset($_SESSION['res']['prodName']) ? isset($_SESSION['res']['prodName']) : '') : $product['name']?>">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="category_id" class="col-sm-2 col-form-label">Категория:</label>
                <div class="col-sm-6">
                    <select name="category_id" id="category_id" class="form-control">
                        <?php foreach ($categories as $category):?>
                        <option value="<?=$category['id']?>"
                            <?php if(!empty($this->parameters)):?>
                                <?php if($category['id'] === $product['category_id']):?>
                                    selected
                                <?php endif;?>
                             <?php endif;?>
                        ><?=$category['name']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                <div class="col-sm-6">
                    <textarea name="description" id="description" cols="72" rows="7"> <?= empty($this->parameters) ? (isset($_SESSION['res']['description']) ? isset($_SESSION['res']['description']) : '') : $product['description']?></textarea>
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                <div class="col-sm-10">
                    <label class="btn btn-default btn-file">
                        Загрузить <input type="file" style="display: none;" name="image" id="image">
                    </label>
                </div>
            </div>
            <br>
            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>