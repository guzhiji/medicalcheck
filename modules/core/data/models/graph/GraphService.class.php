<?php

class GraphService extends DataService {

    function __construct($driver) {
        parent::__construct($driver);
    }

    public function open($service_name) {
        parent::open($service_name);
        return $this;
    }

    public function createNode($parent = NULL) {
        ibc2_load_class('Node', 'data.models.graph');
        $c = new Catalog($this);
        if (!empty($parent))
            $c->clgPid = $parent;
        return $c;
    }

    public function getNode($id) {
        ibc2_load_class('Node', 'data.models.graph');
        return new Node($this, $id);
    }

    public function listNodes($parent = NULL) {
        
    }

    public function deleteNodes(array $ids) {
        
    }

}