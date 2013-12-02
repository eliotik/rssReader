<?php
namespace Rss\ReaderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

	public function load(ObjectManager $manager)
	{
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername("admin");
        $user->setEmail("mymail@gmail.com");
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setEnabled(true);

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $encodedPass = $encoder->encodePassword('1234', $user->getSalt());
        $user->setPassword($encodedPass);

        $manager->persist($user);
        $manager->flush();

        $this->addReference('user-1', $user);
	}

	public function getOrder()
	{
		return 1;
	}
}
