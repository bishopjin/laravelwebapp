<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\InventoryEmployeeLog;

class InventoryAppTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function makeUser()
    {
        $user = User::factory()->make();
        return $user;
    }

    public function test_app_home()
    {
        $response = $this->actingAs($this->makeUser())->get('/');
        $response->assertOk();
    }

    public function test_inventory_get_dashboard()
    {
        $response = $this->actingAs($this->makeUser())->get('/inventory/1');
        $response->assertRedirect('/inventory/');
    }
    /* test get product */
    public function test_inventory_get_product_order()
    {
        $response = $this->actingAs($this->makeUser())->get('/inventory/product/order');
        if ($response->assertOk())
        {
            $response->assertViewIs('inventory.product.order');
        }
    }
    public function test_inventory_get_product_deliver()
    {
        $response = $this->actingAs($this->makeUser())->get('inventory/product/deliver');
        if ($response->assertOk()) {
            $response->assertViewIs('inventory.product.receive');
        }
    }
    public function test_inventory_get_product_add()
    {
        $this->WithoutMiddleware(\App\Http\Middleware\CheckAccessLevelInventory::class);
        $response = $this->actingAs($this->makeUser())->get('/inventory/product/add');
        if ($response->assertOk())
        {
            $response->assertViewIs('inventory.product.add');
        }
    }
    public function test_inventory_get_product_view()
    {
        $this->WithoutMiddleware(\App\Http\Middleware\CheckAccessLevelInventory::class);
        $response = $this->actingAs($this->makeUser())->get('/inventory/product/view/1');

        if ($response->assertOk())
        {
            $response->assertViewIs('inventory.product.view');
        }
    }
    /* test get employee */
    public function test_inventory_get_employee_show()
    {
        $this->WithoutMiddleware(\App\Http\Middleware\CheckAccessLevelInventory::class);
        $response = $this->actingAs($this->makeUser())->get('/inventory/employee/show');
        if ($response->assertOk())
        {
            $response->assertViewIs('inventory.employee.index');
        }
    }
    public function test_inventory_get_employee_edit()
    {
        $this->WithoutMiddleware(\App\Http\Middleware\CheckAccessLevelInventory::class);
        $response = $this->actingAs($this->makeUser())->get('inventory/employee/edit');
        if ($response->assertOk()) 
        {
            $response->assertViewIs('inventory.employee.edit');
        }
    }
    public function test_inventory_get_employee_edit_access()
    {
        $this->WithoutMiddleware(\App\Http\Middleware\CheckAccessLevelInventory::class);
        $response = $this->actingAs($this->makeUser())->get('/inventory/employee/edit/access/1');
        if ($response->assertOk()) 
        {
            $response->assertViewIs('inventory.employee.editaccess');
        }
    }
}
