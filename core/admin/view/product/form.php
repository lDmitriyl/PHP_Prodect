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
                           value="<?= empty($this->parameters) ? (isset($_SESSION['res']['code']) ? $_SESSION['res']['code'] : '') : $product['code']?>">
                </div>
            </div>
            <br>
            <div class="input-group row">
                <label for="name" class="col-sm-2 col-form-label">Название: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="prodName" id="name"
                           value="<?= empty($this->parameters) ? (isset($_SESSION['res']['prodName']) ? $_SESSION['res']['prodName'] : '') : $product['name']?>">
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
                <label for="property_id" class="col-sm-2 col-form-label">Свойства товара: </label>
                <div class="col-sm-6">
                    <select name="property_id[]" id="property_id" class="form-control" multiple>
                        <?php foreach($properties as $property):?>
                        <option value="<?=$property['id']?>"
                            <?php if(!empty($this->parameters)):?>
                                <?foreach ($productProperties as $prodProperty):?>
                                    <?php if($prodProperty['property_id'] === $property['id']):?>
                                        selected
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>
                        ><?=$property['name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="input-group row">
                <div class="col-sm-2">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>

                        <label>
                            <input type="checkbox" class="tinyMceInit" name="" id="" >
                            Визуальный режим
                        </label>

                </div>
                <div class="col-sm-10">
                    <textarea name="description" id="description" cols="140" rows="10"> <?= empty($this->parameters) ? (isset($_SESSION['res']['description']) ? $_SESSION['res']['description'] : '') : $product['description']?></textarea>
                </div>
            </div>
            <br>
            <input type="hidden" name="_token" value="<?=$this->_token?>">
            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>