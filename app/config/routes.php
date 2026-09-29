<?php
declare(strict_types=1);

use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\actions\ListerPraticiensAction;

return function ($app) {

    $app->post('/rdv/{id}/annulation', AnnulerRendezVousAction::class)->setName('rdv_annuler');
    $app->get('/praticien', ListerPraticiensAction::class);

    return $app;
};