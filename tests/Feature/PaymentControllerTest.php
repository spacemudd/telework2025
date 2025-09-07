<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Mockery;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock the NoonPayment facade
        $this->mockNoonPayment();
    }

    protected function mockNoonPayment()
    {
        // Mock the NoonPayment facade
        $this->mock('CodeBugLab\NoonPayment\NoonPayment', function ($mock) {
            $mock->shouldReceive('getInstance')->andReturnSelf();
        });
    }

    public function test_initiate_subscription_requires_authentication()
    {
        $response = $this->postJson('/payment/subscription/initiate', [
            'plan_type' => '3_months'
        ]);

        $response->assertStatus(401);
    }

    public function test_initiate_subscription_validates_plan_type()
    {
        $user = User::factory()->create();
        
        // Mock NoonPayment to prevent actual API calls during validation
        $this->mock('CodeBugLab\NoonPayment\NoonPayment', function ($mock) {
            $mock->shouldReceive('getInstance')->andReturnSelf();
        });
        
        $response = $this->actingAs($user)->postJson('/payment/subscription/initiate', [
            'plan_type' => 'invalid_plan'
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['plan_type']);
    }

    public function test_initiate_subscription_success()
    {
        $user = User::factory()->create();
        
        // Mock successful Noon payment response
        $mockResponse = (object) [
            'resultCode' => 0,
            'result' => (object) [
                'checkoutData' => (object) [
                    'postUrl' => 'https://test.noonpayments.com/checkout/123'
                ]
            ]
        ];

        $this->mock('CodeBugLab\NoonPayment\NoonPayment', function ($mock) use ($mockResponse) {
            $mock->shouldReceive('getInstance')->andReturnSelf();
            $mock->shouldReceive('initiate')->andReturn($mockResponse);
        });

        $response = $this->actingAs($user)->postJson('/payment/subscription/initiate', [
            'plan_type' => '3_months'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'payment_url' => 'https://test.noonpayments.com/checkout/123'
                ]);

        // Check session data
        $this->assertNotNull(session('noon_payment_reference'));
        $this->assertEquals('3_months', session('noon_payment_plan'));
        $this->assertEquals($user->id, session('noon_payment_user_id'));
    }

    public function test_initiate_subscription_failure()
    {
        $user = User::factory()->create();
        
        // Mock failed Noon payment response
        $mockResponse = (object) [
            'resultCode' => 1,
            'result' => null
        ];

        $this->mock('CodeBugLab\NoonPayment\NoonPayment', function ($mock) use ($mockResponse) {
            $mock->shouldReceive('getInstance')->andReturnSelf();
            $mock->shouldReceive('initiate')->andReturn($mockResponse);
        });

        $response = $this->actingAs($user)->postJson('/payment/subscription/initiate', [
            'plan_type' => '3_months'
        ]);

        $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                    'message' => 'Payment initiation failed. Please try again.'
                ]);
    }

    public function test_handle_callback_success()
    {
        $user = User::factory()->create();
        
        // Set session data
        Session::put([
            'noon_payment_reference' => 'SUB_123_456',
            'noon_payment_plan' => '3_months',
            'noon_payment_user_id' => $user->id
        ]);

        // Mock successful order details
        $mockResponse = (object) [
            'resultCode' => 0,
            'result' => (object) [
                'transactions' => [
                    (object) [
                        'type' => 'SALE',
                        'status' => 'SUCCESS',
                        'id' => 'txn_123'
                    ]
                ]
            ]
        ];

        $this->mock('CodeBugLab\NoonPayment\NoonPayment', function ($mock) use ($mockResponse) {
            $mock->shouldReceive('getInstance')->andReturnSelf();
            $mock->shouldReceive('getOrder')->andReturn($mockResponse);
        });

        $response = $this->get('/payment/noon/callback?orderId=order_123');

        $response->assertRedirect(route('employee.dashboard'))
                ->assertSessionHas('success');

        // Check user subscription was activated
        $user->refresh();
        $this->assertTrue($user->subscription_active);
        $this->assertEquals('3_months', $user->subscription_plan);
        $this->assertNotNull($user->subscription_ends_at);
    }

    public function test_handle_callback_payment_failed()
    {
        $user = User::factory()->create();
        
        // Set session data
        Session::put([
            'noon_payment_reference' => 'SUB_123_456',
            'noon_payment_plan' => '3_months',
            'noon_payment_user_id' => $user->id
        ]);

        // Mock failed payment
        $mockResponse = (object) [
            'resultCode' => 0,
            'result' => (object) [
                'transactions' => [
                    (object) [
                        'type' => 'SALE',
                        'status' => 'FAILED',
                        'id' => 'txn_123'
                    ]
                ]
            ]
        ];

        $this->mock('CodeBugLab\NoonPayment\NoonPayment', function ($mock) use ($mockResponse) {
            $mock->shouldReceive('getInstance')->andReturnSelf();
            $mock->shouldReceive('getOrder')->andReturn($mockResponse);
        });

        $response = $this->get('/payment/noon/callback?orderId=order_123');

        $response->assertRedirect(route('employee.dashboard'))
                ->assertSessionHas('error');

        // Check user subscription was not activated
        $user->refresh();
        $this->assertFalse($user->subscription_active);
    }

    public function test_handle_callback_invalid_session_data()
    {
        $response = $this->get('/payment/noon/callback?orderId=order_123');

        $response->assertRedirect(route('employee.dashboard'))
                ->assertSessionHas('error', 'Invalid payment callback data.');
    }

    public function test_check_subscription_status_requires_authentication()
    {
        $response = $this->getJson('/payment/subscription/status');

        $response->assertStatus(401);
    }

    public function test_check_subscription_status_active()
    {
        $user = User::factory()->create([
            'subscription_active' => true,
            'subscription_plan' => '3_months',
            'subscription_ends_at' => now()->addMonths(3)
        ]);

        $response = $this->actingAs($user)->getJson('/payment/subscription/status');

        $response->assertStatus(200)
                ->assertJson([
                    'active' => true,
                    'plan' => '3_months',
                    'expired' => false
                ]);
    }

    public function test_check_subscription_status_expired()
    {
        $user = User::factory()->create([
            'subscription_active' => true,
            'subscription_plan' => '3_months',
            'subscription_ends_at' => now()->subDays(1)
        ]);

        $response = $this->actingAs($user)->getJson('/payment/subscription/status');

        $response->assertStatus(200)
                ->assertJson([
                    'active' => false,
                    'plan' => '3_months',
                    'expired' => true
                ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
