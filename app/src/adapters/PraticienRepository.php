<?php
declare(strict_types=1);

namespace toubilib\adapters;

use toubilib\application\exceptions\PraticienNotFoundException;
use toubilib\application\ports\spi\PraticienRepositoryInterface;
use toubilib\domain\entities\Praticien;
use toubilib\domain\entities\RendezVous;
use toubilib\domain\entities\Specialite;

class PraticienRepository implements PraticienRepositoryInterface
{
    public function __construct(private \PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function existe(string $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM praticien WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() !== false;
    }


    public function getPraticien(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM praticien');
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $praticiens = [];
        foreach ($rows as $row) {
            $praticiens[] = new Praticien(
                (string)$row['id'],
                $row['nom'],
                $row['prenom'],
                $row['ville'],
                $row['email'] ?? '',
                $row['telephone'] ?? '', 
                (int)$row['specialite_id'],
                (string)$row['structure_id']
            );
        }
        return $praticiens;
    }
    public function getPraticienById(string $id): Praticien
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.id, p.nom, p.prenom, p.ville, p.email, p.telephone, p.specialite_id, p.structure_id, p.titre, s.libelle, s.description
             FROM praticien p JOIN specialite s ON s.id = p.specialite_id
             WHERE p.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            throw new PraticienNotFoundException("praticien $id inexistant");
        }

        return new Praticien(
            $row['id'],
            $row['nom'],
            $row['prenom'],
            $row['ville'],
            $row['email'],
            $row['telephone'],
            (int) $row['specialite_id'],
            $row['structure_id'],
            $row['titre'],
            new Specialite((int) $row['specialite_id'], $row['libelle'], $row['description']),
        );
    }

    public function getPraticienAvecRdvs(string $id): Praticien
    {
        $praticien = $this->getPraticienById($id);

        $stmt = $this->pdo->prepare(
            'SELECT id, praticien_id, patient_id, motif_visite, date_heure_debut, date_heure_fin, date_creation, duree, status
             FROM rdv WHERE praticien_id = :id
             ORDER BY date_heure_debut'
        );
        $stmt->execute(['id' => $id]);

        $agenda = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $agenda[] = new RendezVous(
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
        $praticien->setAgenda($agenda);

        return $praticien;
    }
}
