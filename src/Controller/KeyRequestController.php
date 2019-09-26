<?php
/**
 * Created by PhpStorm.
 * User: Serge
 * Date: 02.09.2019
 * Time: 17:09
 */
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Worker\KeyManager;

class KeyRequestController extends AbstractController
{
    /**
     * @Route("/kr", name="keyRequest")
     */
    public function controller(EntityManagerInterface $em)
    {
        $request = Request::createFromGlobals();
        $email = $request->query->get("email");
        if ($email == ""){
            return new RedirectResponse("/");
        }

        $key = KeyManager::ProcessEmail($email, $em);

        $response = new Response();
        $response->setContent($key);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }
}