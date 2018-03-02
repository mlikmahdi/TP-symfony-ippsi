<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 26/02/2018
 * Time: 15:08
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Films;
use AppBundle\Manager\FilmsManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends Controller
{
    /**
     * @Route("/films", name="films_list")
     */
    public function listFilmsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository(Films:: class)->findAll();
        return $this->render('default/films/list.html.twig',
            ['films' => $films]);
    }

    /**
     * @Route("/films/{id}", name="film_view", requirements={"id"="\d+"})
     */
    public function viewFilmAction(int $id, FilmsManager $filmsManager)
    {
        $film = $filmsManager->getFilm($id);
        return $this->render('default/films/view.html.twig',
            ['film' => $film]);
    }

    /**
     * @Route("/films/search/", name="film_search")
     */
    public function searchFilmAction(Request $request, FilmsManager $filmsManager)
    {
        $search = $request->request->get('name');
        $films = $filmsManager->searchFilm($search);
        dump($films);
        return $this->render('default/films/search.html.twig',
            ['film' => $films[0]]);
    }
}
