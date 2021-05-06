<?php


namespace core\admin\controller;


use core\user\model\productOffer;
use libraries\FileEdit;

class AjaxController extends BaseAdmin
{

    public function ajax(){

        if(isset($this->ajaxData['ajax'])){

            foreach ($this->ajaxData as $key => $item)$this->ajaxData[$key] = $this->clearStr($item);

            switch ($this->ajaxData['ajax']){

                case 'wyswyg_file':

                    $fileEdit = new FileEdit();

                    $fileEdit->setUniqueFile(false);

                    $file = $fileEdit->addFile('ajax');

                    return ['location' => PATH . UPLOAD_DIR . $file[key($file)]];

                    break;

                case 'editData':

                    $this->clearPostFields();

                    $this->table = 'product_offers';

                    $this->createFiles('productOffer/gallery_img', $_POST['id']);

                    !$_POST['id'] ? ProductOffer::instance()->createProductOffer($_POST, $this->fileArray, $this->messages) :
                        ProductOffer::instance()->updateProductOffer($_POST, $this->fileArray, $this->messages);

                    return json_encode(['success' => 1]);


            }

        }

        return json_encode(['success' => '0', 'message' => 'No ajax variable']);

    }

}