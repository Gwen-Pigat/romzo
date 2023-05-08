<?php

namespace App\Security;

use App\Entity\User;
use App\Service\CoreService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Twig\Environment;

class UserAuthenticator extends AbstractAuthenticator
{

    private EntityManagerInterface $entityManager;
    private Environment $twig;
    private CoreService $coreService;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig, CoreService $coreService)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->coreService = $coreService;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return true; //$request->headers->has('X-AUTH-TOKEN');
    }


    public function authenticate(Request $request): Passport
    {
        $userID = $request->cookies->get($_ENV["COOKIE_NAME_USER"]);
        if (null === $userID) {
            throw new CustomUserMessageAuthenticationException("L'utilisateur n'a pas pu être récupéré");
        }
        $user = $this->userLoader($userID);
        if ($user === null) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }
        //UsersProfilesFeaturesService::getFeaturesFromUsersProfile($user->getRefUsersProfiles());
        return new SelfValidatingPassport(new UserBadge($user->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        unset($_COOKIE[$_ENV["COOKIE_NAME_USER"]]);
        return new Response($this->twig->render("error.html.twig", ["error"=>$exception->getMessage(), "constants"=>$this->coreService->getConstants()]));
    }

    private function userLoader($userId): ?User
    {
        return $this->entityManager->getRepository(User::class)->findUser($userId);
    }

}
