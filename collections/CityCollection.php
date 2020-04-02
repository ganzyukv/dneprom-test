<?php
declare(strict_types=1);

namespace app\collections;

use app\models\CityModel;
use ArrayIterator;
use IteratorAggregate;

final class CityCollection implements IteratorAggregate
{

    private $cities;

    public function __construct(CityModel ...$city)
    {
        $this->cities = $city;
    }

    /**
     * @param CityModel $city
     */
    public function addCity(CityModel $city): void
    {
        $this->cities[] = $city;
    }

    /**
     * @return CityModel|null
     */
    public function getCities(): ?array
    {
        return $this->cities ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->cities);
    }
}