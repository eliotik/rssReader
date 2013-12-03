<?php
namespace Rss\ReaderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rss\ReaderBundle\Entity\User;
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

        /**
         * @var User $user
         */
        $user = $userManager->createUser();
        $user->setUsername("admin");
        $user->setEmail("mymail@gmail.com");
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setEnabled(true);

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $encodedPass = $encoder->encodePassword('12345678', $user->getSalt());
        $user->setPassword($encodedPass);

        $manager->persist($user);

        /**
         * @var User $user2
         */
        $user2 = $userManager->createUser();
        $user2->setUsername("tester");
        $user2->setEmail("tester@gmail.com");
        $user2->setRoles(array("ROLE_USER"));
        $user2->setEnabled(true);

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user2);
        $encodedPass = $encoder->encodePassword('12345678', $user2->getSalt());
        $user2->setPassword($encodedPass);

        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user-0', $user);
        $this->addReference('user-1', $user2);
	}

	public function getOrder()
	{
		return 1;
	}
}
