<?php
declare(strict_types=1);

namespace toubilib\application\ports\api;

use toubilib\application\dto\PraticienDTO;

interface ServicePraticienInterface
{
    public function listerPraticiens(): array;
}