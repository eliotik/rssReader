<?php
namespace Rss\ReaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeedType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('user', 'user_id', array('required'=>true))
			->add('name', 'text', array('attr' => array('placeholder' => 'Enter feed name'), 'label' => ' ', 'required'=>true))
			->add('url', 'text', array('attr' => array('placeholder' => 'Enter feed url'), 'label' => ' ', 'required'=>true));
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'      => 'Rss\ReaderBundle\Entity\Feed',
                'csrf_protection' => false
            ));
    }

	public function getName()
	{
		return 'rss_readerbundle_feedtype';
	}
}