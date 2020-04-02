<?php
declare(strict_types=1);

namespace app\repositories\city;

use app\collections\CityCollection;

interface CityRepositoryInterface
{
    public function findAll(): ?array;
    public function upsertMany(CityCollection $cities): void;
}