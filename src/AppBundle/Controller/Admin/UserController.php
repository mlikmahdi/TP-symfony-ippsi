<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 01/03/2018
 * Time: 14:40
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\User;
use AppBundle\Form\UserEditType;
use AppBundle\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/admin/users", name="usersAdmin_list")
     */
    public function listUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('default/admin/user/listUsers.html.twig', [
            'users' => $users]);
    }

    /**
     * @Route("/admin/user/{id}", name="userAdmin_view", requirements={"id"="\d+"})
     */
    public function viewUserAction(int $id, UserManager $userManager)
    {
        /** @var User $user */
        $user = $userManager->getUser($id);
        return $this->render('default/admin/user/viewUser.html.twig',
            ['user' => $user]);
    }

    /**
     * @Route("/admin/user/add", name="user_add")
     */
    public function addUserAction(Request $request, UserManager $userManager)
    {
        $user = new User();

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $userManager->createUser($user->getUsername(), $user->getEmail(), $user->getPlainPassword(), $user->getIsAdmin());
            return $this->redirectToRoute('adminHome');
        }

        return $this->render('default/admin/user/addUser.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/user/{id}/edit", name="user_edit")
     */
    public function editUserAction(Request $request, Int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('usersAdmin_list');
        }

        return $this->render('default/admin/user/editUser.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/{id}/delete", name="user_delete")
     */
    public function deleteUserAction(Int $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('usersAdmin_list');

    }

}