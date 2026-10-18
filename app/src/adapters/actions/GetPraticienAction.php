<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\exceptions\PraticienNotFoundException;
use toubilib\application\ports\api\ServicePraticienInterface;

class GetPraticienAction
{
    private ServicePraticienInterface $service;

    public function __construct(ServicePraticienInterface $service) {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        try {
            $dto = $this->service->getPraticienDetail($args['id']);
        } catch (PraticienNotFoundException $e) {
            $errorData = [
                'message' => '404 Not Found',
                'exception' => [
                    [
                        'type' => 'PraticienNotFoundException',
                        'code' => 404,
                        'message' => $e->getMessage()
                    ]
                ]
            ];
            return $this->json($response, $errorData, 404);
        }

        $data = [
            'type' => 'ressource',
            'praticien' => $dto->toArray(),
            'links' => [
                'self' => [
                    'href' => '/praticiens/' . $id . '/'
                ],
                'agenda' => [
                    'href' => '/praticiens/' . $id . '/agenda'
                ],
                'rdvs' => [
                    'href' => '/praticiens/' . $id . '/rdvs'
                ]
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
