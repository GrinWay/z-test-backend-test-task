<?php

namespace App\Security;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly ApiTokenRepository $apiTokenRepository,
    )
    {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        if (empty($accessToken)) {
            throw new AccessDeniedException('Access token is null.');
        }

        /** @var ApiToken $accessTokenEntity */
        $accessTokenEntity = $this->apiTokenRepository->findOneBy(['token' => $accessToken]);
        if (null === $accessTokenEntity) {
            throw new AccessDeniedException('Invalid credentials.');
        }

        $user = $accessTokenEntity->getUser();
        if (null === $user) {
            throw new AccessDeniedException('User is null.');
        }

        return new UserBadge(
            $user->getUserIdentifier(),
        );
    }
}
