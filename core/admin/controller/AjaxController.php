<?php


namespace core\admin\controller;


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


            }

        }

        return json_encode(['success' => '0', 'message' => 'No ajax variable']);

    }

}