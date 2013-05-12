<?php

class CatalogService extends DataService {

    function __construct($driver) {
        parent::__construct($driver);
    }

    public function open($service_name) {
        parent::open($service_name);
        return $this;
    }

    public function createCatalog($parent = NULL) {
        ibc2_load_class('Catalog', 'data.models.catalog');
        $c = new Catalog($this);
        if (!empty($parent))
            $c->clgPid = $parent;
        return $c;
    }

    public function getCatalog($id) {
        ibc2_load_class('Catalog', 'data.models.catalog');
        return new Catalog($this, $id);
    }

    public function getContent($id) {
        ibc2_load_class('Content', 'data.models.catalog');
        return new Content($this, $id);
    }

    public function listCatalogs($parent = NULL) {
        
    }

    public function listContents($catalog) {
        
    }

    public function deleteCatalogs(array $ids) {
        
    }

    public function deleteContents(array $ids) {
        
    }

}