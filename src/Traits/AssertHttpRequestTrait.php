<?php

namespace Nox0121\LaravelTestingKit\Traits;

use PHPUnit\Framework\Assert as PHPUnit;

trait AssertHttpRequestTrait
{
    /**
     * Assert that the JSON response has a given structure.
     *
     * @param  array|null  $structure
     * @param  array|null  $responseData
     * @return $this
     */
    public function assertJsonStructure(array $structure = null, $responseData = null)
    {
        if (is_null($structure)) {
            return $this->seeJson();
        }
        if (is_null($responseData)) {
            $responseData = $this->decodeResponseJson();
        }
        foreach ($structure as $key => $value) {
            if (is_array($value) && $key === '*') {
                $this->assertInternalType('array', $responseData);
                foreach ($responseData as $responseDataItem) {
                    $this->assertJsonStructure($structure['*'], $responseDataItem);
                }
            } elseif (is_array($value)) {
                $this->assertArrayHasKey($key, $responseData);
                $this->assertJsonStructure($structure[$key], $responseData[$key]);
            } else {
                $this->assertArrayHasKey($value, $responseData);
            }
        }
        return $this;
    }

    /**
     * Validate and return the decoded response JSON.
     *
     * @return array
     */
    protected function decodeResponseJson()
    {
        $decodedResponse = json_decode($this->response->getContent(), true);
        if (is_null($decodedResponse) || $decodedResponse === false) {
            $this->fail('Invalid JSON was returned from the route. Perhaps an exception was thrown?');
        }
        return $decodedResponse;
    }
}
