<?php
declare(strict_types=1);

namespace app\repositories\street;

use app\collections\StreetCollection;

interface StreetRepositoryInterface
{
    public function findAll(): ?array;
    public function upsertMany(StreetCollection $streetCollection): void;
}