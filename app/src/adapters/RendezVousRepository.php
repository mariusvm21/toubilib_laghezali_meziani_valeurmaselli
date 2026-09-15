<?php
declare(strict_types=1);

namespace toubilib\adapters;

use toubilib\application\exceptions\RendezVousNotFoundException;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\domain\entities\RendezVous;

class RendezVousRepository implements RendezVousRepositoryInterface
{
    public function __construct(private \PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRendezVousById(string $id): RendezVous
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, praticien_id, patient_id, motif_visite, date_heure_debut, duree, status
             FROM rdv WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            throw new RendezVousNotFoundException("rendez-vous $id inexistant");
        }

        return new RendezVous(
            $row['id'],
            $row['praticien_id'],
            $row['patient_id'],
            (string) $row['motif_visite'],
            new \DateTimeImmutable($row['date_heure_debut']),
            (int) $row['duree'],
            (int) $row['status'],
        );
    }

    public function save(RendezVous $rdv): void
    {
        $stmt = $this->pdo->prepare('UPDATE rdv SET status = :status WHERE id = :id');
        $stmt->execute([
            'status' => $rdv->getStatut(),
            'id'     => $rdv->getId(),
        ]);
    }
}