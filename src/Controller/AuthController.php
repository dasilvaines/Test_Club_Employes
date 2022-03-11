<?php

namespace App\Controller;

use App\Entity\Friends;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\Response;


#[Route('/api')]
class AuthController extends AbstractController
{
  public function __construct(
    private UserRepository $userRepository,
    private Security $security,
    private SerializerInterface $serializer,

  )
  {

  }

  #[Route('/register', name: 'user.register')]
  public function app(Request $request) : JsonResponse
  {
    $jsonData = json_decode($request->getContent());
    $user = $this->userRepository->create($jsonData);

    return new JsonResponse([
      'user' => $this->serializer->serialize($user, 'json')
    ], 201);
  }

  #[Route('/profile', name: 'user.profile')]
  public function profile() : JsonResponse
  {
    $currentUser = $this->security->getUser();
    $user = $this->serializer->serialize($currentUser, 'json');
    return new JsonResponse([
      $user
    ], 200);
  }

  #[Route('/listofFriends', name: 'user.list')]
  public function listOfFriends(Request $request): JsonResponse
  {
      $users = $this->userRepository->findAll();
      //$users = $em->getRepository(User::class)->findAll();
      return new JsonResponse([
          'user' => $this->serializer->serialize($users, 'json')
      ], 202);
  }


/*
    #[Route('/addFriend', name: 'user.addFriend')]
    public function addFriend(User $friend, EntityManager $em)
    {
        $currentUser = $this->getUser();
        if (!$currentUser instanceof User) {
            throw new UnauthorizedHttpException('Probably you are not authorized');
        }
        $currentUserId = $currentUser->getId();
        $friendId = $friend->getId();
        if ($currentUser->hasFriend($friendId)) {
            $conflictMessage = sprintf('user %s is already your friend', $friendId);
            throw new ConflictHttpException($conflictMessage);
        }
        // Add a friend and make friendship request
        $currentUser->addFriend($friendId);
        $friend->addRequest($currentUserId);

        // Accept removes request if exists any
        $currentUser->removeRequest($friendId);

        $em->persist($currentUser);
        $em->flush();
    }

*/
    #[Route('/list', name: 'user.addFriend')]
    public  function listFriend(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $users = $this->getDoctrine()->getRepository(Friends::class)->findAll();
        $response->setStatusCode(200);
        $response->setContent(json_encode($users));
        return $response;

    }



}