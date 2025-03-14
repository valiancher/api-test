<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BestSellers\History;
use App\Services\v1\NYTService;
use Illuminate\Http\JsonResponse;

class BestSellers extends Controller
{
    private NYTService $NYTService;
    public function __construct(NYTService $NYTService)
    {
        $this->NYTService = $NYTService;
    }

    /**
     * NYT Best Sellers
     * @param History $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(History $request):JsonResponse {
        $data = $this->NYTService->getBestSellersHistory($request->validated());

        return response()->json($data->json_data,$data->http_code);
    }
}
