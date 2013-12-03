<?php

namespace Rss\ReaderBundle\Controller;

use Rss\ReaderBundle\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rss\ReaderBundle\Services\Utils;
use Symfony\Component\HttpFoundation\Response;

class TopicsController extends Controller
{
    use Utils;

    public function listAction(Feed $feed)
    {
        $context = $this->container->get('security.context');
        $request = $this->getRequest();

        if (!$request->isMethod('GET')) {
            return $this->createResponse('Oops! Page not found!');
        }

        if (!$context->isGranted('ROLE_USER')) {
            return $this->redirect( $this->generateUrl('RssReaderBundle_homepage') );
        }

        if (!$feed) {
            return $this->createResponse('Oops! Feed not found!');
        }

        $return = array(
            "success" => true,
            "topics" => array()
        );

        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('RssReaderBundle:Topic')->findBy( array('feed' => $feed) );

        if (!empty($topics)) {
            /**
             * @var Topic $topic
             */
            foreach($topics as $topic) {
                $node = array();

                $node['id'] = $topic->getId();
                $node['feedId'] = $feed->getId();
                $node['link'] = $topic->getLink();
                $node['title'] = $topic->getTitle();
                $node['text'] = $topic->getText();
                $node['ts'] = $topic->getTs();
                $node['created'] = $topic->getDate();
                $node['summary'] = $topic->getSummary();
                $node['added'] = $topic->getCreated()->format("d:m:Y H:i:s");

                $return['topics'][] = $node;
            }
        }

        return new Response(json_encode($return), 200, array('Content-Type' => 'application/json'));
    }
}