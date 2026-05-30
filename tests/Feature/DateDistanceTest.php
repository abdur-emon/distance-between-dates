<?php

namespace Tests\Feature;

use App\Services\DateDistanceService;
use Tests\TestCase;

class DateDistanceTest extends TestCase
{
    private DateDistanceService $service;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DateDistanceService();

        // Stub the @vite directive so HTTP tests don't require a built
        // asset manifest (npm run build) to render views.
        $this->withoutVite();
    }
    
    public function test_calculates_future_date_correctly(): void
    {
        $result = $this->service->calculate('2030-01-01', '2025-01-01');
        
        $this->assertEquals(5, $result['years']);
        $this->assertEquals(0, $result['months']);
        $this->assertEquals(0, $result['days']);
        $this->assertEquals('future', $result['direction']);
    }
    
    public function test_calculates_past_date_correctly(): void
    {
        $result = $this->service->calculate('2020-01-01', '2025-01-01');
        
        $this->assertEquals(5, $result['years']);
        $this->assertEquals(0, $result['months']);
        $this->assertEquals(0, $result['days']);
        $this->assertEquals('past', $result['direction']);
    }
    
    public function test_calculates_same_date(): void
    {
        $result = $this->service->calculate('2025-01-01', '2025-01-01');

        $this->assertEquals(0, $result['totalDays']);
        $this->assertEquals('same', $result['direction']);
        $this->assertEquals('Today', $result['humanReadable']);
    }

    public function test_human_readable_includes_direction(): void
    {
        $future = $this->service->calculate('2030-01-01', '2025-01-01');
        $this->assertEquals('5 years from now', $future['humanReadable']);

        $past = $this->service->calculate('2020-01-01', '2025-01-01');
        $this->assertEquals('5 years ago', $past['humanReadable']);
    }

    public function test_direction_is_relative_to_from_not_now(): void
    {
        // Both dates are in the past relative to "today", but target is AFTER from,
        // so the direction must be 'future' (target lies ahead of the origin date).
        $result = $this->service->calculate('2023-01-01', '2020-01-01');

        $this->assertEquals('future', $result['direction']);
        $this->assertEquals('3 years from now', $result['humanReadable']);

        // Symmetric case: target before from => 'past'
        $reverse = $this->service->calculate('2020-01-01', '2023-01-01');

        $this->assertEquals('past', $reverse['direction']);
        $this->assertEquals('3 years ago', $reverse['humanReadable']);
    }

    public function test_multi_component_breakdown(): void
    {
        // Clean case with no month-end overflow: Jan 15 + 2y 3m 5d = Apr 20
        $result = $this->service->calculate('2027-04-20', '2025-01-15');

        $this->assertEquals(2, $result['years']);
        $this->assertEquals(3, $result['months']);
        $this->assertEquals(5, $result['days']);
        $this->assertEquals('future', $result['direction']);
        $this->assertEquals('2 years, 3 months, 5 days from now', $result['humanReadable']);
    }
    
    public function test_calculates_totals_correctly(): void
    {
        $result = $this->service->calculate('2026-01-01', '2025-01-01');
        
        $this->assertEquals(365, $result['totalDays']);
        $this->assertEquals(52.14, $result['totalWeeks']);
        $this->assertEquals(8760, $result['totalHours']);
    }
    
    public function test_validates_dates(): void
    {
        $this->assertTrue($this->service->isValidDate('2025-01-01'));
        $this->assertTrue($this->service->isValidDate('2025-12-31'));
        $this->assertFalse($this->service->isValidDate('invalid-date'));
        $this->assertFalse($this->service->isValidDate('2025-13-01')); // Invalid month
    }
    
    public function test_handles_leap_year(): void
    {
        // 2024 is a leap year
        $result = $this->service->calculate('2025-02-28', '2024-02-28');
        
        $this->assertEquals(1, $result['years']);
        $this->assertEquals(366, $result['totalDays']); // Leap year has 366 days
    }
    
    public function test_calculator_page_loads(): void
    {
        $response = $this->get('/app');

        $response->assertStatus(200);
        $response->assertSee('Distance Between Dates');
        $response->assertSee('Target Date');
    }

    public function test_calculator_page_with_query_params(): void
    {
        $response = $this->get('/app?date=2030-01-01&from=2025-01-01');

        $response->assertStatus(200);
        $response->assertSee('5 years from now');
    }
}

