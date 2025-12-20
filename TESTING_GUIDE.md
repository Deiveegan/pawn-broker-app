# TESTING GUIDE

## 🧪 Pawn Broker Application - Testing Documentation

**Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**Testing Framework**: PHPUnit, Laravel Dusk

---

## 📋 Table of Contents

1. [Testing Overview](#testing-overview)
2. [Setup Testing Environment](#setup-testing-environment)
3. [Unit Tests](#unit-tests)
4. [Feature Tests](#feature-tests)
5. [Browser Tests](#browser-tests)
6. [Manual Testing](#manual-testing)
7. [Test Data](#test-data)
8. [CI/CD Integration](#cicd-integration)

---

## Testing Overview

### Testing Strategy

The application uses a multi-layered testing approach:

1. **Unit Tests**: Test individual components (models, services)
2. **Feature Tests**: Test HTTP endpoints and business logic
3. **Browser Tests**: Test user interface and workflows
4. **Manual Tests**: Test complete user scenarios

### Test Coverage Goals

- **Models**: 80%+ coverage
- **Controllers**: 70%+ coverage
- **Services**: 90%+ coverage
- **Overall**: 75%+ coverage

---

## Setup Testing Environment

### 1. Install Dependencies

```bash
composer require --dev phpunit/phpunit
composer require --dev laravel/dusk
```

### 2. Configure Test Database

Edit `phpunit.xml`:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <env name="CACHE_DRIVER" value="array"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="QUEUE_DRIVER" value="sync"/>
</php>
```

### 3. Initialize Dusk (Browser Testing)

```bash
php artisan dusk:install
```

### 4. Run Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/CustomerTest.php

# Run with coverage
php artisan test --coverage

# Run browser tests
php artisan dusk
```

---

## Unit Tests

### Model Tests

#### CustomerTest.php

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_customer_code_on_creation()
    {
        $customer = Customer::factory()->create();
        
        $this->assertNotNull($customer->customer_code);
        $this->assertStringStartsWith('CUST-', $customer->customer_code);
    }

    /** @test */
    public function it_has_many_loans()
    {
        $customer = Customer::factory()->create();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Collection::class,
            $customer->loans
        );
    }

    /** @test */
    public function it_validates_mobile_number_format()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        
        Customer::factory()->create([
            'mobile' => '123' // Invalid
        ]);
    }
}
```

#### LoanTest.php

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_ticket_number_on_creation()
    {
        $loan = Loan::factory()->create();
        
        $this->assertNotNull($loan->ticket_number);
        $this->assertStringStartsWith('PB-', $loan->ticket_number);
    }

    /** @test */
    public function it_belongs_to_customer()
    {
        $loan = Loan::factory()->create();
        
        $this->assertInstanceOf(Customer::class, $loan->customer);
    }

    /** @test */
    public function it_calculates_outstanding_principal()
    {
        $loan = Loan::factory()->create([
            'principal_amount' => 10000,
            'total_amount_paid' => 2000
        ]);
        
        $this->assertEquals(8000, $loan->outstanding_principal);
    }

    /** @test */
    public function it_detects_overdue_status()
    {
        $loan = Loan::factory()->create([
            'due_date' => now()->subDays(5),
            'status' => 'Active'
        ]);
        
        $this->assertTrue($loan->isOverdue());
    }
}
```

### Service Tests

#### InterestCalculationServiceTest.php

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\InterestCalculationService;
use App\Models\Loan;

class InterestCalculationServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new InterestCalculationService();
    }

    /** @test */
    public function it_calculates_flat_interest_correctly()
    {
        $principal = 10000;
        $rate = 2; // 2% per month
        $days = 30;
        
        $interest = $this->service->calculateFlatInterest(
            $principal, 
            $rate, 
            $days
        );
        
        $this->assertEquals(200, $interest);
    }

    /** @test */
    public function it_calculates_reducing_interest_correctly()
    {
        $outstanding = 7500;
        $rate = 2;
        $days = 30;
        
        $interest = $this->service->calculateReducingInterest(
            $outstanding,
            $rate,
            $days
        );
        
        $this->assertEquals(150, $interest);
    }

    /** @test */
    public function it_calculates_penalty_after_grace_period()
    {
        $loan = Loan::factory()->create([
            'due_date' => now()->subDays(15),
            'grace_period_days' => 7,
            'penalty_rate' => 1,
            'outstanding_principal' => 10000
        ]);
        
        $penalty = $this->service->calculatePenalty($loan);
        
        // 8 days overdue (15 - 7 grace)
        // (10000 * 0.01 * 8) / 30 = 26.67
        $this->assertEquals(26.67, round($penalty, 2));
    }
}
```

---

## Feature Tests

### Customer Feature Tests

#### CustomerControllerTest.php

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_customers_list()
    {
        $this->actingAs($this->user)
            ->get('/customers')
            ->assertStatus(200)
            ->assertViewIs('customers.index');
    }

    /** @test */
    public function guest_cannot_view_customers_list()
    {
        $this->get('/customers')
            ->assertRedirect('/login');
    }

    /** @test */
    public function user_can_create_customer()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->user)->post('/customers', [
            'name' => 'John Doe',
            'mobile' => '9876543210',
            'address' => '123 Main St',
            'city' => 'Chennai',
            'state' => 'Tamil Nadu',
            'pincode' => '600001',
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => '123456789012',
            'photo' => UploadedFile::fake()->image('customer.jpg')
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'mobile' => '9876543210'
        ]);
    }

    /** @test */
    public function customer_creation_validates_required_fields()
    {
        $response = $this->actingAs($this->user)->post('/customers', []);

        $response->assertSessionHasErrors(['name', 'mobile', 'address']);
    }

    /** @test */
    public function customer_creation_validates_mobile_format()
    {
        $response = $this->actingAs($this->user)->post('/customers', [
            'name' => 'John Doe',
            'mobile' => '123', // Invalid
            'address' => '123 Main St',
            'city' => 'Chennai',
            'state' => 'Tamil Nadu',
            'pincode' => '600001',
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => '123456789012'
        ]);

        $response->assertSessionHasErrors('mobile');
    }

    /** @test */
    public function user_can_update_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->actingAs($this->user)->put("/customers/{$customer->id}", [
            'name' => 'Updated Name',
            'mobile' => $customer->mobile,
            'address' => $customer->address,
            'city' => $customer->city,
            'state' => $customer->state,
            'pincode' => $customer->pincode,
            'id_proof_type' => $customer->id_proof_type,
            'id_proof_number' => $customer->id_proof_number
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Name'
        ]);
    }

    /** @test */
    public function user_can_delete_customer_without_loans()
    {
        $customer = Customer::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete("/customers/{$customer->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id
        ]);
    }
}
```

### Loan Feature Tests

#### LoanControllerTest.php

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function user_can_create_loan()
    {
        $response = $this->actingAs($this->user)->post('/loans', [
            'customer_id' => $this->customer->id,
            'principal_amount' => 10000,
            'interest_rate' => 2,
            'interest_type' => 'Flat',
            'loan_date' => now()->format('Y-m-d'),
            'loan_period_months' => 12,
            'grace_period_days' => 7,
            'penalty_rate' => 1
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('loans', [
            'customer_id' => $this->customer->id,
            'principal_amount' => 10000
        ]);
    }

    /** @test */
    public function loan_automatically_generates_ticket_number()
    {
        $loan = Loan::factory()->create();

        $this->assertNotNull($loan->ticket_number);
        $this->assertMatchesRegularExpression('/^PB-\d{4}-\d{4}$/', $loan->ticket_number);
    }

    /** @test */
    public function loan_calculates_due_date_correctly()
    {
        $loanDate = now();
        $months = 12;

        $loan = Loan::factory()->create([
            'loan_date' => $loanDate,
            'loan_period_months' => $months
        ]);

        $expectedDueDate = $loanDate->copy()->addMonths($months);
        
        $this->assertEquals(
            $expectedDueDate->format('Y-m-d'),
            $loan->due_date->format('Y-m-d')
        );
    }
}
```

### Payment Feature Tests

#### PaymentControllerTest.php

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $loan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->loan = Loan::factory()->create([
            'principal_amount' => 10000,
            'outstanding_principal' => 10000
        ]);
    }

    /** @test */
    public function user_can_record_payment()
    {
        $response = $this->actingAs($this->user)->post('/payments', [
            'loan_id' => $this->loan->id,
            'amount' => 2000,
            'payment_date' => now()->format('Y-m-d'),
            'payment_type' => 'Interest Only',
            'payment_method' => 'Cash'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payments', [
            'loan_id' => $this->loan->id,
            'amount' => 2000
        ]);
    }

    /** @test */
    public function full_settlement_closes_loan()
    {
        $response = $this->actingAs($this->user)->post('/payments', [
            'loan_id' => $this->loan->id,
            'amount' => 10000,
            'payment_date' => now()->format('Y-m-d'),
            'payment_type' => 'Full Settlement',
            'payment_method' => 'Cash'
        ]);

        $this->loan->refresh();
        $this->assertEquals('Closed', $this->loan->status);
    }

    /** @test */
    public function payment_generates_receipt_number()
    {
        $payment = Payment::factory()->create();

        $this->assertNotNull($payment->receipt_number);
        $this->assertMatchesRegularExpression('/^RCP-\d{4}-\d{4}$/', $payment->receipt_number);
    }
}
```

---

## Browser Tests

### Dusk Tests

#### CustomerBrowserTest.php

```php
<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Models\User;
use Laravel\Dusk\Browser;

class CustomerBrowserTest extends DuskTestCase
{
    /** @test */
    public function user_can_create_customer_through_ui()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/customers/create')
                    ->type('name', 'John Doe')
                    ->type('mobile', '9876543210')
                    ->type('address', '123 Main St')
                    ->type('city', 'Chennai')
                    ->type('state', 'Tamil Nadu')
                    ->type('pincode', '600001')
                    ->select('id_proof_type', 'Aadhaar')
                    ->type('id_proof_number', '123456789012')
                    ->press('Save Customer')
                    ->assertPathIs('/customers')
                    ->assertSee('Customer created successfully');
        });
    }
}
```

---

## Manual Testing

### Test Scenarios

#### Scenario 1: Complete Loan Workflow

**Objective**: Test complete loan lifecycle from customer creation to loan closure

**Steps**:
1. Login as admin
2. Create new customer with all details
3. Upload customer photo
4. Create loan for customer
5. Add pawn items to loan
6. Generate pawn ticket PDF
7. Record interest payment
8. Record partial settlement
9. Record full settlement
10. Verify loan status is "Closed"

**Expected Results**:
- Customer created with auto-generated code
- Loan created with auto-generated ticket number
- PDF generated successfully
- Payments recorded correctly
- Loan automatically closed on full settlement

#### Scenario 2: Overdue Loan Handling

**Steps**:
1. Create loan with past due date
2. Check dashboard for overdue indicator
3. View loan details
4. Verify overdue status displayed
5. Calculate penalty amount
6. Record payment with penalty
7. Verify penalty recorded correctly

#### Scenario 3: Role-Based Access

**Steps**:
1. Login as Staff
2. Verify can create/edit customers and loans
3. Logout
4. Login as Auditor
5. Verify read-only access
6. Attempt to create customer (should fail)

---

## Test Data

### Factories

Create test data factories in `database/factories/`:

#### CustomerFactory.php

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'mobile' => $this->faker->numerify('##########'),
            'address' => $this->faker->address,
            'city' => 'Chennai',
            'state' => 'Tamil Nadu',
            'pincode' => $this->faker->numerify('######'),
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => $this->faker->numerify('############')
        ];
    }
}
```

### Seeders

#### TestDataSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Loan;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create 50 customers
        Customer::factory(50)->create()->each(function ($customer) {
            // Create 1-3 loans per customer
            Loan::factory(rand(1, 3))->create([
                'customer_id' => $customer->id
            ]);
        });
    }
}
```

---

## CI/CD Integration

### GitHub Actions

Create `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        
    - name: Install Dependencies
      run: composer install
      
    - name: Run Tests
      run: php artisan test --coverage
```

---

## Test Coverage Report

### Generate Coverage

```bash
php artisan test --coverage --min=75
```

### View HTML Coverage

```bash
php artisan test --coverage-html coverage
```

Then open `coverage/index.html` in browser.

---

**Testing Guide Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**Framework**: PHPUnit 10.x, Laravel Dusk
