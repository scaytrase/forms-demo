<?php

namespace ScayTrase\Demo\Forms\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route(name="demo_index", path="/")
     */
    public function indexAction()
    {
        $metadatas = $this->getDoctrine()->getManager()->getMetadataFactory()->getAllMetadata();

        return $this->render(
            'Index/index.html.twig',
            [
                'metadatas' => $metadatas,
            ]
        );
    }
}
