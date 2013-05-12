<?php

class Catalog extends DataObject {

    function __construct(CatalogService $service, $id = NULL) {
        parent::__construct($service, 'catalog', $id);
    }

    public function get($name, &$value) {
        parent::get($name, $value);
        return $this;
    }

    public function set($name, $value) {
        parent::set($name, $value);
        return $this;
    }

    public function getParent() {
        return new Catalog($this->service_, $this->clgPid);
    }

    public function createContent() {
        ibc2_load_class('Content', 'data.models.catalog');
        $c = new Content($this->service_);
        $c->cntPid = $this->id_;
        return $c;
    }

    public function listContents() {
        
    }

}