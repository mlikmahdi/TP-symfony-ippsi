<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 27/02/2018
 * Time: 16:24
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getCategories()
    {
        return $this->em->getRepository(Category::class)->findAll();
    }

    public function getCategory(int $id)
    {
        $category = $this->em->getRepository(Category::class)->find($id);
        if (!$category) {
            $this->errorAction(404);
        }
        return $category;
    }

    /**
     *  Retourner une erreur
     */
    private function errorAction($error)
    {
        switch ($error) {
            case 404:
                throw new NotFoundHttpException('404, Article not found');
                break;
            case 400:
                throw new BadRequestHttpException('400, Bad request');
                break;
            default:
                throw new HttpException($error, 'Article error');
                break;
        }

    }
}