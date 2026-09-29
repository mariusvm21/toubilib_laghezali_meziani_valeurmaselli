<?php
declare(strict_types=1);

namespace toubilib\adapters;

use toubilib\application\ports\spi\PraticienRepositoryInterface;
use toubilib\domain\entities\Praticien;
class PraticienRepository implements PraticienRepositoryInterface
{
    public function __construct(private \PDO $pdo)
    {
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
                (int)$row['id'],
                $row['nom'],
                $row['prenom'],
                $row['ville'],
                $row['email'] ?? '',
                $row['telephone'] ?? '', 
                (int)$row['specialite_id'],
                (int)$row['structure_id']
            );
        }
        return $praticiens;
    }
}
