<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetRouteIndexTest extends TestCase
{

    public function test_mobile_index()
    {
        $response = $this->get('/');
        $response->assertSuccessful();
    }

    public function test_mobile_detail()
    {
        $response = $this->get('/detail?event_id=1');
        $response->assertSuccessful();
    }

    public function test_mobile_getCaptcha()
    {
        $response = $this->get('/getCaptcha');
        $response->assertSuccessful();
    }
}
