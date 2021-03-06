<?php
/**
 * Created by PhpStorm.
 * User: Serge
 * Date: 03.09.2019
 * Time: 1:25
 */

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\SodiumPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em,
        UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->encoder = $passwordEncoder;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        return 'keyRequest' === $request->attributes->get('_route');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return [
            'token' => $request->query->get('X-AUTH-TOKEN'),
            'password' => $request->query->get('password'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiToken = $credentials['token'];

        if (null === $apiToken) {
            return;
        }

        // if a User object, checkCredentials() is called
        return $this->em->getRepository(User::class)
            ->findOneBy(['apiToken' => $apiToken]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->encoder->isPasswordValid($user, $credentials['password'])){
            return true;
        }

        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = new Response();
        $response->setContent(strtr($exception->getMessageKey(), $exception->getMessageData()));

        return $response;
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $response = new Response();
        $response->setContent("Authentication required");

        return $response;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}