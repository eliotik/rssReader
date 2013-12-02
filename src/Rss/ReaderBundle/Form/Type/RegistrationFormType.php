<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rss\ReaderBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => ' ', 'attr' => array('placeholder' => 'form.username', 'class' => "rssreader-login-form__login"), 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => ' ', 'attr' => array('placeholder' => 'form.email', 'class' => "rssreader-email-form__login"), 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_name' => 'pass',
                'second_name' => 'confirm',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => ' ', 'attr' => array('placeholder' => 'form.password', 'class' => "rssreader-login-form__password")),
                'second_options' => array('label' => ' ', 'attr' => array('placeholder' => 'form.password_confirmation', 'class' => "rssreader-login-form__password")),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }
    
    public function getName()
    {
        return 'rssreader_user_registration';
    }    
}
