<?php
namespace controllers\crud\viewers;

use Ubiquity\controllers\crud\viewers\ModelViewer;

 /**
  * Class CrudUserViewer
  */

class CrudUserViewer extends ModelViewer {
    public function getModelDataTable($instances, $model, $totalCount, $page = 1) {
        $dt = parent::getModelDataTable($instances, $model, $totalCount, $page);
        $dt->fieldAsLabel('domain', 'users');
        $dt->setValueFunction('groups', function($v, $instance){
            return \count($v);
        });
        return $dt;
    }

    protected function getDataTableRowButtons() {
        return ['display', 'edit', 'delete'];
    }
}