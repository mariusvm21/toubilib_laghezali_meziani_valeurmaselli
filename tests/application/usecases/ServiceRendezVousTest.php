<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use toubilib\application\usecases\ServiceRendezVous;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\domain\entities\RendezVous;
use toubilib\application\exceptions\RendezVousNotFoundException;

class ServiceRendezVousTest extends TestCase
{
    public function testGetDetailsRendezVousSuccess()
    {
        // 1. Création d'une fausse entité pour le test
        $fakeRdv = new RendezVous(
            'rdv-123',
            'prat-1',
            'pat-1',
            'CI',
            new \DateTimeImmutable('2026-10-10 10:00:00'),
            new \DateTimeImmutable('2026-10-10 10:30:00'),
            new \DateTimeImmutable('now'),
            30
        );

        // 2. Création d'un mock (bouchon) de l'interface du repository
        $repositoryMock = $this->createMock(RendezVousRepositoryInterface::class);
        
        // On indique au mock de retourner notre fausse entité quand getRendezVousById est appelé
        $repositoryMock->expects($this->once())
                       ->method('getRendezVousById')
                       ->with('rdv-123')
                       ->willReturn($fakeRdv);

        // 3. Instanciation du service avec le faux repository
        $service = new ServiceRendezVous($repositoryMock);

        // 4. Exécution de la méthode à tester
        $dto = $service->getDetailsRendezVous('rdv-123');

        // 5. Vérification des résultats
        $this->assertEquals('rdv-123', $dto->id);
        $this->assertEquals('CI', $dto->motifVisite);
        $this->assertEquals(0, $dto->statut); // self::PLANIFIE
    }

    public function testGetDetailsRendezVousThrowsException()
    {
        $repositoryMock = $this->createMock(RendezVousRepositoryInterface::class);
        
        // On simule le fait que le repository ne trouve pas le rendez-vous
        $repositoryMock->expects($this->once())
                       ->method('getRendezVousById')
                       ->willThrowException(new RendezVousNotFoundException());

        $service = new ServiceRendezVous($repositoryMock);

        // On s'attend à ce que l'exception remonte jusqu'ici
        $this->expectException(RendezVousNotFoundException::class);
        
        $service->getDetailsRendezVous('bad-id');
    }
}