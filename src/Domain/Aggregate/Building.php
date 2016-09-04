<?php

namespace Building\Domain\Aggregate;

use Building\Domain\DomainEvent\CheckedIntoBuilding;
use Building\Domain\DomainEvent\CheckedOutOfBuilding;
use Building\Domain\DomainEvent\NewBuildingWasRegistered;
use Prooph\EventSourcing\AggregateRoot;
use Rhumsaa\Uuid\Uuid;

final class Building extends AggregateRoot
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $checkedIn = [];

    public static function new($name) : self
    {
        $self = new self();

        $self->recordThat(NewBuildingWasRegistered::occur(
            (string) Uuid::uuid4(),
            [
                'name' => $name
            ]
        ));

        return $self;
    }

    public function checkInUser(string $username)
    {
        if (isset($this->checkedIn[$username])) {
            throw new \LogicException('No.');
        }
        $this->recordThat(CheckedIntoBuilding::occurUsingBuilding($this, $username));
    }

    public function checkOutUser(string $username)
    {
        if (!isset($this->checkedIn[$username])) {
            throw new \LogicException('No.');
        }
        $this->recordThat(CheckedOutofBuilding::occurUsingBuilding($this, $username));
    }

    public function whenNewBuildingWasRegistered(NewBuildingWasRegistered $event)
    {
        $this->uuid = $event->uuid();
        $this->name = $event->name();
    }

    public function whenCheckedIntoBuilding(CheckedIntoBuilding $event)
    {
        $this->checkedIn[$event->name()]= true;
    }


    public function whenCheckedOutOfBuilding(CheckedOutOfBuilding $event)
    {
        unset($this->checkedIn[$event->name()]);
    }

    /**
     * {@inheritDoc}
     */
    protected function aggregateId() : string
    {
        return (string) $this->uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function id() : string
    {
        return $this->aggregateId();
    }
}
