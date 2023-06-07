<?php

namespace App\Controller;

use App\Enum\TMDBSearchType;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TMDBService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class APIController extends AbstractController
{
    private TMDBService $tmdbService;

    public function __construct(TMDBService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }


    /**
     * @throws ServerExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('search/{searchType}', name: 'search', methods: ['POST'])]
    public function search(Request $request, string $searchType): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);

        if(!isset($parameters['query'])){//TODO refactor using a DTO
            return $this->json(['query required']);
        }
        $page = $parameters['page'] ?? 1;
        $language = $parameters['language'] ?? 'en-US';

        $result = $this->tmdbService->search(
            TMDBSearchType::fromString($searchType),
            query: $parameters['query'],
            page: $page,
            language: $language
        );
        return $this->json($result);
    }


    /**
     * @throws InvalidArgumentException
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('{searchType}/{id}', name: 'detail', methods: ['GET'])]
    public function getDetail(Request $request, string $searchType, int $id): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $language = $parameters['language'] ?? 'en-US';
        $result = $this->tmdbService->getDetail(
            TMDBSearchType::fromString($searchType),
            id: $id,
            language: $language
        );
        return $this->json($result);
    }

}
