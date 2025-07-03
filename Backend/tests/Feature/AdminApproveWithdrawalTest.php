<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\SellerProfile;

class AdminApproveWithdrawalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_withdrawal()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create(['role' => 'seller']);
        SellerProfile::factory()->create(['user_id' => $seller->id, 'status' => 'approved']);
        $withdrawal = Withdrawal::factory()->create(['seller_id' => $seller->id, 'status' => 'requested']);

        $response = $this->actingAs($admin)->putJson("/api/withdrawals/{$withdrawal->id}", [
            'action' => 'approve',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_reject_withdrawal()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create(['role' => 'seller']);
        SellerProfile::factory()->create(['user_id' => $seller->id, 'status' => 'approved']);
        $withdrawal = Withdrawal::factory()->create(['seller_id' => $seller->id, 'status' => 'requested']);

        $response = $this->actingAs($admin)->putJson("/api/withdrawals/{$withdrawal->id}", [
            'action' => 'reject',
            'admin_notes' => 'Insufficient funds'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status' => 'rejected',
            'admin_notes' => 'Insufficient funds'
        ]);
    }
}
