<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayrollCalculatorEndpointTest extends TestCase
{
    public function test_returns_success_with_valid_inputs(): void
    {
        $response = $this->post(route('payday.calculate'), ['year' => 2025, 'month' => 1]);

        $response->assertStatus(200);
    }

    public function test_returns_unprocessible_entity_with_invalid_year(): void
    {
        $response = $this->postJson(route('payday.calculate'), ['year' => 2024, 'month' => 1]);

        $response->assertStatus(422);
    }    

    public function test_returns_unprocessible_entity_with_invalid_month(): void
    {
        $response = $this->postJson(route('payday.calculate'), ['year' => 2025, 'month' => 13]);

        $response->assertStatus(422);
    }     
}
