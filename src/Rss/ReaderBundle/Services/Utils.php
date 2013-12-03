<?php
namespace Rss\ReaderBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;

trait Utils {
    public function createResponse($message, $json = false) {
        if ($json) {
            $return = $message;
            $return = json_encode($return);
            return new Response($return, 200, array('Content-Type'=>'application/json') );
        } else {
            throw $this->createNotFoundException($message);
        }
    }

    private function getErrorMessages(Form $form) {
        $errors = array();
        $formErrors = $form->getErrors();
        if (!$formErrors and ($form->count() > 0)) {
            /**
             * @var \Symfony\Component\Form\Form $child
             */
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }
        } else {
            /**
             * @var \Symfony\Component\Form\FormError $error
             */
            foreach ($formErrors as $key => $error) {
                $errors[] = $error->getMessage();
            }
        }

        return $errors;
    }
}