<?php
declare(strict_types=1);

namespace toubilib\adapters;

use toubilib\application\ports\spi\PatientRepositoryInterface;

class PatientRepository implements PatientRepositoryInterface
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function existe(string $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM patient WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() !== false;
    }
}
