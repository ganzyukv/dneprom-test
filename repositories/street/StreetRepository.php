<?php
declare(strict_types=1);

namespace app\repositories\street;

use app\collections\StreetCollection;
use app\models\StreetModel;
use app\repositories\BaseRepository;

final class StreetRepository extends BaseRepository implements StreetRepositoryInterface
{
    public function findAll(): ?array
    {
        return StreetModel::find()->all();
    }

    public function upsertMany(StreetCollection $streetCollection): void
    {
        $sql = $this->db->queryBuilder->batchInsert(StreetModel::tableName(),
            [
                'name'     => 'name',
                'ref'      => 'ref',
                'city_ref' => 'city_ref',
            ],
            $streetCollection);
        $this->db->createCommand($sql . ' ON DUPLICATE KEY UPDATE name = VALUES(name) , city_ref = VALUES(city_ref)')
            ->execute();
    }
}