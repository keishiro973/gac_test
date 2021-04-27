<?php
declare(strict_types = 1);

namespace App\Service;

use App\Repository\FactureRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class Statistics
{
    /** @var EntityManager */
    private $em;

    /** @var FactureRepository*/
    private $factureRepo;

    /**
     * @param EntityManager $em
     * @required
     */
    public function setEm(EntityManager $em): void
    {
        $this->em = $em;
    }

    /**
     * @required
     * @param FactureRepository $factureRepo
     */
    public function setFactureRepo(FactureRepository $factureRepo): void
    {
        $this->factureRepo = $factureRepo;
    }
    public function getReelCallPaid(DateTime $startDate = null): int
    {
        if (null == $startDate) {
            $startDate = new DateTime('2012-02-15');
        }

        return 0;
    }

}