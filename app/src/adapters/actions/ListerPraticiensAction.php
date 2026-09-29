<?php
declare(strict_types=1);

namespace toubilib\adapters\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\application\ports\api\ServicePraticienInterface;

class ListerPraticiensAction
{
    public function __construct(
        private ServicePraticienInterface $service
    ) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $dtos = $this->service->listerPraticiens();
        
        $data = [];
        foreach ($dtos as $dto) {
            $data[] = $dto->toArray();
        }

        $response->getBody()->write(json_encode(['praticiens' => $data], JSON_UNESCAPED_UNICODE));
        
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}