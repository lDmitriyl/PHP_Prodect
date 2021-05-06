<div class="col-md-12">
    <?php if(!empty($this->parameters['id'])):?>
    <h1>Редактировать товарное предложение <b><?=$this->productOfferName($productOffer)?></b></h1>
    <?php else:?>
    <h1>Добавить товарное предложение</h1>
    <?php endif;?>

    <form id="main-form" method="POST" enctype="multipart/form-data"
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
            <div class="vg-element vg-full vg-box-shadow img_wrapper">
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        <div class="img_container">
                            <div class="card-img">
                                <?php if(!empty($this->parameters)):?>
                                    <img class="img_item" src="<?= PATH . UPLOAD_DIR . $productOffer['image']?>">
                                <?php endif;?>
                            </div>
                            <label class="btn btn-default btn-file">
                                Загрузить <input type="file" style="display: none;" name="image" id="image">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="vg-element vg-full vg-box-shadow img_wrapper">
                <div class="vg-wrap vg-element vg-full">
                    <div class="vg-wrap vg-element vg-full">
                        <div class="vg-element vg-full vg-left">
                            <span class="vg-header"></span>
                        </div>
                        <div class="vg-element vg-full vg-left">
                            <span class="vg-text vg-firm-color5"></span><span class="vg_subheader"></span>
                        </div>
                    </div>
                    <div class="vg-wrap vg-element vg-full gallery_container">
                        <label class="vg-dotted-square vg-center">
                            <img src="<?=PATH . ADMIN_TEMPLATE?>img/plus.png" alt="plus">
                            <input class="gallery_img" style="display: none;" type="file" name="gallery_img[]" multiple>
                        </label>
                        <?php foreach (json_decode($productOffer['gallery_img']) as $image):?>
                            <a href="/admin/delete_images_product_offer/id/<?=$productOffer['id']?>/gallery_img/<?=base64_encode($image)?>" class="vg-dotted-square vg-center">
                                <img class="vg_delete" src="<?=PATH . UPLOAD_DIR . $image?>" height="100%" width="100%">
                            </a>
                        <?php endforeach;?>
                        <?php
                        for($i = 0; $i < 2; $i++){
                            echo ' <div class="vg-dotted-square vg-center empty_container"></div>';
                        }
                        ?>

                    </div>
                </div>
            </div>
            <?php if(!empty($this->parameters['id'])):?>
                <input type="hidden" name="id" value="<?=$productOffer['id']?>">
            <?php endif;?>


            <input type="hidden" name="_token" value="<?=$this->_token?>">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
</div>