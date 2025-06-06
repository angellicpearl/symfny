<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Form\EmpruntType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class EmpruntController extends AbstractController
{
    #[Route('/emprunt', name: 'app_emprunt_list')]
    public function list(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $query = $em->getRepository(Emprunt::class)
                    ->createQueryBuilder('e')
                    ->orderBy('e.dateEmprunt', 'DESC')
                    ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('emprunt/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/emprunt/livre/{id}', name: 'app_emprunt_create')]
    public function createEmprunt(Livre $livre, Request $request, EntityManagerInterface $em): Response
    {
        $emprunt = new Emprunt();
        $emprunt->setLivre($livre);
        $emprunt->setUtilisateur($this->getUser());

        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($emprunt);
            $em->flush();

            $this->addFlash('success', 'L\'emprunt a été enregistré avec succès.');

            return $this->redirectToRoute('app_emprunt_list');
        }

        return $this->render('emprunt/create.html.twig', [
            'form' => $form->createView(),
            'livre' => $livre,
        ]);
    }
    #[Route('/emprunt/new', name: 'app_emprunt_new')]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $emprunt = new Emprunt();
    $form = $this->createForm(EmpruntType::class, $emprunt);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($emprunt);
        $em->flush();

        $this->addFlash('success', 'Emprunt créé avec succès.');
        return $this->redirectToRoute('app_emprunt_list');
    }

    return $this->render('emprunt/create.html.twig', [
        'form' => $form->createView(),
        'livre' => null,
    ]);
}
public function emprunterLivre(Request $request, LivreRepository $livreRepository, EmpruntRepository $empruntRepository)
{
    $livreId = $request->get('livre_id');
    $livre = $livreRepository->find($livreId);

    if ($livre) {
        // Vérifier s'il existe un emprunt actif (pas de date de retour)
        $empruntActuel = $empruntRepository->findOneBy(['livre' => $livre, 'dateRetour' => null]);

        // Si le livre est déjà emprunté, vérifier si la date actuelle est après la date de retour
        if ($empruntActuel) {
            $dateRetour = $empruntActuel->getDateRetour();
            if ($dateRetour && $dateRetour < new \DateTime()) {
                // Le livre est déjà emprunté, mais la période est terminée
                // Vous pouvez permettre l'emprunt ici
                $empruntActuel->setDateRetour(new \DateTime()); // Marquer le retour du livre

                // Créer un nouvel emprunt
                $emprunt = new Emprunt();
                $emprunt->setLivre($livre);
                $emprunt->setUtilisateur($this->getUser());
                $emprunt->setDateEmprunt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($emprunt);
                $entityManager->flush();

                // Mettre à jour la disponibilité du livre
                $livre->setDisponible(false);
                $entityManager->flush();

                $this->addFlash('success', 'Livre emprunté avec succès!');
                return $this->redirectToRoute('app_livre_show', ['id' => $livreId]);
            } else {
                // Le livre est encore dans la période d'emprunt
                $this->addFlash('danger', 'Ce livre est actuellement emprunté et ne peut pas être emprunté avant sa date de retour.');
                return $this->redirectToRoute('app_livre_show', ['id' => $livreId]);
            }
        } else {
            // Aucun emprunt actif, emprunter le livre
            $emprunt = new Emprunt();
            $emprunt->setLivre($livre);
            $emprunt->setUtilisateur($this->getUser());
            $emprunt->setDateEmprunt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunt);
            $entityManager->flush();

            // Mettre à jour la disponibilité du livre
            $livre->setDisponible(false);
            $entityManager->flush();

            $this->addFlash('success', 'Livre emprunté avec succès!');
            return $this->redirectToRoute('app_livre_show', ['id' => $livreId]);
        }
    } else {
        $this->addFlash('danger', 'Le livre demandé n\'existe pas.');
        return $this->redirectToRoute('app_livre_index');
    }
}


}
