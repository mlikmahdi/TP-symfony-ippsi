<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 23/02/2018
 * Time: 10:55
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $this->loadUserAdmin($manager);
        $this->loadUser($manager);
    }

    private function loadUserAdmin(ObjectManager $manager)
    {
        $i = 0;
        $username = 'MM ' . $i;
        $email = $i . 'MM@gmail.com';

        for ($i = 0; $i < 3; $i++) {
            $user = $this->userManager->createUser($username, $email, 'user', true);
            $this->addReference('user-admin-' . $i , $user);
        }
        $manager->flush();
    }

    private function loadUser(ObjectManager $manager)
    {
        $i = 0;
        $username = 'MaMoh' . $i;
        $email = $i . 'MaMoh@gmail.com';

        for ($i = 0; $i < 10; $i++) {
            $user = $this->userManager->createUser($username, $email, 'user', false);
            $this->addReference('user-' . $i , $user);
        }
        $manager->flush();
    }

}
