<?php

namespace B2\AccountBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('firstName');
        $builder->add('lastName');
    }


    public function getParent()
    {
        return 'fos_user_registration';
    }


    public function getName()
    {
        return 'b2_user_registration';
    }

} 