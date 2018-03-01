<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 26/02/2018
 * Time: 15:22
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Films;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FilmsManager
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFilms()
    {
        return $this->em->getRepository(Films::class)->findAll();
    }

    public function getFilm(int $id)
    {
        $film = $this->em->getRepository(Films::class)->find($id);
        if (!$film) {
            $this->errorAction(404);
        }
        return $film;
    }

    /**
     *  Retourner une erreur
     */
    private function errorAction($error)
    {
        switch ($error) {
            case 404:
                throw new NotFoundHttpException('404, Film not found');
                break;
            case 400:
                throw new BadRequestHttpException('400, Bad request');
                break;
            default:
                throw new HttpException($error, 'Film error');
                break;
        }

    }
}