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
        $id = $args['id'];

        try {
            $dto = $this->service->annuler($args['id']);
        } catch (RendezVousNotFoundException $e) {
            $errorData = [
                'message' => '404 Not Found',
                'exception' => [
                    ['type' => 'RendezVousNotFoundException', 'code' => 404, 'message' => $e->getMessage()]
                ]
            ];
            return $this->json($response, $errorData, 404);
        } catch (StatutRendezVousException $e) {
            $errorData = [
                'message' => '409 Conflict',
                'exception' => [
                    ['type' => 'StatutRendezVousException', 'code' => 409, 'message' => $e->getMessage()]
                ]
            ];
            return $this->json($response, $errorData, 409);
        }
        $rdvData = $dto->toArray();
        
        $idPraticien = $rdvData['praticien_id'] ?? $rdvData['praticienId'] ?? '';
        $idPatient = $rdvData['patient_id'] ?? $rdvData['patientId'] ?? '';

        $data = [
            'type' => 'ressource',
            'rendez_vous' => $rdvData,
            'links' => [
                'self' => ['href' => '/rdvs/' . $id . '/'],
                'praticien' => ['href' => '/praticiens/' . $idPraticien . '/'],
                'patient' => ['href' => '/patients/' . $idPatient . '/']
            ]
        ];

        return $this->json($response, $data, 200);
    }

    private function json(Response $response, array $data, int $status): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}