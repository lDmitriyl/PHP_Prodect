<div class="col-md-12">
    <h1>Свойства</h1>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                Название
            </th>
        </tr>
        <?php foreach ($properties as $property):?>
        <tr>
            <td><?=$property['id']?></td>
            <td><?=$property['name']?></td>
            <td>
                <div class="btn-group" role="group">
                    <form action="/admin/delete_property/id/<?=$property['id']?>" method="POST">
                        <a class="btn btn-success" type="button" href="/admin/property/id/<?=$property['id']?>">Открыть</a>
                        <a class="btn btn-success" type="button" href="/admin/property_options/property/<?=$property['id']?>/">Варианты свойства</a>
                        <a class="btn btn-warning" type="button" href="/admin/update_property/id/<?=$property['id']?>">Редактировать</a>
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <a class="btn btn-success" type="button" href="/admin/add_property">Добавить свойство</a>
</div>