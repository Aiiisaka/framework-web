<?php
namespace controllers\crud\datas;

use Ubiquity\controllers\crud\CRUDDatas;

 /**
  * Class CrudUserDatas
  */

class CrudUserDatas extends CRUDDatas{
    public function getFieldNames($model) {
        return ['name', 'domain'];
    }
}