<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 26/02/2018
 * Time: 17:01
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Films;
use AppBundle\Form\FilmType;
use AppBundle\Manager\FilmsManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FilmsController extends Controller
{

    /**
     * @Route("/admin/films", name="filmsAdmin_list")
     */
    public function listFilmsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository(Films:: class)->findAll();
        return $this->render('default/admin/film/list.html.twig', [
            'films' => $films ]);
    }

    /**
     * @Route("/admin/films/{id}", name="filmAdmin_view", requirements={"id"="\d+"})
     */
    public function viewFilmAction(int $id, FilmsManager $filmsManager)
    {
        $film = $filmsManager->getFilm($id);
        return $this->render('default/admin/film/view.html.twig',
            [ 'film' => $film ]);
    }

    /**
     * @Route("/admin/films/add", name="films_add")
     */
    public function addFilmAction(Request $request)
    {
        $film = new Films();

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $film = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('default/admin/film/addFilm.html.twig',
            [ 'form' => $form->createView()] );
    }

    /**
     * @Route("/admin/films/{id}/edit", name="film_edit")
     */
    public function editArticleAction(Request $request, Int $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Films $film */
        $film = $em->getRepository(Films::class)->find($id);
        $film->setImage(null);

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $film = $form->getData();
            $em = $this->getDoctrine()->getManager(); $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('filmsAdmin_list');
        }

        return $this->render('default/admin/film/editFilm.html.twig',
            [ 'form' => $form->createView() ]);
    }
}