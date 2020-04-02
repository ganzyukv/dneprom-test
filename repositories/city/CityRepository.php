<?php
declare(strict_types=1);

namespace app\repositories\city;

use app\collections\CityCollection;
use app\models\CityModel;
use app\repositories\BaseRepository;

final class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function findAll(): ?array
    {
        return CityModel::find()->all();
    }

    public function upsertMany(CityCollection $cityCollection): void
    {
        $sql = $this->db->queryBuilder->batchInsert(CityModel::tableName(),
            [
                'name' => 'name',
                'ref' => 'ref',
            ], $cityCollection);
        $this->db->createCommand($sql . ' ON DUPLICATE KEY UPDATE name = VALUES(name)')
            ->execute();
    }

}