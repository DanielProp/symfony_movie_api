<?php


use App\Service\TMDBService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class APIControllerTest extends WebTestCase
{
    private TMDBService $tmdbService;

    protected function setUp(): void
    {
        $this->tmdbService = $this->createMock(TMDBService::class);
    }

    public function testSearch(): void
    {
        $client = static::createClient();
        $client->request(method:'POST', uri:'http://localhost:8002/search/movie',content:  json_encode(['query' => 'Avatar']));

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertJson($content);
    }

    public function testGetDetail(): void
    {
        $client = static::createClient();
        $client->request(method: 'GET', uri:'http://localhost:8002/movie/671');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertJson($content);
    }
}