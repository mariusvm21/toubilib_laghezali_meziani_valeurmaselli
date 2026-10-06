<?php
declare(strict_types=1);

use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\actions\ListerPraticiensAction;
use toubilib\adapters\actions\GetPraticienAction;
use toubilib\adapters\actions\GetRendezVousAction;

return function ($app) {

    $app->get('/praticiens/{id}', GetPraticienAction::class)->setName('praticien_detail');
    $app->post('/rdv/{id}/annulation', AnnulerRendezVousAction::class)->setName('rdv_annuler');
    $app->get('/rendez-vous/{id}', GetRendezVousAction::class)->setName('rdv_detail');
    $app->get('/praticien', ListerPraticiensAction::class)->setName('praticien_liste');

    /*
    $app->get('/praticiens/{id}/rendez-vous', ListerCrenauxAction::class)->setName('praticien_crenaux');
    $app->get('/praticiens/{id}/rendez-vous/{date}', ListerCrenauxAction::class)->setName('praticien_crenaux_date');
    $app->get('/rendez-vous/{id}', GetRendezVousAction::class)->setName('rdv_detail');
    $app->post('/rendez-vous', CreerRendezVousAction::class)->setName('rdv_creer');
    $app->patch('/rendez-vous/{id}/annuler', AnnulerRendezVousAction::class)->setName('rdv_annuler');
    $app->patch('/rendez-vous/{id}/honorer', HonorerRendezVousAction::class)->setName('rdv_honorer');
    $app->patch('/rendez-vous/{id}/ignorer', IgnorerRendezVousAction::class)->setName('rdv_ignorer');
    */


    
    return $app;
};