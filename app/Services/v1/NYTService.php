<?php
namespace App\Services\v1;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Services\v1\Types\NYTServiceType;

class NYTService
{
    private string $base_url;
    private int $cache_timeout;
    public function __construct()
    {
        $this->base_url = env('API_BASE_URL','https://api.nytimes.com');
        $this->cache_timeout = (int) env('API_CACHE_TIMEOUT',1);
    }

    /**
     * NYT Best Sellers
     * @param array $validatedQueryParams
     * @return NYTServiceType
     */
    public function getBestSellersHistory(array $validatedQueryParams):NYTServiceType
    {
        $path = '/svc/books/v3/lists/best-sellers/history.json';

        $cacheKey = md5(json_encode($validatedQueryParams));
        if (Cache::has($cacheKey)) {
            return new NYTServiceType(json_data:Cache::get($cacheKey));
        }

        //TODO: clarify whether we need to accept array or strings in form request
        //In API description: A best seller may have both 10-digit and 13-digit ISBNs, and may have multiple ISBNs of each type.
        //To search on multiple ISBNs, separate the ISBNs with semicolons (example: 9780446579933;0061374229).
        //And in out task: isbn[] : string. So we accept as array of strings and convert to required format.
        if (isset($validatedQueryParams['isbn']) && is_array($validatedQueryParams['isbn'])) {
            $validatedQueryParams['isbn'] = implode(';',$validatedQueryParams['isbn']);
        }

        $response = Http::get($this->base_url . $path, $validatedQueryParams);

        if ($response->ok()) {
            Cache::put($cacheKey, $response->json(), now()->addMinutes($this->cache_timeout));
        }

        return new NYTServiceType(json_data:$response->json(),http_code: $response->status());
    }
}
