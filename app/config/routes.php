<?php
declare(strict_types=1);

use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\actions\ListerPraticiensAction;
use toubilib\adapters\actions\GetPraticienAction;
use toubilib\adapters\actions\GetRendezVousAction;
use toubilib\adapters\actions\CreerRendezVousAction;

return function ($app) {

    $app->get('/praticiens/{id}', GetPraticienAction::class)->setName('praticien_detail');
    $app->get('/praticien', ListerPraticiensAction::class);
    $app->get('/patients/{id}', GetPatientAction::class)->setName('patient_detail');

    
    //$app->get('/praticiens/{id}/rendez-vous', ListerCrenauxAction::class)->setName('praticien_crenaux');
    //$app->get('/praticiens/{id}/rendez-vous/{date}', ListerCrenauxDateAction::class)->setName('praticien_crenaux_date');
    $app->post('/rdvs', CreerRendezVousAction::class)->setName('rdv_creer');
    $app->patch('/rdvs/{id}/annuler', AnnulerRendezVousAction::class)->setName('rdv_annuler');
    //$app->patch('/rdvs/{id}/honorer', HonorerRendezVousAction::class)->setName('rdv_honorer');
    //$app->patch('/rdvs/{id}/ignorer', IgnorerRendezVousAction::class)->setName('rdv_ignorer');

    $app->get('/rdvs/{id}', GetRendezVousAction::class)->setName('rdv_detail');

    $app->get('/praticiens/{id}/agenda', \toubilib\adapters\actions\GetAgendaPraticienAction::class);
    $app->get('/praticiens/{id}/rdvs', \toubilib\adapters\actions\GetRdvsPraticienAction::class);

    return $app;
};