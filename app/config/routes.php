<?php
declare(strict_types=1);

use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\actions\ListerPraticiensAction;
use toubilib\adapters\actions\GetPraticienAction;
use toubilib\adapters\actions\GetRendezVousAction;

return function ($app) {

    $app->get('/praticiens/{id}', GetPraticienAction::class)->setName('praticien_detail');
    $app->post('/rdv/{id}/annulation', AnnulerRendezVousAction::class)->setName('rdv_annuler');
    $app->get('/rendez-vous/{id}', GetRendezVousAction::class);
    $app->get('/praticien', ListerPraticiensAction::class);
    
    return $app;
};