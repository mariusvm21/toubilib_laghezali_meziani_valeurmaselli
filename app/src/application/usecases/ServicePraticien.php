<?php
declare(strict_types=1);

namespace toubilib\application\usecases;


use toubilib\application\dto\PraticienDTO;
use toubilib\application\dto\PraticienDetailDTO;
use toubilib\application\ports\api\ServicePraticienInterface;
use toubilib\application\ports\spi\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface
{

    public function __construct(
        private PraticienRepositoryInterface $repository
    ) {}

    public function listerPraticiens(): array
    {
        $praticiens = $this->repository->getPraticien();
        $dtos = [];

        foreach ($praticiens as $praticien) {
            $dtos[] = new PraticienDTO(
                $praticien->getId(),
                $praticien->getNom(),
                $praticien->getPrenom(),
                (string)$praticien->getSpecialiteId(), 
                $praticien->getVille()
            );
        }

        return $dtos;
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




