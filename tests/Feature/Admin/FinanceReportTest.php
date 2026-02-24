<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceReportTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_access_finance_report()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.finance-report'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.finance.index');
    }

    public function test_finance_report_calculations()
    {
        // Create 2 paid orders
        Order::create([
            'user_id' => $this->admin->id,
            'order_number' => 'ORD-001',
            'status' => 'completed',
            'total' => 100000,
            'shipping_name' => 'Test',
            'shipping_phone' => '0812',
            'shipping_address' => 'Test Address',
            'shipping_city' => 'Test City',
            'shipping_province' => 'Test Prov',
            'shipping_zip' => '12345',
            'shipping_cost' => 0,
        ]);

        Order::create([
            'user_id' => $this->admin->id,
            'order_number' => 'ORD-002',
            'status' => 'processing',
            'total' => 200000,
            'shipping_name' => 'Test',
            'shipping_phone' => '0812',
            'shipping_address' => 'Test Address',
            'shipping_city' => 'Test City',
            'shipping_province' => 'Test Prov',
            'shipping_zip' => '12345',
            'shipping_cost' => 0,
        ]);

        // Create 1 unpaid/cancelled order (should be ignored)
        Order::create([
            'user_id' => $this->admin->id,
            'order_number' => 'ORD-003',
            'status' => 'waiting-payment',
            'total' => 50000,
            'shipping_name' => 'Test',
            'shipping_phone' => '0812',
            'shipping_address' => 'Test Address',
            'shipping_city' => 'Test City',
            'shipping_province' => 'Test Prov',
            'shipping_zip' => '12345',
            'shipping_cost' => 0,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.finance-report'));

        $response->assertStatus(200);

        // Money In should be 100,000 + 200,000 = 300,000
        $response->assertViewHas('moneyIn', 300000);

        // Profit should be 20% of 300,000 = 60,000
        $response->assertViewHas('profit', 60000);

        // Money Out should be 80% of 300,000 = 240,000
        $response->assertViewHas('moneyOut', 240000);
    }
}
