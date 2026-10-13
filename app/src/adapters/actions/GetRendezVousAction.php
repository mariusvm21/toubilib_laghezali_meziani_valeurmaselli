<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\application\exceptions\RendezVousNotFoundException;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpNotFoundException;

class GetRendezVousAction
{
    private ServiceRendezVousInterface $service;

    public function __construct(ServiceRendezVousInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        try {
            $dto = $this->service->getDetailsRendezVous($id);    
        } catch (RendezVousNotFoundException $e) {
            throw new HttpNotFoundException($request, "Rendez-vous <$id> not found");
        }

        $route = $routeParser->urlFor('rdv_detail', ['id' => $dto->id]);

        $body = [
            'type' => 'ressource',
            'rendez_vous' => $dto->toArray(),
            'links' => [
                'self'      => ['href' => $route],
                'praticien' => ['href' => $routeParser->urlFor('praticien_detail', ['id' => $dto->praticienId])],
                'patient'   => ['href' => $routeParser->urlFor('patient_detail', ['id' => $dto->patientId])],
                'annuler'   => ['href' => $route . '/annuler'],
                'honorer'   => ['href' => $route . '/honorer'],
                'ignorer'   => ['href' => $route . '/ignorer'],
            ],
        ];

        $response->getBody()->write(json_encode($body));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}