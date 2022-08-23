<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api", name="api_post_")
 */
class PostController extends AbstractController
{
    /**
    * @Route("/posts/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
    */
    public function read(PostRepository $postRepo, int $id): Response
    {
        $post = $postRepo->find($id);
        // var_dump($post);
        // $date=$post->getDate();
        // var_dump($date);
        // die;
        return $this->json($post, 200, [], ['groups' => 'api_post_read']);
    }

    /**
    * @Route("/posts", name="create", methods={"POST"})
    */
    public function create(
        PostRepository $postRepo, 
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
        )
    {

        $data = $request->getContent();

        $post = $serializer->deserialize($data, Post::class, 'json');

        $errors = $validator->validate($post);

    
        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return $this->json($errorsString, Response::HTTP_BAD_REQUEST);
        }
        $post->setStatus(1);
        $post->setCreatedAt(new \DateTimeImmutable());
        $postRepo->add($post, true);

        return $this->json('Point d\'intérêt ajouté', Response::HTTP_CREATED);
    }

    /**
     * @Route("/posts/{id<\d+>}", name="update", methods="PATCH", requirements={"id"="\d+"})
     * @return Response
     */
    public function update(
        $id,
        EntityManagerInterface $em, 
        PostRepository $postRepository,
        Request $request, 
        SerializerInterface $serializer,
        ValidatorInterface $validator
        )
    {

        $post = $postRepository->find($id);

        // if current user doesnt have the role of Admin or is not the author of this post, it will thrown an "acces denied"
        if ($this->getUser()->getRoles() !== ['ROLE_ADMIN']) {
            if ($post->getUser() !== $this->getUser()) {
                return $this->json("Vous n'avez pas le droit de modifier ce point d'intérêt", 403);
            }
        }
        
        if ($post === null )
        {
            $errors = [ 
                'error' => true,
                'message' => 'No post found for id [' . $id . ']'
            ];
            $errorsString = (string) $errors;
            return $this->json($errorsString, Response::HTTP_BAD_REQUEST);
        }

        $data = $request->getContent();

        $post = $serializer->deserialize($data, Post::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $post]);

        $errors = $validator->validate($post);

        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return $this->json($errorsString, Response::HTTP_BAD_REQUEST);
        }

        $post->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();

        return $this->json('Point d\'intérêt modifié', Response::HTTP_OK);
    }
}