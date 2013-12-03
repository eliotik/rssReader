<?php
namespace Rss\ReaderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rss\ReaderBundle\Entity\Topic;

class TopicsFixtures extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{

        $topic1 = new Topic() ;
        $topic1->setText("Body of Topic 1") ;
        $topic1->setSummary("Summary of Topic 1") ;
        $topic1->setFeed($this->getReference('feed-1'));
        $manager->persist($topic1);

        $topic2 = new Topic() ;
        $topic2->setText("Body of Topic 2") ;
        $topic2->setSummary("Summary of Topic 2") ;
        $topic2->setFeed($this->getReference('feed-1'));
        $manager->persist($topic2);

        $topic3 = new Topic() ;
        $topic3->setText("Body of Topic 3") ;
        $topic3->setSummary("Summary of Topic 3") ;
        $topic3->setFeed($this->getReference('feed-2'));
        $manager->persist($topic3);

        $manager->flush();

        $this->addReference('topic-1', $topic1);
        $this->addReference('topic-2', $topic2);
        $this->addReference('topic-3', $topic3);
	}

	public function getOrder()
	{
		return 3;
	}
}
