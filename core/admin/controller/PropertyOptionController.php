<?php


namespace core\admin\controller;


use core\user\model\Property;
use core\user\model\PropertyOption;

class PropertyOptionController extends BaseAdmin
{
    public function index(){

        $this->template = 'core/admin/view/property-options/index';

        $propertyOptions = PropertyOption::instance()->getPropertyOption($this->parameters['property']);

        return ['propertyOptions' => $propertyOptions];
    }

    public function show(){

        $this->template = 'core/admin/view/property-options/show';

        $propertyOption = PropertyOption::instance()->getPropertyOption($this->parameters['id'])[0];

        return ['propertyOption' => $propertyOption];
    }

    public function create(){

        $this->template = 'core/admin/view/property-options/form';

        if($this->isPost()){

            $this->clearPostFields();

            PropertyOption::instance()->createPropertyOption($_POST, $this->messages) ?
                $this->redirect(PATH . 'admin/property_options/property/' . $_POST['property_id']) : $this->redirect();
        }
    }

    public function update(){
        $this->template = 'core/admin/view/property-options/form';

        $propertyOption = PropertyOption::instance()->getPropertyOption($this->parameters['id'])[0];

        if($this->isPost()) {

            $this->clearPostFields();

            PropertyOption::instance()->updatePropertyOption($_POST, $this->messages) ?
                $this->redirect(PATH . 'admin/property_options/property/' . $_POST['property_id']) : $this->redirect();

        }

        return ['propertyOption' => $propertyOption];
    }

    public function delete(){

        PropertyOption::instance()->deletePropertyOption($this->parameters['id'], $this->messages);

        $this->redirect();

    }
}