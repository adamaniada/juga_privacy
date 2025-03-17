<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Psr\Log\LoggerInterface;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $this->getLoginUrl($request) === $request->getPathInfo();
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('_username', '');
        $password = $request->request->get('_password', '');
        $csrfToken = $request->request->get('_csrf_token');

        // You can remove this dd() in a production environment
        // dd($email, $password, $csrfToken);

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email, function (string $userIdentifier) {
                return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $userIdentifier]);
            }),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        // throw new \Exception('Please provide a valid target path after authentication success!');

        // Rediriger l'utilisateur vers sa page de profil par défaut
        return new RedirectResponse($this->urlGenerator->generate('app_profile'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($exception instanceof CustomUserMessageAuthenticationException) {
            $message = $exception->getMessage();
        } else {
            // You can translate or customize these generic error messages based on the exception key
            switch ($exception->getMessageKey()) {
                case 'Invalid credentials.':
                    $message = 'Nom d\'utilisateur ou mot de passe incorrect.';
                    break;
                case 'User account is disabled.':
                    $message = 'Ce compte utilisateur est désactivé. Veuillez contacter l\'administrateur.';
                    break;
                case 'Account not found.':
                    $message = 'Aucun compte trouvé avec cet email. Vérifiez l\'adresse email saisie.';
                    break;
                case 'Account is locked.':
                    $message = 'Ce compte est verrouillé. Veuillez contacter l\'administrateur pour le déverrouiller.';
                    break;
                case 'Email not verified.':
                    $message = 'Votre adresse email n\'est pas vérifiée. Veuillez vérifier votre email pour continuer.';
                    break;
                // Add more cases as needed for other potential exception keys
                default:
                    $message = 'Une erreur s\'est produite lors de la connexion. Veuillez réessayer plus tard.';
                    $this->logger->error('Unhandled authentication failure: ' . $exception->getMessageKey() . ' - ' . $exception->getMessage());
                    break;
            }
        }
    
        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, new CustomUserMessageAuthenticationException($message));
        }
    
        $this->logger->error('Authentication failure for user: ' . $request->request->get('_username', '') . ' - ' . $message);
    
        return new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));
    }    

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
