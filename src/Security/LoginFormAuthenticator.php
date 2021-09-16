<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginFormAuthenticator extends AbstractGuardAuthenticator
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // Check if the request method is POST and route matches security_login
    public function supports(Request $request)
    {
        return $request->isMethod('POST') && $request->attributes->get('_route') === 'security_login';
    }

    // Get the filled form
    public function getCredentials(Request $request)
    {
        return $request->request->get('login');
    }

    // Check if user exist
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $userProvider->loadUserByIdentifier($credentials['email']);

        if (!$user) {
            throw new AuthenticationException("Identifiant ou mot de passe incorrect");
        }

        return $user;
    }

    // Check the password
    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->encoder->isPasswordValid($user, $credentials['password'])) {
            return true;
        }
        throw new AuthenticationException("Identifiant ou mot de passe incorrect");
    }

    // Set what happens if authentication fail
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->attributes->set('login.error', $exception->getMessage());
    }

    // Set what happens when authentication succeed
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $url = $request->getSession()->get('login.redirect', '/');

        $request->getSession()->getFlashBag()->add('success', 'Vous avez été connecté avec succès');

        return new RedirectResponse($url);
    }

    // Set the url to be redirect to when logged in
    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        $request->getSession()->set('login.redirect', $request->getPathInfo());

        return new RedirectResponse("/connexion");
    }

    public function supportsRememberMe()
    {
    }
}
