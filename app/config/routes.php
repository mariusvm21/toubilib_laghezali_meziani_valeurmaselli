<?php
declare(strict_types=1);

use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\actions\GetPraticienAction;

return function ($app) {

    $app->get('/praticiens/{id}', GetPraticienAction::class)->setName('praticien_detail');

    $app->post('/rdv/{id}/annulation', AnnulerRendezVousAction::class)->setName('rdv_annuler');

    return $app;
};