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

                    <?php foreach ($products as $product):?>
                    <tr>
                        <td>
                            <a href="{{ route('product-offer', [$pro->product->category->code, $pro->product->code, $pro]) }}">
                                <img height="56px" src="{{ Storage::url($pro->product->image) }}">
                                <?=$product['name']?>
                            </a>
                        </td>
                        <td><span><?=$product['countInOrder']?></span></td>
                        <td><?=$product['price']?> <?=$order['currency_code']?></td>
                        <td><?=$product['price'] * $product['countInOrder']?> <?=$order['currency_code']?></td>
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