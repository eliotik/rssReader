<?php
namespace Rss\ReaderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rss\ReaderBundle\Entity\Feed;

class FeedsFixtures extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{

        $feed1 = new Feed() ;
        $feed1->setName("Feed 1") ;
        $feed1->setUrl("http://test1.loc/feeds") ;
        $feed1->setUser($this->getReference('user-1'));
        $manager->persist($feed1);

        $feed2 = new Feed() ;
        $feed2->setName("Feed 2") ;
        $feed2->setUrl("http://test2.loc/feeds") ;
        $feed2->setUser($this->getReference('user-1'));
        $manager->persist($feed2);

        $manager->flush();

        $this->addReference('feed-1', $feed1);
        $this->addReference('feed-2', $feed2);
	}

	public function getOrder()
	{
		return 2;
	}
}
