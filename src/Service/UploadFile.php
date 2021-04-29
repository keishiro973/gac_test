<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Abonne;
use App\Entity\Compte;
use App\Entity\Facture;
use App\Repository\AbonneRepository;
use App\Repository\CompteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{

    /** @var EntityManagerInterface */
    private $em;
    /** @var CompteRepository */
    private $compteRepository;
    /** @var AbonneRepository */
    private $abonneRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CompteRepository $compteRepository,
        AbonneRepository $abonneRepository
    ) {
        $this->em = $entityManager;
        $this->compteRepository = $compteRepository;
        $this->abonneRepository = $abonneRepository;
    }

    public function importCsv(UploadedFile $file)
    {
        if (($handle = fopen($file->getPathname(), "r")) !== false) {
            $row = 0;
            $csvDatas = [];
            while (($data = fgetcsv($handle, 120, ';')) !== false) {
                $row++;
                if (in_array($row, [1, 2, 3])) {
                    continue;
                }
                $csvDatas[] = $data;
            }
        }
        $chunkCsv = array_chunk($csvDatas, 100);

        foreach ($chunkCsv as $imports) {
            foreach ($imports as $arr) {
                $compte = $this->createOrUpdateCompte($arr[0]);

                $facture = $this->createdFacture($arr);

                $abonne = $this->createOrUpdateAbonne($arr[2], $facture);
                $compte->addFactureId($facture);

                $this->em->persist($compte);
                $this->em->persist($facture);
                $this->em->persist($abonne);
            }
            $this->em->flush();
        }
    }

    /**
     * @param string $number
     * @return Compte
     */
    public function createOrUpdateCompte(string $number): Compte
    {
        $compte = $this->compteRepository->findOneBy(['number' => $number]);

        if (null === $compte) {
            $compte = new Compte();
            $compte->setNumber($number);
        }
        return $compte;
    }

    /**
     * @param $arr
     * @return Facture
     */
    public function createdFacture($arr): Facture
    {
        $facture = new Facture();
        $facture->setReference($arr[1]);
        $facture->setEventDate(DateTime::createFromFormat('d/m/Y', $arr[3]));
        $facture->setEventTime(DateTime::createFromFormat('H:i:s', $arr[4]));
        $facture->setTypeFacture($arr[7]);
        $reel = explode(':', $arr[5]);
        if (count($reel) > 1) {
            $facture->setConnectionType(Facture::CALL);
            $facture->setDureeReel(DateTime::createFromFormat('H:i:s', $arr[5]));
            $facture->setDureeFacture(DateTime::createFromFormat('H:i:s', $arr[6]));
        }
        if (count($reel) == 1) {
            $facture->setConnectionType(Facture::INTERNET);
            $facture->setVolumeReel(floatval($arr[5]));
            $facture->setVolumeFacture(floatval($arr[6]));
        }
        if (empty($arr[5])) {
            $facture->setConnectionType(Facture::SMS);
        }
        return $facture;
    }

    /**
     * @param $reference
     * @param Facture $facture
     * @return Abonne
     */
    public function createOrUpdateAbonne($reference, Facture $facture): Abonne
    {
        $abonne = $this->abonneRepository->findOneBy(['reference'=>$reference]);

        if (null === $abonne) {
            $abonne = new Abonne();
            $abonne->setReference($reference);
        }
        $abonne->addFacture($facture);

        return $abonne;
    }
}