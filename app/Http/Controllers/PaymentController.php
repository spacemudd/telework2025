<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use CodeBugLab\NoonPayment\NoonPayment;

class PaymentController extends Controller
{
    /**
     * Initiate subscription payment
     */
    public function initiateSubscription(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Validate request
            $request->validate([
                'plan_type' => 'required|string|in:3_months,6_months,12_months'
            ]);

            // Define subscription plans
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

            $selectedPlan = $plans[$request->plan_type];
            
            // Prepare payment data
            $data = [
                "order" => [
                    "reference" => "SUB_" . $user->id . "_" . time(),
                    "amount" => $selectedPlan['amount'],
                    "currency" => "SAR",
                    "name" => $selectedPlan['name'],
                ],
                "configuration" => [
                    "locale" => app()->getLocale() === 'ar' ? 'ar' : 'en'
                ]
            ];

            // Initiate payment with Noon
            $response = NoonPayment::getInstance()->initiate($data);

            if ($response->resultCode == 0) {
                // Store payment reference in session for tracking
                session([
                    'noon_payment_reference' => $data['order']['reference'],
                    'noon_payment_plan' => $request->plan_type,
                    'noon_payment_user_id' => $user->id
                ]);
                
                Log::info('Noon payment initiated successfully', [
                    'user_id' => $user->id,
                    'reference' => $data['order']['reference'],
                    'amount' => $selectedPlan['amount'],
                    'plan' => $request->plan_type
                ]);
                
                return response()->json([
                    'success' => true,
                    'payment_url' => $response->result->checkoutData->postUrl,
                    'reference' => $data['order']['reference']
                ]);
            } else {
                Log::error('Noon payment initiation failed', [
                    'user_id' => $user->id,
                    'response' => $response
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Payment initiation failed. Please try again.'
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Payment initiation error', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your payment. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle Noon payment callback
     */
    public function handleCallback(Request $request)
    {
        try {
            $orderId = $request->get('orderId');
            $reference = session('noon_payment_reference');
            $plan = session('noon_payment_plan');
            $userId = session('noon_payment_user_id');

            if (!$orderId || !$reference || !$plan || !$userId) {
                Log::warning('Invalid payment callback data', [
                    'orderId' => $orderId,
                    'reference' => $reference,
                    'plan' => $plan,
                    'userId' => $userId
                ]);
                
                return redirect()->route('employee.dashboard')
                    ->with('error', 'Invalid payment callback data.');
            }

            // Get order details from Noon
            $response = NoonPayment::getInstance()->getOrder($orderId);

            if ($response->resultCode == 0) {
                $transaction = $response->result->transactions[0] ?? null;
                
                if ($transaction && 
                    $transaction->type == "SALE" && 
                    $transaction->status == "SUCCESS") {
                    
                    // Payment successful - activate subscription
                    $this->activateSubscription($userId, $plan, $reference, $transaction);
                    
                    // Clear session data
                    session()->forget([
                        'noon_payment_reference',
                        'noon_payment_plan', 
                        'noon_payment_user_id'
                    ]);
                    
                    Log::info('Payment successful', [
                        'user_id' => $userId,
                        'plan' => $plan,
                        'reference' => $reference,
                        'transaction_id' => $transaction->id ?? null
                    ]);
                    
                    return redirect()->route('employee.dashboard')
                        ->with('success', 'تم تفعيل الاشتراك بنجاح! مرحباً بك في خدمة التقديم الذكي.');
                } else {
                    Log::warning('Payment failed or cancelled', [
                        'user_id' => $userId,
                        'plan' => $plan,
                        'reference' => $reference,
                        'transaction_status' => $transaction->status ?? 'unknown'
                    ]);
                    
                    return redirect()->route('employee.dashboard')
                        ->with('error', 'فشل في معالجة الدفع. يرجى المحاولة مرة أخرى.');
                }
            } else {
                Log::error('Failed to get order details from Noon', [
                    'user_id' => $userId,
                    'orderId' => $orderId,
                    'response' => $response
                ]);
                
                return redirect()->route('employee.dashboard')
                    ->with('error', 'فشل في التحقق من حالة الدفع. يرجى التواصل مع الدعم الفني.');
            }

        } catch (\Exception $e) {
            Log::error('Payment callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->route('employee.dashboard')
                ->with('error', 'حدث خطأ أثناء معالجة الدفع. يرجى التواصل مع الدعم الفني.');
        }
    }

    /**
     * Activate user subscription
     */
    private function activateSubscription($userId, $plan, $reference, $transaction)
    {
        try {
            $user = \App\Models\User::find($userId);
            
            if (!$user) {
                throw new \Exception("User not found: {$userId}");
            }

            // Calculate subscription end date based on plan
            $planDurations = [
                '3_months' => 3,
                '6_months' => 6,
                '12_months' => 12
            ];

            $months = $planDurations[$plan] ?? 3;
            $endDate = now()->addMonths($months);

            // Update user subscription (you may need to add subscription fields to users table)
            $user->update([
                'subscription_active' => true,
                'subscription_plan' => $plan,
                'subscription_started_at' => now(),
                'subscription_ends_at' => $endDate,
                'last_payment_reference' => $reference,
                'last_payment_date' => now()
            ]);

            Log::info('Subscription activated', [
                'user_id' => $userId,
                'plan' => $plan,
                'end_date' => $endDate->toDateString()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to activate subscription', [
                'user_id' => $userId,
                'plan' => $plan,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Check subscription status
     */
    public function checkSubscriptionStatus(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $isActive = $user->subscription_active ?? false;
        $plan = $user->subscription_plan ?? null;
        $endsAt = $user->subscription_ends_at ?? null;
        $isExpired = $endsAt && $endsAt->isPast();

        return response()->json([
            'active' => $isActive && !$isExpired,
            'plan' => $plan,
            'ends_at' => $endsAt?->toDateString(),
            'expired' => $isExpired
        ]);
    }
}
