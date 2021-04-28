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
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(
        EntityManagerInterface $entityManager,
        CompteRepository $compteRepository,
        AbonneRepository $abonneRepository
    ) {
        $this->em = $entityManager;
    }

    public function importCsv(UploadedFile $file)
    {
        if (($handle = fopen($file->getPathname(), "r")) !== false) {
            $row = 0;
            while (($data = fgetcsv($handle, 120, ';')) !== false) {
                $row++;
                if (in_array($row, [1, 2, 3])) {
                    continue;
                }
                $compte = $this->createOrUpdateCompte($data[0]);

                $facture = new Facture();
                $facture->setReference($data[1]);
                $facture->setEventDate(DateTime::createFromFormat('d/m/Y', $data[3]));
                $facture->setEventTime(DateTime::createFromFormat('H:i:s', $data[4]));
                $facture->setTypeFacture($data[7]);
                $reel = explode(':', $data[5]);
                if (count($reel) > 1) {
                    $facture->setConnectionType(Facture::CALL);
                    $facture->setDureeReel(DateTime::createFromFormat('H:i:s', $data[5]));
                    $facture->setDureeFacture(DateTime::createFromFormat('H:i:s', $data[6]));
                }
                if (count($reel) == 1) {
                    $facture->setConnectionType(Facture::INTERNET);
                    $facture->setVolumeReel(floatval($data[5]));
                    $facture->setVolumeFacture(floatval($data[6]));
                }
                if (empty($data[5])) {
                    $facture->setConnectionType(Facture::SMS);
                }

                $abonne = new Abonne();
                $abonne->setReference($data[2]);
                $abonne->addFacture($facture);
                $compte->addFactureId($facture);

                $this->em->persist($compte);
            }
            fclose($handle);
            $this->em->flush();
        }

    }

    /**
     * @param $number
     * @return Compte
     */
    public function createOrUpdateCompte($number): Compte
    {

        $compte = new Compte();
        $compte->setNumber($number);
        return $compte;
    }
}