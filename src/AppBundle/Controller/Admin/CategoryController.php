<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 27/02/2018
 * Time: 16:52
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/category", name="categoryAdmin_list")
     */
    public function listCategoryAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('default/admin/category/list.html.twig', [
            'categories' => $categories ]);
    }

    /**
     * @Route("/admin/category/add", name="category_add")
     */
    public function addCategoryAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('default/admin/category/addCategory.html.twig',
            [ 'form' => $form->createView()] );
    }

    /**
     * @Route("/admin/category/{id}/edit", name="category_edit")
     */
    public function editCategoryAction(Request $request, Int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager(); $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('categoryAdmin_list');
        }

        return $this->render('default/admin/category/editCategory.html.twig',
            [ 'form' => $form->createView() ]);
    }

}