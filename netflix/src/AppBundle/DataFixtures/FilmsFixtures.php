<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 26/02/2018
 * Time: 14:55
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Films;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FilmsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        for ($i = 0; $i < 30; $i++) {
            $article = new Films();
            $article
                ->setName('Film ' . $i)
                ->setDescription('Lorem ipsum lorem ipsum')
                ->setImage('fixtureImage');
                $manager->persist($article);
        }
        $manager->flush();
    }

}
