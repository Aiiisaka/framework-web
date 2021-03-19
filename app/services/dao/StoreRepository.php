<?php

namespace services\dao;

use models\User;
use Ubiquity\controllers\Controller;
use Ubiquity\orm\repositories\ViewRepository;


class StoreRepository extends ViewRepository {
    public function __construct(Controller $ctrl) {
        parent::__construct($ctrl,User::class);
    }
}