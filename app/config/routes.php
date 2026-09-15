<?php
declare(strict_types=1);

return function ($app, $action) {

    $app->post('/rdv/{id}/annulation', $action)
        ->setName('rdv_annuler');

    return $app;
};