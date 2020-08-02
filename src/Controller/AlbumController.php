<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("", requirements={"_locale": "en|es|fr"}, name="album")
     */
    public function index()
    {
        return $this->render('album/index.html.twig', [
            'controller_name' => 'AlbumController',
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     * @ParamConverter("album", class="App\Entity\Album")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Album $album,
                         Request $request)
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();
            return $this->redirectToRoute('tracks', ['id' => $album->getId()]);
        }

        return $this->render('album/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id)
    {
        return $this->render('album/delete.html.twig', [
            'controller_name' => '',
        ]);
    }

    /**
     * @Route("/new", name="new")
     *
     */
    public function new()
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);

        return $this->render('album/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
