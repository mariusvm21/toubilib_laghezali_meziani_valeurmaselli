<?php
declare(strict_types=1);

namespace toubilib\application\usecases;

use toubilib\application\dto\PraticienDetailDTO;
use toubilib\application\ports\api\ServicePraticienInterface;
use toubilib\application\ports\spi\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $repository;

    public function __construct(PraticienRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getPraticienDetail(string $id): PraticienDetailDTO
    {
        $praticien = $this->repository->getPraticienById($id);

        return new PraticienDetailDTO(
            $praticien->getId(),
            $praticien->getTitre(),
            $praticien->getNom(),
            $praticien->getPrenom(),
            $praticien->getSpecialite()?->getLibelle() ?? '',
            $praticien->getEmail(),
            $praticien->getTelephone(),
            $praticien->getVille(),
        );
    }
}
