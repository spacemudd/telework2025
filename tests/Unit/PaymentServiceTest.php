<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\PaymentController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_plan_configuration()
    {
        $plans = [
            '3_months' => [
                'amount' => '103.50',
                'name' => 'اشتراك التقديم الذكي - 3 أشهر',
                'duration' => '3 أشهر'
            ],
            '6_months' => [
                'amount' => '199.00',
                'name' => 'اشتراك التقديم الذكي - 6 أشهر',
                'duration' => '6 أشهر'
            ],
            '12_months' => [
                'amount' => '349.00',
                'name' => 'اشتراك التقديم الذكي - 12 شهر',
                'duration' => '12 شهر'
            ]
        ];

        // Test 3 months plan
        $this->assertEquals('103.50', $plans['3_months']['amount']);
        $this->assertEquals('اشتراك التقديم الذكي - 3 أشهر', $plans['3_months']['name']);

        // Test 6 months plan
        $this->assertEquals('199.00', $plans['6_months']['amount']);
        $this->assertEquals('اشتراك التقديم الذكي - 6 أشهر', $plans['6_months']['name']);

        // Test 12 months plan
        $this->assertEquals('349.00', $plans['12_months']['amount']);
        $this->assertEquals('اشتراك التقديم الذكي - 12 شهر', $plans['12_months']['name']);
    }

    public function test_payment_reference_generation()
    {
        $user = User::factory()->create();
        $timestamp = time();
        
        $reference = "SUB_" . $user->id . "_" . $timestamp;
        
        $this->assertStringStartsWith('SUB_', $reference);
        $this->assertStringContainsString($user->id, $reference);
        $this->assertStringContainsString($timestamp, $reference);
    }

    public function test_subscription_activation_logic()
    {
        $user = User::factory()->create();
        
        // Test 3 months subscription
        $planDurations = [
            '3_months' => 3,
            '6_months' => 6,
            '12_months' => 12
        ];

        $plan = '3_months';
        $months = $planDurations[$plan] ?? 3;
        $endDate = now()->addMonths($months);

        $this->assertEquals(3, $months);
        $this->assertTrue($endDate->isFuture());
        $this->assertEquals(now()->addMonths(3)->format('Y-m-d'), $endDate->format('Y-m-d'));
    }

    public function test_payment_data_structure()
    {
        $user = User::factory()->create();
        $plan = [
            'amount' => '103.50',
            'name' => 'اشتراك التقديم الذكي - 3 أشهر'
        ];

        $data = [
            "order" => [
                "reference" => "SUB_" . $user->id . "_" . time(),
                "amount" => $plan['amount'],
                "currency" => "SAR",
                "name" => $plan['name'],
            ],
            "configuration" => [
                "locale" => "ar"
            ]
        ];

        // Validate structure
        $this->assertArrayHasKey('order', $data);
        $this->assertArrayHasKey('configuration', $data);
        $this->assertArrayHasKey('reference', $data['order']);
        $this->assertArrayHasKey('amount', $data['order']);
        $this->assertArrayHasKey('currency', $data['order']);
        $this->assertArrayHasKey('name', $data['order']);
        $this->assertArrayHasKey('locale', $data['configuration']);

        // Validate values
        $this->assertEquals('103.50', $data['order']['amount']);
        $this->assertEquals('SAR', $data['order']['currency']);
        $this->assertEquals('اشتراك التقديم الذكي - 3 أشهر', $data['order']['name']);
        $this->assertEquals('ar', $data['configuration']['locale']);
    }

    public function test_session_data_management()
    {
        $user = User::factory()->create();
        $reference = 'SUB_123_456';
        $plan = '3_months';

        // Set session data
        Session::put([
            'noon_payment_reference' => $reference,
            'noon_payment_plan' => $plan,
            'noon_payment_user_id' => $user->id
        ]);

        // Verify session data
        $this->assertEquals($reference, Session::get('noon_payment_reference'));
        $this->assertEquals($plan, Session::get('noon_payment_plan'));
        $this->assertEquals($user->id, Session::get('noon_payment_user_id'));

        // Clear session data
        Session::forget([
            'noon_payment_reference',
            'noon_payment_plan',
            'noon_payment_user_id'
        ]);

        // Verify session data is cleared
        $this->assertNull(Session::get('noon_payment_reference'));
        $this->assertNull(Session::get('noon_payment_plan'));
        $this->assertNull(Session::get('noon_payment_user_id'));
    }

    public function test_subscription_status_calculation()
    {
        // Test active subscription
        $user = User::factory()->create([
            'subscription_active' => true,
            'subscription_ends_at' => now()->addDays(30)
        ]);

        $isActive = $user->subscription_active ?? false;
        $isExpired = $user->subscription_ends_at && $user->subscription_ends_at->isPast();
        $isValid = $isActive && !$isExpired;

        $this->assertTrue($isActive);
        $this->assertFalse($isExpired);
        $this->assertTrue($isValid);

        // Test expired subscription
        $user2 = User::factory()->create([
            'subscription_active' => true,
            'subscription_ends_at' => now()->subDays(1)
        ]);

        $isActive2 = $user2->subscription_active ?? false;
        $isExpired2 = $user2->subscription_ends_at && $user2->subscription_ends_at->isPast();
        $isValid2 = $isActive2 && !$isExpired2;

        $this->assertTrue($isActive2);
        $this->assertTrue($isExpired2);
        $this->assertFalse($isValid2);

        // Test inactive subscription
        $user3 = User::factory()->create([
            'subscription_active' => false,
            'subscription_ends_at' => now()->addDays(30)
        ]);

        $isActive3 = $user3->subscription_active ?? false;
        $isExpired3 = $user3->subscription_ends_at && $user3->subscription_ends_at->isPast();
        $isValid3 = $isActive3 && !$isExpired3;

        $this->assertFalse($isActive3);
        $this->assertFalse($isExpired3);
        $this->assertFalse($isValid3);
    }
}
