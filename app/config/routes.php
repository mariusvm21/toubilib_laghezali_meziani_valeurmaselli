<?php
declare(strict_types=1);

use toubilib\adapters\actions\AnnulerRendezVousAction;

return function ($app) {

    $app->post('/rdv/{id}/annulation', AnnulerRendezVousAction::class)->setName('rdv_annuler');

    return $app;
};