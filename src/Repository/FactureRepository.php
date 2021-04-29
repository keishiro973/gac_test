<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Facture;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    /**
     * @param DateTime $startDate
     * @return Facture[]
     */
    public function getCallsAfterDate(DateTime $startDate): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT TIME( SUM(f.duree_reel) ) AS somme_des_heures
            FROM facture f
            WHERE f.event_date >= :startDate AND f.connection_type = :connectionType
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'connectionType' => Facture::CALL,
            'startDate' => $startDate->format('Y-m-d'),
        ]);

        return $stmt->fetchAssociative();
    }

    public function getTop10DataUsage(string $refAbonne)
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->join('f.abonne', 'a')
            ->andWhere('f.connectionType = :connectionType')
            ->andWhere('f.eventTime between :start and :stop')
            ->andWhere('a.reference = :refAbonne')
            ->orderBy('f.volumeFacture','desc')
            ->setParameters([
                'connectionType' => Facture::INTERNET,
                'start' => DateTime::createFromFormat('H:i:s', '08:00:00'),
                'stop' => DateTime::createFromFormat('H:i:s', '18:00:00'),
                'refAbonne' => $refAbonne,
            ])
            ->setMaxResults(10)
        ;
        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;
    }

    public function countSms()
    {
        return $this->createQueryBuilder('f')
            ->select('count(f.reference)')
            ->andWhere('f.connectionType = :connectionType')
            ->setParameters([
                'connectionType' => Facture::SMS,
            ])
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
