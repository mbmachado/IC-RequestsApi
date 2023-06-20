<?php

namespace Database\Seeders;

use App\Enums\AssigneeType;
use App\Enums\StepType;
use App\Models\Workflow;
use Illuminate\Database\Seeder;


class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workflow::create([
            'title' => 'Comprovante de Matrícula',
            'description' => 'Fluxo de Trabalho para Comprovante de Matrícula'
        ])->steps()->createMany([
            [
                'name' => 'Aguardando',
                'step_type' => StepType::Initial->value,
                'order' => 1
            ],
            [
                'name' => 'Gerar Documento',
                'assignee_type' => AssigneeType::Office->value,
                'step_type' => StepType::Intermediate->value,
                'order' => 2
            ],
            [
                'name' => 'Assinar',
                'assignee_type' => AssigneeType::Committee->value,
                'step_type' => StepType::Intermediate->value,
                'order' => 3
            ],
            [
                'name' => 'Finalizado',
                'step_type' => StepType::Final->value,
                'order' => 4
            ]
        ]);
    }
}
