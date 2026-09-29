<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\application\exceptions\RendezVousNotFoundException;

class GetRendezVousAction
{
    private ServiceRendezVousInterface $service;

    // injection du service metier via constructeur
    public function __construct(ServiceRendezVousInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id']; // identifiant recup depuis l'url

        try {
            $dto = $this->service->getDetailsRendezVous($id);
            
            $response->getBody()->write(json_encode($dto->toArray()));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200); // 200 (OK)
                
        } catch (RendezVousNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'rendez-vous introuvable']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404); // 404 (Not Found)
        }
    }
}