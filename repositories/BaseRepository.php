<?php
declare(strict_types=1);

namespace app\repositories;

use Yii;

class BaseRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = Yii::$app->db;
    }

}