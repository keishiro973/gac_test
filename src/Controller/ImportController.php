<?php

namespace App\Controller;

use App\Entity\Abonne;
use App\Entity\Compte;
use App\Form\CsvImportType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/import", name="import")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(CsvImportType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            dd($file);
            // Open the file
            if (($handle = fopen($file->getPathname(), "r")) !== false) {
                // Read and process the lines.
                // Skip the first line if the file includes a header
                while (($data = fgetcsv($handle)) !== false) {
                    dd($data);
                    // Do the processing: Map line to entity, validate if needed
                    $entity = new Compte();
                    // Assign fields
                    $entity->setNumber($data[0]);
                    $this->em->persist($entity);
                }
                fclose($handle);
                $this->em->flush();
            }
        }

        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
            'form' => $form->createView(),
        ]);
    }
}
