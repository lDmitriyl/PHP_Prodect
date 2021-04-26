<h1>Корзина</h1>
<p>Оформление заказа</p>
<div class="panel">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Кол-во</th>
            <th>Доступно</th>
            <th>Цена</th>
            <th>Стоимость</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($order)):?>
        <?php foreach ($order as $product):?>
            <tr>
                <td>
                    <a href="../index.php">
                        <img height="56px" src="<?=UPLOAD_DIR. $product['image']?>">
                        <?=$product['product_name']?>
                    </a>
                </td>
                <td><?=$product['countInOrder']?>
                    <div class="btn-group form-inline">
                        <form action="/remove_basket/productOffer_id/<?=$product['id']?>" method="POST">
                            <input type="hidden" name="_token" value="<?=$this->_token?>">
                            <button type="submit" class="btn btn-danger">
                                <span aria-hidden="true" style="padding: 5px">-</span></button>
                        </form>
                        <form action="/add_basket/productOffer_id/<?=$product['id']?>" method="POST">
                            <input type="hidden" name="_token" value="<?=$this->_token?>">
                            <button type="submit" class="btn btn-success">
                                <span aria-hidden="true" style="padding: 5px">+</span>
                        </form>

                </td>
                <td><?=$product['count']?> кол-во.</td>
                <td><?=$this->convertCurrency($product['price'])?> <?=$_SESSION['currencyCode']?></td>
                <td><?=$this->convertCurrency($product['price']) * $product['countInOrder']?> <?=$_SESSION['currencyCode']?></td>
            </tr>
        <?php endforeach;?>

        <tr>
            <td colspan="3">Общая стоимость:</td>
            <td><?=$orderFullSum?> <?=$_SESSION['currencyCode']?></td>
        </tr>
        </tbody>
    </table>
    <?php endif;?>
    <br>
    <div class="btn-group pull-right" role="group">
        <a type="button" class="btn btn-success" href="/basket_place">Оформить заказ</a>
    </div>
</div>