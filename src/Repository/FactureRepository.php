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
    public function getCallsAfterDate(DateTime $startDate)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.connectionType = :connectionType')
            ->andWhere('f.eventDate >= :startDate')
            ->setParameters([
                'connectionType' => Facture::CALL,
                'startDate' => $startDate
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function getTop10DataUsage()
    {
        return $this->createQueryBuilder('f')
            ->join('f.abonne', 'a')
            ->andWhere('f.connectionType = :connectionType')
            ->andWhere('f.eventTime between :start and :stop')
            ->orderBy('a.reference,f.volumeFacture DESC')
            ->groupBy('a.reference')
            ->setParameters([
                'connectionType' => Facture::INTERNET,
                'start' => DateTime::createFromFormat('H:i:s', '08:00:00'),
                'stop' => DateTime::createFromFormat('H:i:s', '18:00:00'),
            ])
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
