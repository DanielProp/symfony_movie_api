<?php

namespace App\Service;

use App\Enum\TMDBSearchType;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class TMDBService
{
    private const TMDB_API_BASE_URL = 'https://api.themoviedb.org/3';
    private const TMDB_DEFAULT_LANGUAGE = 'en-US';
    private HttpClientInterface $client;
    private string $apiKey;

    private FilesystemAdapter $cache;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->cache = new FilesystemAdapter();
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function search(TMDBSearchType $searchType, string $query, int $page = 1, string $language = self::TMDB_DEFAULT_LANGUAGE, bool $includeAdultContent = false): array
    {
        $url = self::TMDB_API_BASE_URL . '/search/' . $searchType->value;
        $params = [
            'api_key' => $this->apiKey,
            'query' => $query,
            'page' => $page,
            'language' => $language,
            'include_adult' => $includeAdultContent
        ];
        $cacheKey = 'search'.$searchType->value.$query.$page.$language.$includeAdultContent;

        return $this->cache->get(key: $cacheKey, callback: function() use ($url, $params) {
            return $this->client->request('GET', $url, ['query' => $params])->toArray();
        });
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getDetail(TMDBSearchType $searchType, int $id, string $language = self::TMDB_DEFAULT_LANGUAGE): array
    {
        $url = self::TMDB_API_BASE_URL . '/' . $searchType->value . '/' . $id;
        $params = [
            'api_key' => $this->apiKey,
            'language' => $language,
            'append_to_response' => 'videos'
        ];
        $cacheKey = 'getDetail'.$searchType->value.$id.$language.'videos';

        return $this->cache->get(key: $cacheKey, callback: function() use ($url, $params){
            return $this->client->request('GET', $url, ['query' => $params])->toArray();
        });

    }

}
