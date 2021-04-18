<div class="col-md-12">
    <h1>Варианты свойства</h1>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                Свойство
            </th>
            <th>
                Название
            </th>
        </tr>
        <?php foreach ($propertyOptions as $propertyOption):?>
        <tr>
            <td><?=$propertyOption['id']?></td>
            <td><?=$propertyOption['property_name']?></td>
            <td><?=$propertyOption['name']?></td>
            <td>
                <div class="btn-group" role="group">
                    <form action="/admin/delete_property_option/id/<?=$propertyOption['id']?>" method="POST">
                        <a class="btn btn-success" type="button"
                           href="/admin/property_option/property/<?=$this->parameters['property']?>/id/<?=$propertyOption['id']?>">Открыть</a>
                        <a class="btn btn-warning" type="button"
                           href="/admin/update_property_option/property/<?=$this->parameters['property']?>/id/<?=$propertyOption['id']?>">Редактировать</a>
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <a class="btn btn-success" type="button" href="/admin/add_property_option/property/<?=$this->parameters['property']?>">Добавить варианты свойства</a>
</div>