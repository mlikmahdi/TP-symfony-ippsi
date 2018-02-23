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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $passwordEncoder;
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
}