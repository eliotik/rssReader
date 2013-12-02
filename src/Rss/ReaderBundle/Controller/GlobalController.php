<?php

namespace Rss\ReaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GlobalController extends Controller
{
    public function indexAction()
    {
        $context = $this->container->get('security.context');
        if ( $context->isGranted('IS_AUTHENTICATED_REMEMBERED') and $context->isGranted('ROLE_ADMIN') )
        {

            return $this->redirect( $this->generateUrl('RssReaderBundle_adminpage') );

        } elseif ( $context->isGranted('IS_AUTHENTICATED_REMEMBERED') and $context->isGranted('ROLE_USER') ) {

            return $this->redirect( $this->generateUrl('RssReaderBundle_userpage') );

        } else {

            return $this->render('RssReaderBundle:Global:index.html.twig', array(
                'pagename' => 'home'
            ));

        }
    }
}