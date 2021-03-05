<?php
namespace controllers\crud\datas;

use Ubiquity\controllers\crud\CRUDDatas;

 /**
  * Class CrudOrgaDatas
  */

class CrudOrgaDatas extends CRUDDatas{
    public function getFieldNames($model) {
        return ['name', 'domain'];
    }
}