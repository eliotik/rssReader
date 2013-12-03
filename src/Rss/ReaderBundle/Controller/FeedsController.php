<?php

namespace Rss\ReaderBundle\Controller;

use Rss\ReaderBundle\Entity\Feed;
use Rss\ReaderBundle\Form\Type\FeedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rss\ReaderBundle\Services\Utils;
use Symfony\Component\HttpFoundation\Response;

class FeedsController extends Controller
{
    use Utils;

    public function listAction()
    {
        $context = $this->container->get('security.context');
        $request = $this->getRequest();

        if (!$request->isMethod('GET')) {
            return $this->createResponse('Oops! Page not found!');
        }

        if (!$context->isGranted('ROLE_USER')) {
            return $this->redirect( $this->generateUrl('RssReaderBundle_homepage') );
        }

        $user = $context->getToken()->getUser();

        $return = array(
            "success" => true,
            "feeds" => array()
        );

        $em = $this->getDoctrine()->getManager();

        $feeds = $em->getRepository('RssReaderBundle:Feed')->findBy( array('user' => $user) );

        if (!empty($feeds)) {
            /**
             * @var Feed $feed
             */
            foreach($feeds as $feed) {
                $node = array();

                $node['id'] = $feed->getId();
                $node['text'] = $feed->getName();
                $node['name'] = $node['text'];
                $node['url'] = $feed->getUrl();
                $node['leaf'] = true;
                $node['loaded'] = true;

                $return['feeds'][] = $node;
            }
        }

        return new Response(json_encode($return), 200, array('Content-Type' => 'application/json'));
    }

    public function createAction()
    {
        $context = $this->container->get('security.context');
        $request = $this->getRequest();

        if (!$request->isMethod('POST') || !$context->isGranted('ROLE_USER')) {
            return $this->createResponse(array("success"=>false,"message"=>'Oops! Page not found!') ,true);
        }

        $feed = new Feed();
        $form = $this->createForm(new FeedType(), $feed);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getManager();
            $em->persist($feed);
            $em->flush();

            return $this->createResponse(
                array(
                    "success"=>true,
                    "id"=>$feed->getId()
                ),
                true
            );
        }

        return $this->createResponse(
            array(
                "success"=>false,
                "message"=>"You have errors! Please check submitted data and try again!",
                "errors"=>$this->getErrorMessages($form)
            ) ,
            true
        );
    }

    public function updateAction(Feed $feed)
    {
        $context = $this->container->get('security.context');
        $request = $this->getRequest();

        if (!$request->isMethod('POST') || !$context->isGranted('ROLE_USER')) {
            return $this->createResponse(array("success"=>false,"message"=>'Oops! Page not found!') ,true);
        }

        if (!$feed) {
            return $this->createResponse(array("success"=>false,"message"=>'No Feed found!') ,true);
        }

        $form = $this->createForm(new FeedType(), $feed);
        $form->submit($request->request->all());

        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $em = $this
                    ->getDoctrine()
                    ->getManager();

                $em->persist($feed);
                $em->flush();

                return $this->createResponse(
                    array(
                        "success"=>true,
                        "id"=>$feed->getId()
                    ),
                    true
                );
            }
        }

        return $this->createResponse(
            array(
                "success"=>false,
                "message"=>"You have errors! Please check submitted data and try again!",
                "errors"=>$this->getErrorMessages($form)
            ) ,
            true
        );
    }

    public function deleteAction(Feed $feed)
    {
        $context = $this->container->get('security.context');
        $request = $this->getRequest();

        if (!$request->isMethod('POST')) {
            return $this->createResponse('Oops! Page not found!');
        }

        if (!$context->isGranted('ROLE_USER')) {
            return $this->redirect( $this->generateUrl('RssReaderBundle_homepage') );
        }

        if (!$feed) {
            return $this->createResponse('Oops! Feed not found!');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($feed);
        $em->flush();

        return $this->createResponse( array( "success"=>true ), true );
    }

    public function deleteAllAction()
    {
        $context = $this->container->get('security.context');
        $request = $this->getRequest();

        if (!$request->isMethod('POST')) {
            return $this->createResponse('Oops! Page not found!');
        }

        if (!$context->isGranted('ROLE_USER')) {
            return $this->redirect( $this->generateUrl('RssReaderBundle_homepage') );
        }

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('RssReaderBundle:Feed');

        $feeds = $repository->findAll();
        foreach ($feeds as $feed) {
            $em->remove($feed);
        }
        $em->flush();

        return $this->createResponse( array( "success"=>true ), true );
    }
}
