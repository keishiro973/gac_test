<?php
declare(strict_types = 1);

namespace App\Service;

use App\Repository\FactureRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class Statistics
{
    /** @var FactureRepository*/
    private $factureRepo;

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

        $callList = $this->factureRepo->getCallsAfterDate($startDate);


        foreach ($callList as $call) {
            $call->getDureeReel();
        }
        return 0;
    }

}