<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\exceptions\PraticienNotFoundException;
use toubilib\application\ports\api\ServicePraticienInterface;

class GetPatientAction
{
    private ServicePatientInterface $service;

    public function __construct(ServicePatientInterface $service) {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $dto = $this->service->getPatientDetail($args['id']);
        } catch (PatientNotFoundException $e) {
            return $this->json($response, ['error' => $e->getMessage()], 404);
        }

        return $this->json($response, ['patient' => $dto->toArray()], 200);
    }

    private function json(Response $response, array $data, int $status): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
