<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormInterface;

#[Route('/photo')]
final class PhotoController extends AbstractController
{
    #[Route(name: 'app_photo_index', methods: ['GET'])]
    public function index(PhotoRepository $photoRepository): Response
    {
        $photos = $photoRepository->findBy([
            'id_benevole' => $this->getUser(),
        ]);

        return $this->render('photo/index.html.twig', [
            'photos' => $photos,
        ]);
    }

    #[Route('/new', name: 'app_photo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photo = new Photo();
        $photo->setIdBenevole($this->getUser());

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->gererLaPhoto($form, $photo);

            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    private function gererLaPhoto(FormInterface $form, Photo $photo): void
    {
        $fichier = $form->get('nom_fichier')->getData();

        if ($fichier === null) {
            return;
        }

        $nomOriginal = pathinfo(
            $fichier->getClientOriginalName(),
            PATHINFO_FILENAME,
        );

        $extension = $fichier->guessExtension();
        $dossier = $this->getParameter('kernel.project_dir') . '/public/Photo';

        $nomFichier = $nomOriginal . '.' . $extension;
        $i = 1;

        while (file_exists($dossier . '/' . $nomFichier)) {
            $nomFichier = $nomOriginal . '_' . $i . '.' . $extension;
            $i++;
        }

        $fichier->move($dossier, $nomFichier);
        $photo->setNomFichier('Photo/' . $nomFichier);
    }

    #[Route('/{id}', name: 'app_photo_show', methods: ['GET'])]
    #[IsGranted(new Expression('user.getId() == subject.getIdBenevole().getId()'),subject: 'photo',message: 'Vous ne pouvez agir que sur vos propres photos.',)]
    public function show(Photo $photo): Response
    {
        return $this->render('photo/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_photo_edit', methods: ['GET', 'POST'])]
    #[IsGranted(new Expression('user.getId() == subject.getIdBenevole().getId()'),subject: 'photo',message: 'Vous ne pouvez agir que sur vos propres photos.',)]
    public function edit(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->gererLaPhoto($form, $photo);

            $entityManager->flush();

            return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_photo_delete', methods: ['POST'])]
    #[IsGranted(new Expression('user.getId() == subject.getIdBenevole().getId()'),subject: 'photo',message: 'Vous ne pouvez agir que sur vos propres photos.',)]
    public function delete(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
    }
}
