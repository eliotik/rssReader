<?php
namespace Rss\ReaderBundle\Command;

use Composer\Config;
use Rss\ReaderBundle\Entity\Feed;
use Rss\ReaderBundle\Entity\Topic;
use Rss\ReaderBundle\Services\RssLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportFeedsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('rss:feeds:import')
            ->setDescription('Import topics by all rss feeds for all users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /**
         * @var RssLoader $rssLoader
         */
        $rssLoader = $this->getContainer()->get("rssreader.rssloader");

        $em = $this->getContainer()->get("doctrine")->getManager();

        $feeds = $em->getRepository('RssReaderBundle:Feed')->findAll();

        if (!empty($feeds)) {

            $output->writeln("Found feeds for import: ".count($feeds));

            $topics = array();
            /**
             * @var Feed $feed
             */
            foreach($feeds as $feed) {

                $output->writeln("Loading feed: {$feed->getName()} for user {$feed->getUser()->getUsername()} from url: {$feed->getUrl()}");

                $feedTopics = $rssLoader->getStream($feed->getUrl());
                $output->writeln("Found topics: ".count($feedTopics));

                if (empty($feedTopics)) {
                    $output->writeln("Skipping.");
                    $output->writeln("----------------------------------");
                    Continue;
                }

                $item = array();
                $item['feed'] = $feed;
                $item['topics'] = $feedTopics;

                $topics[] = $item;
                $output->writeln("----------------------------------");
            }

            $imported = 0;
            $updated = 0;
            if (!empty($topics)) {
                foreach($topics as $feedData) {
                    foreach($feedData['topics'] as $topicData) {
                        /**
                         * @var Topic $topic
                         */
                        $topic = $em
                            ->getRepository('RssReaderBundle:Topic')
                            ->findOneBy(
                                array(
                                    'feed' => $feedData['feed'],
                                    'link' => $topicData['link']
                                )
                            );
                        if ($topic) {
                            $topic->setDate($topicData['date']);
                            $topic->setSummary($topicData['summary']);
                            $topic->setText($topicData['text']);
                            $topic->setTs($topicData['ts']);
                            $topic->setTitle($topicData['title']);

                            ++$updated;
                        } else {
                            $topic = new Topic();
                            $topic->setFeed($feedData['feed']);
                            $topic->setDate($topicData['date']);
                            $topic->setSummary($topicData['summary']);
                            $topic->setText($topicData['text']);
                            $topic->setTs($topicData['ts']);
                            $topic->setTitle($topicData['title']);
                            $topic->setLink($topicData['link']);

                            ++$imported;
                        }

                        $em->persist($topic);
                        $em->flush();
                    }
                }
            }

            $output->writeln("");
            if ($imported or $updated) {
                $output->writeln("Import done! Imported $imported topics! Updated $updated topics! \\(^.^)/");
            } else {
                $output->writeln("Import done! Nothing was imported neither updated! ,(-.-),");
            }
            $output->writeln("");

        } else {
            $output->writeln("No feeds were found for importing.");
        }
    }
}