<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Company;
use App\Models\ItemAccountGroup;
use App\Models\ItemGroup;
use App\Models\ItemType;
use App\Models\ItemUnit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $company = Company::create([
            'name' => 'PT. Wira Lahana Sukses',
        ]);

        User::factory()->create([
            'company_id' => $company->id,
            'username' => 'wahyu',
            'name' => 'Wahyu Nuzul Bahri',
            'email' => 'wahyu@example.com',
        ]);

        ItemType::create([
            'name' => 'Product',
        ]);

        ItemGroup::create([
            'name' => 'Product Lain-Lain',
        ]);

        ItemAccountGroup::create([
            'name' => 'Default',
        ]);

        ItemUnit::create([
            'name' => 'PCS',
        ]);

        Account::create([
            'name' => 'Biaya Adm Bank - 800-01',
        ]);
    }
}
