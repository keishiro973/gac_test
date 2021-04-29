<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CsvImportType;
use App\Service\Statistics;
use App\Service\UploadFile;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Validator\Util\ServerParams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $em;

    public function setEm(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="import")
     */
    public function index(UploadFile $uploadFile, Request $request): Response
    {
        $form = $this->createForm(CsvImportType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $csvFile = $form->get('file')->getData();
            if ($csvFile) {
                $uploadFile->importCsv($csvFile);
            }
            // Open the file
        }

        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistics(Statistics $statistics): Response
    {
        $realPaid = $statistics->getReelCallPaid();
        $top10 = $statistics->getTop10();
        $allSms = $statistics->getAllSms();
        return $this->render('stats/index.html.twig', [
            'realPaid' => $realPaid,
            'top10' => $top10,
            'totalSms' => $allSms,
        ]);
    }
}
