<?php

?>
<div class="col-sm-6 col-md-4">
    <div class="card">
        <img height="56px" src="<?=UPLOAD_DIR. $productOffer['image']?>" class="card-img-top" alt="">
        <div class="card-body">
            <h3><?=$productOffer['product_name']?></h3>
            <p></p>
            <p><?=$this->convertCurrency($productOffer['price'])?> <?=$_SESSION['currencyCode']?></p>
            <form action="/add_basket/productOffer_id/<?=$productOffer['id']?>" method="POST">
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                <a href="/" class="btn btn-default" role="button">Подробнее</a>
            </form>
        </div>
    </div>
</div>