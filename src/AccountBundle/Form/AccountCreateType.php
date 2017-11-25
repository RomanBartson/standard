<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 15.11.2017
 * Time: 23:21
 */

namespace AccountBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;


class AccountCreateType extends AccountBaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('username', TextType::class, [
            'constraints' => [
                new Length(['max' => 10]),
                new NotBlank()
            ],
            'attr' => array('class'=>'form-control'),
        ])->add('plainPassword', RepeatedType::class, [
            'constraints' => new NotBlank(),
            'type' => PasswordType::class,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
        ]);
    }
}