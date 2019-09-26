<?php
/**
 * Created by PhpStorm.
 * User: Serge
 * Date: 21.05.2019
 * Time: 6:25
 */
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="mainPage")
     */
    public function controller()
    {
        return $this->render('main.html.twig');
    }
}