<div class="col-md-12">
    <h1>Товарные предложения</h1>
    <h2><?=$productOffers[0]['product_name']?></h2>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                Товарное предложение (свойства)
            </th>
            <th>
                Действия
            </th>
        </tr>
        <?php foreach($productOffers as $productOffer):?>
        <tr>
            <td><?=$productOffer['id']?></td>
            <td><?=$this->productOfferName($productOffer)?></td>
            <td>
                <div class="btn-group" role="group">
                    <form action="/admin/delete_product_offer/id/<?=$productOffer['id']?>" method="POST">
                        <a class="btn btn-success" type="button"
                           href="/admin/product_offer/product_id/<?=$this->parameters['product_id']?>/id/<?=$productOffer['id']?>">Открыть</a>
                        <a class="btn btn-warning" type="button"
                           href="/admin/update_product_offer/product_id/<?=$this->parameters['product_id']?>/id/<?=$productOffer['id']?>">Редактировать</a>
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <a class="btn btn-success" type="button" href="/admin/add_product_offer/product_id/<?=$this->parameters['product_id']?>">Добавить</a>
</div>