<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\ports\api\ServicePraticienInterface;

class GetAgendaPraticienAction
{
    private ServicePraticienInterface $service;

    public function __construct(ServicePraticienInterface $service) {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $queryParams = $request->getQueryParams();
        
        $dateDebut = $queryParams['date_debut'] ?? null; 
        $dateFin = $queryParams['date_fin'] ?? null;

        $agendaDtos = []; 

        $data = [
            'type' => 'collection',
            'agenda' => $agendaDtos, 
            'links' => [
                'self' => ['href' => '/praticiens/' . $id . '/agenda'],
                'praticien' => ['href' => '/praticiens/' . $id]
            ]
        ];

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    private function json(Response $response, array $data, int $status): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}