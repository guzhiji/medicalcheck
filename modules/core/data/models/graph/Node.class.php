<?php

class Node extends DataObject {

    function __construct(CatalogService $service, $id = NULL) {
        parent::__construct($service, 'node', $id);
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
        
    }

    public function addChild() {
        
    }

    public function listChildren() {
        
    }

    public function addRel($newChild) {
        
    }

    public function removeRel($child) {
        
    }

}