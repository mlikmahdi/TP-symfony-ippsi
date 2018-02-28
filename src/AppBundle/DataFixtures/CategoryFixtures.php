<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 26/02/2018
 * Time: 17:22
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tab = [
            'action',
            'thriller',
            'comédie'
        ];
        $i = 0;
        foreach ($tab as $value) {
            $category = new Category();
            $category
                ->setname($value);
            $manager->persist($category);
            $this->addReference('category-' . $i, $category);
            $i++;
        }
        $manager->flush();
    }

}