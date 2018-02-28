<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 27/02/2018
 * Time: 16:16
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Manager\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="categories_list")
     */
    public function listCategoryAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category:: class)->findAll();
        return $this->render('default/category/list.html.twig', [
            'categories' => $categories ]);
    }

    /**
     * @Route("/category/{id}", name="category_view", requirements={"id"="\d+"})
     */
    public function viewCategoryAction(int $id, CategoryManager $categoryManager)
    {
        $category = $categoryManager->getCategory($id);
        return $this->render('default/category/view.html.twig',
            [ 'category' => $category ]);
    }

}