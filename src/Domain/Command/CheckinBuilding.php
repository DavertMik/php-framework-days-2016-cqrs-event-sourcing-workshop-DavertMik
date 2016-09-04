<?php
namespace Building\Domain\Command;

use Prooph\Common\Messaging\Command;
use Rhumsaa\Uuid\Uuid;

class CheckinBuilding extends Command
{
    private $buildingId;
    private $name;

    private function __construct(Uuid $buildingId, string $name)
    {
        $this->init();

        $this->buildingId = $buildingId;
        $this->name = $name;
    }
    
    public static function new($buildingId, $name)
    {
        return new self($buildingId, $name);
    }

    /**
     * Return message payload as array
     *
     * The payload should only contain scalar types and sub arrays.
     * The payload is normally passed to json_encode to persist the message or
     * push it into a message queue.
     *
     * @return array
     */
    public function payload()
    {
        return [
            'buildingId' => $this->buildingId,
            'name' => $this->name,
        ];
    }

    /**
     * This method is called when message is instantiated named constructor fromArray
     *
     * @param array $payload
     * @return void
     */
    protected function setPayload(array $payload)
    {
        $this->buildingId = Uuid::fromString($payload['buildingId']);
        $this->name = $payload['name'];
    }
    
    public function name() : string
    {
        return $this->name;
    }
    
    public function buildingId()
    {
        return $this->buildingId;
    }
}