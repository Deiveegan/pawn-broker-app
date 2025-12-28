<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $shops = [
            ['name' => 'Gold Standard Pawns', 'address' => '123 Main St, New York', 'is_active' => true],
            ['name' => 'Evergreen Collateral', 'address' => '456 Oak Ave, Los Angeles', 'is_active' => true],
            ['name' => 'Metro Pawn & Loan', 'address' => '789 Broadway, Chicago', 'is_active' => true],
            ['name' => 'Heritage Antiques', 'address' => '101 Antique Row, Boston', 'is_active' => false],
            ['name' => 'Silver Sky Traders', 'address' => '202 Cloud St, Seattle', 'is_active' => true],
            ['name' => 'Pacific Pawn', 'address' => '303 Coastal Hwy, San Diego', 'is_active' => true],
            ['name' => 'Mountain View Loans', 'address' => '404 Peak Dr, Denver', 'is_active' => true],
            ['name' => 'Desert Gold', 'address' => '505 Sand Rd, Phoenix', 'is_active' => true],
            ['name' => 'Liberty Lending', 'address' => '606 Freedom Way, Philadelphia', 'is_active' => false],
            ['name' => 'North Star Pawns', 'address' => '707 Polaris Ln, Minneapolis', 'is_active' => true],
            ['name' => 'Southern Comfort Loans', 'address' => '808 Peach St, Atlanta', 'is_active' => true],
            ['name' => 'Bayou Traders', 'address' => '909 Marsh Inlet, New Orleans', 'is_active' => true],
            ['name' => 'Music City Pawns', 'address' => '111 Rhythm Blvd, Nashville', 'is_active' => true],
            ['name' => 'Gateway Collateral', 'address' => '222 Arch Way, St. Louis', 'is_active' => true],
            ['name' => 'Lone Star Loans', 'address' => '333 Star St, Austin', 'is_active' => true],
            ['name' => 'Emerald City Traders', 'address' => '444 Jewel Ln, Portland', 'is_active' => true],
            ['name' => 'Steel City Pawns', 'address' => '555 Forge Dr, Pittsburgh', 'is_active' => true],
            ['name' => 'Bluegrass Lending', 'address' => '666 Racing Way, Louisville', 'is_active' => true],
            ['name' => 'Capitol Pawn', 'address' => '777 Mall Walk, Washington DC', 'is_active' => false],
            ['name' => 'Windy City Gold', 'address' => '888 Gale St, Chicago', 'is_active' => true],
            ['name' => 'Sunshine State Loans', 'address' => '999 Ray Dr, Miami', 'is_active' => true],
            ['name' => 'Grizzly Pawns', 'address' => '123 Bear Rd, Anchorage', 'is_active' => true],
            ['name' => 'Desert Rose Traders', 'address' => '456 Bloom Ave, Las Vegas', 'is_active' => true],
            ['name' => 'Ocean Breeze Loans', 'address' => '789 Shore Dr, Honolulu', 'is_active' => true],
            ['name' => 'Rocky Mountain Pawns', 'address' => '101 Summit Cir, Salt Lake City', 'is_active' => true],
            ['name' => 'Old Dominion Lending', 'address' => '202 Colonial Way, Richmond', 'is_active' => true],
            ['name' => 'Granite State Traders', 'address' => '303 Rock Rd, Manchester', 'is_active' => true],
            ['name' => 'Badger Pawns', 'address' => '404 Burrow St, Madison', 'is_active' => true],
            ['name' => 'Show Me Loans', 'address' => '505 River Rd, Kansas City', 'is_active' => true],
            ['name' => 'Big Sky Gold', 'address' => '606 Horizon Ln, Billings', 'is_active' => true],
        ];

        foreach ($shops as $shopData) {
            Shop::create($shopData);
        }
    }
}
