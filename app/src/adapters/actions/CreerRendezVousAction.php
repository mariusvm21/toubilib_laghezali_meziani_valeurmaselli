<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\application\dto\CreeRDVDTO;
use toubilib\application\exceptions\ValidationException;
use toubilib\application\exceptions\PraticienNotFoundException;

class CreerRendezVousAction
{
    private ServiceRendezVousInterface $service;

    public function __construct(ServiceRendezVousInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody() ?? [];

        try {
            $dto = CreeRDVDTO::fromArray($data);
            $resultDto = $this->service->creerRDV($dto);

            $response->getBody()->write(json_encode($resultDto->toArray()));
            
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);

        } catch (ValidationException $e) {
            $response->getBody()->write(json_encode(['errors' => $e->getErrors()]));
            
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);

        } catch (PraticienNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }
}