<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrowseController extends AbstractController
{
    /**
     * @Route("/browse", name="browse")
     */
    public function index()
    {
        return $this->render('browse/index.html.twig', [
            'controller_name' => 'BrowseController',
        ]);
    }

    /**
     * @Route("/artists", name="artists")
     *
     * @return Response
     */
    public function artists()
    {
        $artists = $this->getDoctrine()
            ->getRepository(Artist::class)
            ->findBy([], ['name' => 'ASC']);

        return $this->render('browse/artists.html.twig', [
           'artists' => $artists,
        ]);
    }

    /**
     * @Route("/artists/{artistId}", name="albums")
     *
     * @param $artistId
     *
     * @return Response
     */
    public function albums(int $artistId)
    {
        /*$albums = $this->getDoctrine()
            ->getRepository(Album::class)
            ->findBy(['artist' => $artistId], ['name' => 'DESC']);
        */
        $artistName = $this->getDoctrine($artistId)
            ->getRepository(Artist::class)
            ->find($artistId);
        if (null == $artistName) {
            throw $this->createNotFoundException('Pas d\'artiste avec cet id '.$artistId);
        }

        return $this->render('browse/albums.html.twig', [
            'albums' => $artistName->getAlbums(),
            'artistName' => $artistName,
        ]);
    }

    /**
     * @Route("/tracks/{id}", name="tracks")
     * @Entity("album", expr="repository.findWithTracksAndSongs(id)")
     *
     * @param Album $album
     * @return Response
     */
    public function tracks(Album $album)
    {

        return $this->render('browse/tracks.html.twig', [
            'album' => $album,
        ]);
    }
}
