<?php
declare(strict_types = 1);

namespace App\Service;

use App\Repository\AbonneRepository;
use App\Repository\FactureRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class Statistics
{
    /** @var FactureRepository*/
    private $factureRepo;
    /** @var AbonneRepository */
    private $abonneRepo;

    /**
     * Statistics constructor.
     * @param FactureRepository $factureRepo
     * @param AbonneRepository $abonneRepo
     */
    public function __construct(FactureRepository $factureRepo, AbonneRepository $abonneRepo)
    {
        $this->factureRepo = $factureRepo;
        $this->abonneRepo = $abonneRepo;
    }

    public function getReelCallPaid(DateTime $startDate = null): string
    {
        if (null == $startDate) {
            $startDate = new DateTime('2012-02-15');
        }

        $fullRealCall = $this->factureRepo->getCallsAfterDate($startDate);
        return $fullRealCall['somme_des_heures'];
    }

    public function getTop10(): array
    {
        $refAbonnes = $this->abonneRepo->getListAbonne();
        $top10 = [];
        foreach ($refAbonnes as $refAbonne) {
            $top10DataUsage = $this->factureRepo->getTop10DataUsage($refAbonne['reference']);
            if (!empty($top10DataUsage)) {
                $top10[$refAbonne['reference']][] = $top10DataUsage;
            }
        }
        return $top10;
    }

    public function getAllSms()
    {
        return $this->factureRepo->countSms();
    }

}