<?php

namespace Rss\ReaderBundle\Services;

use Symfony\Component\HttpKernel\Log\LoggerInterface;

class RssLoader
{
    private $posts = array();
    const SUMMARY_MAX_LENGTH = 300;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @param $url
     *
     * @return array
     */
    public function getStream($url)
    {
        $this->posts = array();

        if ( !($response = @simplexml_load_file($url)) ) {
            $this->logger->err("Cannot load feeds from given url: $url");
            return $this->posts;
        }

        if ( !property_exists($response,'channel') || !property_exists($response->channel,'item') ) {
            $this->logger->err("No 'channel' or no 'items' in parsed response: ".json_encode($response));
            return $this->posts;
        }

        foreach ($response->channel->item as $item)
        {
            $feed = array();

            $feed['link']  = (property_exists($item,'link')) ? (string) $item->link : "[no link]";
            $feed['title'] = (property_exists($item,'title')) ? (string) $item->title : "[no title]";
            $feed['text']  = (property_exists($item,'description')) ? (string) $item->description : "[no description]";
            $feed['date']  = (property_exists($item,'pubDate')) ? (string) $item->pubDate : "[no create date]";
            $feed['ts']    = (property_exists($item,'pubDate')) ? strtotime($item->pubDate) : 0;

            $feed['summary'] = $this->getSummary($feed['text']);

            $this->posts[] = $feed;
        }

        $count = count($this->posts);
        $this->logger->info("Received $count feeds from url: $url , \n" . json_encode($this->posts));

        return $this->posts;
    }

    /**
     * @param $summary
     *
     * @return string
     */
    private function getSummary($summary) {
        $summary = strip_tags($summary);

        if (strlen($summary) > self::SUMMARY_MAX_LENGTH) {
            $summary = substr($summary, 0, self::SUMMARY_MAX_LENGTH) . '...';
        }

        return $summary;
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }
}