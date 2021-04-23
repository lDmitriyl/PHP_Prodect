<h1>Все товары</h1>
<form method="GET" action="">
    <div class="filters row">
        <div class="col-sm-6 col-md-3">
            <label for="price_from">Цена от
                <input type="text" name="price_from" id="price_from" size="6" value="">
            </label>
            <label for="price_to">до
                <input type="text" name="price_to" id="price_to" size="6"  value="">
            </label>
        </div>
        <div class="col-sm-2 col-md-2">
            <label for="hit">
                <input type="checkbox" name="hit" id="hit">Хит</label>
        </div>
        <div class="col-sm-2 col-md-2">
            <label for="new">
                <input type="checkbox" name="new" id="new">Новинка</label>
        </div>
        <div class="col-sm-2 col-md-2">
            <label for="recommend">
                <input type="checkbox" name="recommend" id="recommend">Рекомендуем</label>
        </div>
        <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-primary">Фильтр</button>
            <a href="" class="btn btn-warning">Сброс</a>
        </div>
    </div>
</form>
<div class="row">
    <?php foreach ($productOffers as $productOffer):?>
        <?php include 'layout/card.php'?>
    <?php endforeach;?>
    <br>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if($this->parameters['page'] != 1):?>
                <li class="page-item">
                    <a class="page-link" href="/index/page/<?=$this->parameters['page'] - 1?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif;?>
            <?php for($i = 1; $i <= $pageCount; $i++):
                if($this->parameters['page'] == $i) : ?>
                    <li class="page-item active"><a class="page-link" href="/index/page/<?=$i?>"><?=$i?></a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" href="/index/page/<?=$i?>"><?=$i?></a></li>
                <?php endif;endfor;?>
            <?php if($this->parameters['page'] != $pageCount):?>
                <li class="page-item">
                    <a class="page-link" href="/index/page/<?=$this->parameters['page'] + 1?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif;?>
        </ul>
    </nav>
</div>
