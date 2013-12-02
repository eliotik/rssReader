<?php

namespace Rss\ReaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $context = $this->container->get('security.context');
        if ( !$context->isGranted('IS_AUTHENTICATED_REMEMBERED') or !$context->isGranted('ROLE_USER') )
        {

            return $this->redirect( $this->generateUrl('RssReaderBundle_homepage') );

        } else {

            return $this->render('RssReaderBundle:User:index.html.twig', array(
                'pagename' => 'userhome'
            ));

        }
    }
}