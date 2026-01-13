<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Field;


class FieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Lapangan A',
                'description' => 'Lapangan sintetis indoor',
                'price_per_hour' => 120000,
                'status' => 'available'
            ],
            [
                'name' => 'Lapangan B',
                'description' => 'Lapangan vinyl semi indoor',
                'price_per_hour' => 100000,
                'status' => 'available'
            ],
            [
                'name' => 'Lapangan C',
                'description' => 'Lapangan outdoor',
                'price_per_hour' => 90000,
                'status' => 'maintenance'
            ],
        ];


        foreach ($fields as $field) {
            Field::updateOrCreate(
                ['name' => $field['name']],
                $field
            );
        }
    }
}
