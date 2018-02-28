<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 27/02/2018
 * Time: 16:48
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom de la catégorie :'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer la catégorie']) ->getForm();
    }

}