<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\exceptions\RendezVousNotFoundException;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\domain\exceptions\StatutRendezVousException;

class AnnulerRendezVousAction
{
    private ServiceRendezVousInterface $service;
    
    public function __construct(ServiceRendezVousInterface $service) {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $dto = $this->service->annuler($args['id']);
        } catch (RendezVousNotFoundException $e) {
            return $this->json($response, ['error' => $e->getMessage()], 404);
        } catch (StatutRendezVousException $e) {
            return $this->json($response, ['error' => $e->getMessage()], 409);
        }

        return $this->json($response, ['rendez-vous' => $dto->toArray()], 200);
    }

    private function json(Response $response, array $data, int $status): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}