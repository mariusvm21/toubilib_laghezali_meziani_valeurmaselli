<?php
declare(strict_types=1);

namespace toubilib\adapters\persistence;

use PDO;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\domain\entities\RendezVous;
use toubilib\application\exceptions\RendezVousNotFoundException;

class PgRendezVousRepository implements RendezVousRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRendezVousById(string $id): RendezVous
    {
        $stmt = $this->pdo->prepare("SELECT * FROM rendez_vous WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new RendezVousNotFoundException("le rendez-vous avec l'id $id n'existe pas.");
        }

        return new RendezVous(
            $row['id'],
            $row['praticien_id'],
            $row['patient_id'],
            $row['motif_visite'],
            new \DateTimeImmutable($row['date_heure_debut']),
            new \DateTimeImmutable($row['date_heure_fin']),
            new \DateTimeImmutable($row['date_creation']),
            (int) $row['duree'],
            (int) $row['statut']
        );
    }

}