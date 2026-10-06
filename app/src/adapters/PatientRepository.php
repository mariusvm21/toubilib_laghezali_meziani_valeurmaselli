<?php
declare(strict_types=1);

namespace toubilib\adapters;

use toubilib\application\ports\spi\PatientRepositoryInterface;
use toubilib\domain\entities\Patient; 

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

    public function getById(string $id): Patient
    {
        $stmt = $this->pdo->prepare('SELECT * FROM patient WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$ligne) {
            throw new \Exception("Patient introuvable");
        }

        return new Patient(
            $ligne['id'],
            $ligne['nom'] ?? '',
            $ligne['prenom'] ?? ''
        );
    }
}