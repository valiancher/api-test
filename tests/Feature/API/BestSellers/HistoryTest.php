<?php

namespace Feature\API\BestSellers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Tests\TestCase;

class HistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_best_sellers_history_api_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['api-key' => $api_key];
        ksort($requestArray);
        $cacheKey = md5(json_encode($requestArray));
        Cache::shouldReceive('has')
            ->once()
            ->with( $cacheKey )
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->once()
            ->with( $cacheKey )
            ->andReturn($data);


        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
                'copyright' => "Copyright (c) 2025 The New York Times Company.  All Rights Reserved.",
            ]);
    }

    public function test_best_sellers_history_api_author_validation_fail_endpoint(): void
    {
        $api_key = Str::random('32');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?&author=&api-key=' . $api_key);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_author_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['author' => 'abc', 'api-key' => $api_key];
        $cacheKey = md5(json_encode($requestArray));

        Cache::shouldReceive('has')
            ->once()
            ->with( $cacheKey )
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->once()
            ->with( $cacheKey )
            ->andReturn($data);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?author=abc&api-key=' . $api_key);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ]);
    }

    public function test_best_sellers_history_api_isbn_validation_fail_endpoint(): void
    {
        $api_key = Str::random('32');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?isbn[]=123&api-key=' . $api_key);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_isbn_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['api-key' => $api_key, 'isbn' => ['0871404427']];
        $cacheKey = md5(json_encode($requestArray));

        Cache::shouldReceive('has')
            ->once()
            ->with( $cacheKey )
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->once()
            ->with( $cacheKey )
            ->andReturn($data);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?isbn[]=0871404427&api-key=' . $api_key);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ]);
    }

    public function test_best_sellers_history_api_title_validation_fail_endpoint(): void
    {
        $api_key = Str::random('32');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?title=&api-key=' . $api_key);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_title_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['title' => 'Til Faith Do Us Part: How Interfaith Marriage', 'api-key' => $api_key];
        $cacheKey = md5(json_encode($requestArray));

        Cache::shouldReceive('has')
            ->once()
            ->with( $cacheKey )
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->once()
            ->with( $cacheKey )
            ->andReturn($data);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?title=Til Faith Do Us Part: How Interfaith Marriage&api-key=' . $api_key);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ]);
    }

    public function test_best_sellers_history_api_offset_validation_fail_endpoint(): void
    {
        $api_key = Str::random('32');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?offset=15&api-key=' . $api_key);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_offset_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['offset' => '20', 'api-key' => $api_key];
        $cacheKey = md5(json_encode($requestArray));

        Cache::shouldReceive('has')
            ->once()
            ->with( $cacheKey )
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->once()
            ->with( $cacheKey )
            ->andReturn($data);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/1/best-sellers/history?offset=20&api-key=' . $api_key);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ]);
    }
}
