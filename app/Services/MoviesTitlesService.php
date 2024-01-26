<?php
namespace App\Services;

use App\Exceptions\MovieTitlesServiceUnavailableException;

class MoviesTitlesService
{
    /**
     * Get titles from an external system and handle service unavailable exception.
     *
     * @param callable $externalService
     * @return mixed
     * @throws MovieTitlesServiceUnavailableException
     */
    public function getTitlesFromExternalSystem(callable $externalService)
    {
        try {
            return $externalService();
        } catch (\External\Foo\Exceptions\ServiceUnavailableException |
            \External\Bar\Exceptions\ServiceUnavailableException |
            \External\Baz\Exceptions\ServiceUnavailableException $e) {
            throw new MovieTitlesServiceUnavailableException('Service Unavailable', null, $e);
        }
    }

    /**
     * Get combined movie titles from all external systems.
     *
     * @return array
     * @throws MovieTitlesServiceUnavailableException
     */
    public function getCombinedTitles()
    {
        $cacheKey = 'titles_service_cache';
        // Check if the data is already in the cache
        if (\Cache::has($cacheKey)) {
            // Retrieve data from the cache
            return \Cache::get($cacheKey);
        }
        $fooTitles = $this->getTitlesFromExternalSystem(function () {
            return (new \External\Foo\Movies\MovieService())->getTitles();
        });
        $barTitles = $this->getTitlesFromExternalSystem(function () {
            $titlesArray = (new \External\Bar\Movies\MovieService())->getTitles();
            $titles = isset($titlesArray['titles']) ? $titlesArray['titles'] : [];
            $titleList = array_map(function ($titleInfo) {
                // Check if 'title' key exists in the current element
                return isset($titleInfo['title']) ? $titleInfo['title'] : null;
            }, $titles);
            // Filter out null values
            $titleList = array_filter($titleList);
            return $titleList;
        });
        $bazTitles = $this->getTitlesFromExternalSystem(function () {
            $titlesArray = (new \External\Baz\Movies\MovieService())->getTitles();
            $titleList = isset($titlesArray['titles']) ? $titlesArray['titles'] : [];
            return $titleList;
        });
        $combinedTitles = array_merge($fooTitles, $barTitles, $bazTitles);
        // Store the combined titles in the cache for 30 minutes
        \Cache::put($cacheKey, $combinedTitles, now()->addMinutes(30));
        // Return the combined titles
        return $combinedTitles;
    }

}
