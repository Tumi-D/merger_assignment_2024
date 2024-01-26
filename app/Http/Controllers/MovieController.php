<?php

namespace App\Http\Controllers;

use App\Exceptions\MovieTitlesServiceUnavailableException;
use App\Services\MoviesTitlesService;
use App\Traits\ApiResponseTrait;

class MovieController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var MoviesTitlesService
     */
    private $moviesTitlesService;

    /**
     * MovieController constructor.
     *
     * @param MoviesTitlesService $movieTitleService
     */
    public function __construct(MoviesTitlesService $moviesTitlesService)
    {
        $this->moviesTitlesService = $moviesTitlesService;
    }
    /**
     * Get movie titles from all external systems and combine them.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTitles()
    {
        try {
            // Get combined movie titles from all external systems
            $titles = $this->moviesTitlesService->getCombinedTitles();
            return $this->successResponse($titles);
        } catch (MovieTitlesServiceUnavailableException $e) {
            return $this->failureResponse();
        }
    }

}
