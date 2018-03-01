<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 23/02/2018
 * Time: 11:05
 */

namespace AppBundle\Manager;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function createUser($username, $email, $password, $isAdmin)
    {
        $user = new User();
        $password = $this->passwordEncoder->encodePassword($user, $password);
        $user
            ->setUsername($username)
            ->setEmail($email)
            ->setCreatedAt(new \DateTime())
            ->setDeletedAt(null)
            ->setBannedAt(null)
            ->setPassword($password) // bcrypt:user
            ->setIsAdmin($isAdmin);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function getUsers()
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function getUser(int $id)
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            $this->errorAction(404);
        }
        return $user;
    }

    /**
     *  Retourner une erreur
     */
    private function errorAction($error)
    {
        switch ($error) {
            case 404:
                throw new NotFoundHttpException('404, User not found');
                break;
            case 400:
                throw new BadRequestHttpException('400, Bad request');
                break;
            default:
                throw new HttpException($error, 'User error');
                break;
        }

    }
}