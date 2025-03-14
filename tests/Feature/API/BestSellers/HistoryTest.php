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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&author=');

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_author_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['api-key' => $api_key, 'author' => 'abc'];
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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&author=abc');

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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&isbn[]=123');

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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&isbn[]=0871404427');

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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&title=');

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_title_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['api-key' => $api_key, 'title' => 'Til Faith Do Us Part: How Interfaith Marriage'];
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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&title=Til Faith Do Us Part: How Interfaith Marriage');

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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&offset=15');

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_best_sellers_history_api_offset_validation_success_endpoint(): void
    {
        $api_key = Str::random('32');

        $data = json_decode(file_get_contents(__DIR__ . '/resources/best_sellers_history_test_data.json'),true);
        $requestArray = ['api-key' => $api_key, 'offset' => '20'];
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
        ])->get('/api/1/best-sellers/history?api-key=' . $api_key. '&offset=20');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ]);
    }
}
