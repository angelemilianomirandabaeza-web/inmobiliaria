<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CatalogoSeeder::class,
            UbicacionSeeder::class,
            PlanPublicacionSeeder::class,
            UserSeeder::class,
            PropiedadSeeder::class,
        ]);
    }
}
