<div class="col-md-12">
    <?php if(!empty($this->parameters['id'])):?>
    <h1>Редактировать свойство <b></b></h1>
    <?php else:?>
    <h1>Добавить свойство</h1>
    <?php endif;?>

    <form method="POST" enctype="multipart/form-data" action="<?= empty($this->parameters['id']) ? '/admin/add_property_option' : '/admin/update_property_option';?>">
        <input type="hidden" name="property_id" value="<?=$this->parameters['property']?>">
        <div>
            <?php if(!empty($this->parameters['id'])):?>
                <input type="hidden" name="id" value="<?=$propertyOption['id']?>">
            <?php endif;?>
            <div class="input-group row">
                <label for="name" class="col-sm-2 col-form-label">Название: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name"
                           value="<?= empty($this->parameters['id']) ? (isset($_SESSION['res']['name']) ? isset($_SESSION['res']['name']) : '') : $propertyOption['name']?>">
                </div>
            </div>
            <br>
            <input type="hidden" name="_token" value="<?=$this->_token?>">
            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>