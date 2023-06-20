<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('request_templates')->insert([
            'title' => 'Comprovante de Matrícula',
            'description' => 'Solicite um comprovante assinado de matrícula.',
            'details_field_placeholder' => 'Observações sobre o pedido de comprovante de matrícula',
            'workflow_id' => DB::table('workflows')->first('id')->id,
        ]);
    }
}
