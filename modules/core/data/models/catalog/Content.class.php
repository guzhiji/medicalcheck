<?php

class Content extends DataObject {

    function __construct(CatalogService $service, $id = NULL) {
        parent::__construct($service, 'content', $id);
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

}