<?php

declare(strict_types=1);

namespace Building\Domain\DomainEvent;

use Building\Domain\Aggregate\Building;
use Prooph\EventSourcing\AggregateChanged;

final class CheckedOutOfBuilding extends AggregateChanged
{
    public static function occurUsingBuilding(Building $building, string $name)
    {
        return self::occur($building->id(), [
            'name' => $name,
        ]);
    }
    
    public function name() : string
    {
        return $this->payload['name'];
    }

    public function buildingId() : string
    {
        return $this->payload['buildingId'];
    }
}
