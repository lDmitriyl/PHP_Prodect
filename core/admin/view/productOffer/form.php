<div class="col-md-12">
    <?php if(!empty($this->parameters['id'])):?>
    <h1>Редактировать товарное предложение <b><?=$this->productOfferName($productOffer)?></b></h1>
    <?php else:?>
    <h1>Добавить товарное предложение</h1>
    <?php endif;?>

    <form method="POST" enctype="multipart/form-data"
          action="<?= empty($this->parameters['id']) ? '/admin/add_product_offer' : '/admin/update_product_offer';?>">
        <div>
            <input type="hidden" name="product_id" value="<?=$this->parameters['product_id']?>">
            <?php if(!empty($this->parameters['id'])):?>
                <input type="hidden" name="product_offer_id" value="<?=$productOffer['id']?>">
            <?php endif;?>
            <div class="input-group row">
                <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="price"
                           value="<?= empty($this->parameters['id']) ? (isset($_SESSION['res']['price']) ? isset($_SESSION['res']['price']) : '') : $productOffer['price']?>">
                </div>
            </div>
            <div class="input-group row">
                <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="count"
                           value="<?= empty($this->parameters['id']) ? (isset($_SESSION['res']['count']) ? isset($_SESSION['res']['count']) : '') : $productOffer['count']?>">
                </div>
            </div>
            <br>
            <?php $i = 0;?>
            <?php foreach ($propWithOptions as $property => $options):?>
            <div class="input-group row">
                <label for="property_id[<?=$options[0]['property_id']?>]" class="col-sm-2 col-form-label"><?=$property?>: </label>
                <div class="col-sm-6">
                    <select name="property_id[<?=$options[0]['property_id']?>]" class="form-control">
                        <?php foreach ($options as $option):?>
                        <option value="<?=$option['id']?>"
                                <?php if(isset($productOffer)):?>
                                    <?php if($productOfferOptions[$i]['id'] === $option['id']):?>
                                        selected
                                    <?php endif;?>
                                <?php endif;?>
                            ><?=$option['name']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <?php $i++;?>
            <?php endforeach;?>
            <br>
            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>