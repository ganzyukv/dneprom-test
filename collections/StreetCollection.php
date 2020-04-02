<?php
declare(strict_types=1);

namespace app\collections;

use app\models\StreetModel;
use ArrayIterator;
use IteratorAggregate;

final class StreetCollection implements IteratorAggregate
{

    private $streets;

    public function __construct(StreetModel ...$street)
    {
        $this->streets = $street;
    }

    /**
     * @param StreetModel $street
     */
    public function addStreet(StreetModel $street): void
    {
        $this->streets[] = $street;
    }

    /**
     * @return StreetModel|null
     */
    public function getStreets(): ?array
    {
        return $this->streets ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->streets);
    }
}