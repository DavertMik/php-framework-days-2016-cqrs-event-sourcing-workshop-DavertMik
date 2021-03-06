<?php

declare(strict_types=1);

namespace Building\Infrastructure\CommandHandler;

use Building\Domain\Aggregate\Building;
use Building\Domain\Command\CheckinBuilding;
use Building\Domain\Command\CheckoutBuilding;
use Building\Domain\Command\RegisterNewBuilding;
use Building\Domain\Repository\BuildingRepositoryInterface;
use Building\Infrastructure\Repository\BuildingRepository;

final class CheckoutBuildingHandler
{
    /**
     * @var BuildingRepository
     */
    private $repository;

    public function __construct(BuildingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CheckoutBuilding $command)
    {
        $building = $this->repository->get($command->buildingId());
        $building->checkOutUser($command->name());
    }
}
