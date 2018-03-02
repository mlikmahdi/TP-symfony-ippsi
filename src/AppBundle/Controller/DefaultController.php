<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Films;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository(Films::class)->findBy(
            [],
            ['id' => 'desc'],
            3,
            0
        );
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'films' => $films,
            'categories' => $categories
        ]);
    }

    /*
     *  Exo atelier en cours
     */
    public function menuAction()
    {
        $items = ['Item1', 'Item2', 'Item3'];
        return $this->render('default/menu.html.twig');
    }

}
