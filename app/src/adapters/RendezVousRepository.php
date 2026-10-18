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
            'SELECT id, praticien_id, patient_id, motif_visite, date_heure_debut, date_heure_fin, date_creation, duree, status
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
            new \DateTimeImmutable($row['date_heure_fin']),
            new \DateTimeImmutable($row['date_creation']),
            (int) $row['duree'],
            (int) $row['status'],
        );
    }

    public function save(RendezVous $rdv): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO rdv (id, praticien_id, patient_id, date_heure_debut, motif_visite, duree, status)
            VALUES (:id, :praticien_id, :patient_id, :date_heure, :motif, :duree, :status)
        ");
        
        $stmt->execute([
            'id' => $rdv->getId(),
            'praticien_id' => $rdv->getPraticienId(),
            'patient_id' => $rdv->getPatientId(),
            'date_heure' => $rdv->getdatedebut()->format('Y-m-d H:i:s'),
            'motif' => $rdv->getMotifVisite(),
            'duree' => $rdv->getDuree(),
            'status' => $rdv->getStatut()
        ]);
    }

    public function getRdvsByPraticienId(string $praticienId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM rdv 
            WHERE praticien_id = :praticien_id 
            AND status = 'PREVU'
        ");
        $stmt->execute(['praticien_id' => $praticienId]);
        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $rdvs = [];
        foreach ($lignes as $ligne) {
            $rdv = new \toubilib\domain\entities\RendezVous(
                $ligne['praticien_id'],
                $ligne['patient_id'],
                $ligne['motif_visite'],
                new \DateTimeImmutable($ligne['date_heure_debut'])
            );
            $rdv->setId($ligne['id']);
            
            $rdvs[] = $rdv;
        }

        return $rdvs;
    }
}