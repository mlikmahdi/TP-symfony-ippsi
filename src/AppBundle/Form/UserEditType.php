<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 02/03/2018
 * Time: 12:16
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isAdmin', ChoiceType::class, array(
                'label' => 'Administrateur :',
                'choices' => array(
                    'Oui' => true,
                    'Non' => false
                )
            ));
    }

    public function getParent()
    {
        return UserType::class;
    }

}