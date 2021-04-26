<div class="col-md-12">
    <h1>Заказы</h1>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                Имя
            </th>
            <th>
                Телефон
            </th>
            <th>
                Когда отправлен
            </th>
            <th>
                Сумма
            </th>
            <th>
                Действия
            </th>
        </tr>

        <?php foreach($orders as $order):?>
        <tr>
            <td><?=$order['id']?></td>
            <td><?=$order['name']?></td>
            <td><?=$order['phone']?></td>
            <td><?=$order['created_at']?></td>
            <td> <?=$order['sum']?> <?=$order['currency_code']?></td>
            <td>
                <div class="btn-group" role="group">
                    <a href="/admin/order/order_id/<?=$order['id']?>" class="btn btn-success" type="button">Открыть</a>
                </div>
            </td>
        </tr>
        <?php endforeach;?>

        </tbody>
    </table>
</div>