<div class="py-4">
    <div class="container">
        <div class="justify-content-center">
            <div class="panel">
                <h1>Заказ №<?=$order['id']?></h1>
                <p>Заказчик: <b><?=$order['name']?></b></p>
                <p>Номер телефона: <b><?=$order['phone']?></b></p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Стоимость</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($productOffers as $productOffer):?>
                    <tr>
                        <td>
                            <a href="/admin/product_offer/product_id/<?=$productOffer['product_id']?>/id/<?=$productOffer['id']?>">
                                <img height="56px" src="<?=UPLOAD_DIR . $productOffer['image']?>">
                                <?=$this->productOfferName($productOffer)?>
                            </a>
                        </td>
                        <td><span><?=$productOffer['countInOrder']?></span></td>
                        <td><?=$productOffer['price']?> <?=$order['currency_code']?></td>
                        <td><?=$productOffer['price'] * $productOffer['countInOrder']?> <?=$order['currency_code']?></td>
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="3">Общая стоимость:</td>
                        <td><?=$order['sum']?> <?=$order['currency_code']?></td>
                    </tr>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>