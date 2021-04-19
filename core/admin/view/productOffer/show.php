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
        </tbody>
    </table>
</div>