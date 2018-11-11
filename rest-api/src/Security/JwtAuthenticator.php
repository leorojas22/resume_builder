<?php

namespace App\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


class JwtAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        return $request->cookies->get("jwt") ? true : false;
    }

    public function getCredentials(Request $request)
    {
        $cookie = $request->cookies->get("jwt");

        // Default error message
        $error = "Unable to validate session.";

        try
        {
            $decodedJwt = JWT::decode($cookie, getenv("JWT_SECRET"), ['HS256']);
            return [
                'user_id' => $decodedJwt->user_id,
                'email' => $decodedJwt->email
            ];
        }
        catch(ExpiredException $e)
        {
            $error = "Session has expired.";
        }
        catch(SignatureInvalidException $e)
        {
            // In this case, you may also want to send an email to yourself with the JWT
            // If someone uses a JWT with an invalid signature, it could
            // be a hacking attempt.
            $error = "Attempting access invalid session.";
        }
        catch(\Exception $e)
        {
           // Use the default error message
        }


        throw new CustomUserMessageAuthenticationException($error);

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $user->getId() === $credentials['user_id'];
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'error' => $exception->getMessageKey()
        ], 400);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // Allow request to continue

    }

    public function start(Request $request, AuthenticationException $authException = null)
    {

    }

    public function supportsRememberMe()
    {

    }
}
