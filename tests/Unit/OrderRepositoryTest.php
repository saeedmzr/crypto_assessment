<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Models\Order;
use App\Models\Rate;
use App\Repositories\CurrencyRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RateRepository;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $orderRepository;
    private $currencyRepository;
    private $rateRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = new OrderRepository(new Order());
        $this->currencyRepository = new CurrencyRepository(new Currency());
        $this->rateRepository = new RateRepository(new Rate());
    }

    public function test_get_order_by_its_tracking_code()
    {

        Order::factory()->count(10)->create();
        $customerExceptedCount = $customerService->getCustomers()->count();
        $customerActualCount = Customer::all()->count();
        $this->assertEquals($customerExceptedCount, $customerActualCount);
    }

    /** @test */
    public function get_customer_by_id_works()
    {
        $customerService = new CustomerService();
        $customerCreated = Customer::factory()->create();
        $customerExcepted = $customerService->getCustomerById(["customerId" => $customerCreated->id]);
        $customerActual = Customer::find($customerCreated->id);
        $this->assertEquals($customerExcepted, $customerActual);
    }

    /** @test */
    public function create_customer_works()
    {
        $customerService = new CustomerService();
        $faker = Faker::create();

        $payload = [
            "Firstname" => $faker->firstName,
            "Lastname" => $faker->lastName,
            "DateOfBirth" => $faker->date($format = 'Y-m-d', $max = 'now'),
            "Email" => $faker->email,
            "PhoneNumber" => $faker->phoneNumber,
            "BankAccountNumber" => $faker->bankAccountNumber,
        ];
        $customerCreated = $customerService->createCustomer($payload);
        $customer = Customer::find($customerCreated->id);

        $this->assertNotNull($customer);
    }

    /** @test */
    public function update_customer_works()
    {
        $customerService = new CustomerService();
        $faker = Faker::create();
        $customerCreated = Customer::factory()->create();
        $firstname = $faker->firstName;
        $payload = [
            "Firstname" => $firstname,
            "Lastname" => $faker->lastName,
            "DateOfBirth" => $faker->date($format = 'Y-m-d', $max = 'now'),
            "Email" => $faker->email,
            "PhoneNumber" => $faker->phoneNumber,
            "BankAccountNumber" => $faker->bankAccountNumber,
        ];
        $customerService->updateCustomer($payload, $customerCreated->id);
        $customerUpdated = Customer::find($customerCreated->id);

        $this->assertEquals($customerUpdated->Firstname, $firstname);
    }

    /** @test */

    public function delete_customer_works()
    {
        $customerService = new CustomerService();
        $customerCreated = Customer::factory()->create();

        $customerService->deleteCustomer($customerCreated->id);
        $customerDeleted = Customer::find($customerCreated->id);
        $this->assertNull($customerDeleted);
    }

