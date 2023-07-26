<?php

namespace AbuseipdbLaravel\Tests;

use AbuseipdbLaravel\Facades\AbuseIPDB;
use AbuseipdbLaravel\Tests\TestCase;

class TestRequests extends TestCase
{

    public function testIlluminateResponseType()
    {
        $response = AbuseIPDB::makeRequest('check', ['ipAddress' => '127.0.0.1']);
        $this->assertInstanceOf(\Illuminate\Http\Client\Response::class, $response);
    }
    public function testCheckResponseType()
    {
        $response = AbuseIPDB::check('127.0.0.1');
        $this->assertInstanceOf(ResponseObjects\CheckResponse::class, $response);
    }
    /* public function testReportResponseType()
    {
    $response = AbuseIPDB::report('127.0.0.2', 21);
    $this->assertInstanceOf(ResponseObjects\ReportResponse::class,$response);
    }  */

    public function testAbuseResponseProperties()
    {
        $response = AbuseIPDB::check('127.0.0.1');
        $this->assertObjecthasProperty('x_ratelimit_limit', $response);
        $this->assertObjecthasProperty('x_ratelimit_remaining', $response);
        $this->assertObjecthasProperty('content_type', $response);
        $this->assertObjecthasProperty('cache_control', $response);
        $this->assertObjecthasProperty('cf_cache_status', $response);
    }
    public function testCheckResponseProperties()
    {
        $response = AbuseIPDB::check('127.0.0.1');
        $this->assertObjectHasProperty('ipAddress', $response);
        $this->assertObjectHasProperty('isPublic', $response);
        $this->assertObjectHasProperty('ipVersion', $response);
        $this->assertObjectHasProperty('isWhitelisted', $response);
        $this->assertObjectHasProperty('abuseConfidenceScore', $response);
        $this->assertObjectHasProperty('countryCode', $response);
        $this->assertObjectHasProperty('usageType', $response);
        $this->assertObjectHasProperty('isp', $response);
        $this->assertObjectHasProperty('domain', $response);
        $this->assertObjectHasProperty('hostnames', $response);
        $this->assertObjectHasProperty('isTor', $response);
        $this->assertObjectHasProperty('totalReports', $response);
        $this->assertObjectHasProperty('numDistinctUsers', $response);
        $this->assertObjectHasProperty('lastReportedAt', $response);
        $this->assertObjectHasProperty('countryName', $response);
        $this->assertObjectHasProperty('reports', $response);

    }

    public function testCheckResponseWithoutVerbose()
    {
        $response = AbuseIPDB::check('154.198.211.170');
        $this->assertEmpty($response->reports);
        $this->assertEmpty($response->countryName);
    }

//testing with real ip, testing with 127.0.0.1 will not have a countryName
    public function testCheckResponseWithVerbose()
    {
        $response = AbuseIPDB::check('154.198.211.170', verbose: 1);
        $this->assertNotEmpty($response->reports);
        $this->assertNotEmpty($response->countryName);
    }

}
