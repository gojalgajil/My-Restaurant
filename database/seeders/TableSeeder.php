<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['number' => 'MEJA-01', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'MEJA-02', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'MEJA-03', 'capacity' => 2, 'status' => 'available'],
            ['number' => 'MEJA-04', 'capacity' => 6, 'status' => 'available'],
            ['number' => 'MEJA-05', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'MEJA-06', 'capacity' => 2, 'status' => 'available'],
            ['number' => 'MEJA-07', 'capacity' => 8, 'status' => 'available'],
            ['number' => 'MEJA-08', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'MEJA-09', 'capacity' => 6, 'status' => 'available'],
            ['number' => 'MEJA-10', 'capacity' => 4, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
