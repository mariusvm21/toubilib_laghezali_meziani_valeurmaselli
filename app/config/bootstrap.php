<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\RendezVousRepository;
use toubilib\application\usecases\ServiceRendezVous;

$conf = parse_ini_file(__DIR__ . '/.env');
$dsn  = "{$conf['lib.driver']}:host={$conf['lib.host']};dbname={$conf['lib.database']}";
$pdo  = new PDO($dsn, $conf['lib.username'], $conf['lib.password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);

$repository = new RendezVousRepository($pdo);
$service    = new ServiceRendezVous($repository);
$action     = new AnnulerRendezVousAction($service);

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/routes.php';

return $routes($app, $action);