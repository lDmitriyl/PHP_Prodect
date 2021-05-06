<div class="col-md-12">
    <h1><?=$productOffer['product_name']?></h1>
    <h2><?=$this->productOfferName($productOffer)?></h2>
    <table class="table">
        <tbody>
        <tr>
            <th>
                Поле
            </th>
            <th>
                Значение
            </th>
        </tr>
        <tr>
            <td>ID</td>
            <td><?=$productOffer['id']?></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><?=$productOffer['price']?></td>
        </tr>
        <tr>
            <td>Колличество</td>
            <td><?=$productOffer['count']?></td>
        </tr>
        <tr>
            <td>Картинка</td>
            <td><img src="<?=PATH . UPLOAD_DIR . $productOffer['image']?>" height="240px"></td>
        </tr>
        </tbody>
    </table>
    <h2>Галерея</h2>
    <div class="gallery">

        <?php foreach (json_decode($productOffer['gallery_img']) as $image):?>
            <div class="gallery_item"><img src="<?=PATH . UPLOAD_DIR . $image?>" height="100%" width="100%"></div>
        <?php endforeach;?>
    </div>
</div>