<?php

namespace App\Security;

use App\Repository\UserRepository;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use App\User\Domain\Exception\InvalidJwtTokenException;
use App\User\Domain\Exception\UserException;
use App\User\Domain\TokenService;

class EmailLoginAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly UserRepository $userProvider,
        private readonly TokenService $tokenService,
    ) {}


    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $this->extractTokenFromRequest($request);

        try {
            $payload = $this->tokenService->validateAccessToken($apiToken);
        } catch (Exception $e) {
            throw new InvalidJwtTokenException('Invalid JWT token: ' . $e->getMessage());
        }

        $userIdentifier = $payload['username'] ?? null;

        if (!$userIdentifier) {
            throw new InvalidJwtTokenException('Invalid JWT payload: no email found');
        }

        return new SelfValidatingPassport(new UserBadge($userIdentifier, function (string $identifier) {
            $user = $this->userProvider->loadUserByIdentifier($identifier);

            if (!$user) {
                throw new UserException();
            }

            return $user;
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw new AuthenticationException("Authentication failed: " . $exception->getMessage());
    }

    //    public function start(Request $request, AuthenticationException $authException = null): Response
    //    {
    //        /*
    //         * If you would like this class to control what happens when an anonymous user accesses a
    //         * protected page (e.g. redirect to /login), uncomment this method and make this class
    //         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
    //         *
    //         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //         */
    //    }

    private function extractTokenFromRequest(Request $request): ?string
    {
        $header = $request->headers->get('Authorization');

        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return null;
        }

        return substr($header, 7);
    }
}
