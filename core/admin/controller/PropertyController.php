<?php


namespace core\admin\controller;


use core\user\model\Property;

class PropertyController extends BaseAdmin
{
    public function index(){

        $this->template = 'core/admin/view/property/index';

        $properties = Property::instance()->getProperty();

        return ['properties' => $properties];
    }

    public function show(){

        $this->template = 'core/admin/view/property/show';

        $property = Property::instance()->getProperty($this->parameters['id']);

        return ['property' => $property[0]];
    }

    public function create(){

        $this->template = 'core/admin/view/property/form';

        if($this->isPost()){

            $this->clearPostFields();

            Property::instance()->createProperty($_POST, $this->messages) ? $this->redirect(PATH . 'admin/properties') : $this->redirect();
        }
    }

    public function update(){

        $this->template = 'core/admin/view/property/form';

        $property = Property::instance()->getProperty($this->parameters['id'])[0];

        if($this->isPost()) {

            $this->clearPostFields();

            Property::instance()->updateProperty($_POST, $this->messages) ? $this->redirect(PATH . 'admin/properties') : $this->redirect();

        }

        return ['property' => $property];
    }

    public function delete(){

        Property::instance()->deleteProperty($this->parameters['id'], $this->messages);

        $this->redirect();

    }
}