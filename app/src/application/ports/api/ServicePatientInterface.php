<?php
declare(strict_types=1);

namespace toubilib\application\ports\api;


use toubilib\application\dto\PatientDetailDTO;

interface ServicePatientInterface
{
    public function listerPatients(): array;

    public function getPatientDetail(string $id): PatientDetailDTO;
}
