<?php

namespace Master\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/master/{name}", name="test")
     * @Template()
     */
    public function indexAction($name)
    {
        return ['name' => $name];
        //return $this->render('default/index.html.twig', ['name' => $name]);
    }
}
