<div class="col-md-12">
    <h1>Товары</h1>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                Код
            </th>
            <th>
                Название
            </th>
            <th>
                Категория
            </th>
            <th>
                Действия
            </th>
        </tr>
        <?php foreach ($products as $product):?>
        <tr>
            <td><?=$product['id']?></td>
            <td><?=$product['code']?></td>
            <td><?=$product['name']?></td>
            <td><?=$product['category_name']?></td>
            <td>
                <div class="btn-group" role="group">
                    <form action="/admin/delete_product/id/<?=$product['id']?>" method="POST">
                        <a class="btn btn-success" type="button" href="/admin/product/id/<?=$product['id']?>">Открыть</a>
                        <a class="btn btn-success" type="button" href="/admin/product_offers/product_id/<?=$product['id']?>">ProdOffer</a>
                        <a class="btn btn-warning" type="button" href="/admin/update_product/id/<?=$product['id']?>">Редактировать</a>
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <a class="btn btn-success" type="button" href="/admin/add_product">Добавить товар</a>
</div>