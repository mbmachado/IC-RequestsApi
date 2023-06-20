<?php

use App\Enums\RequestTemplateStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('status', RequestTemplateStatus::getValues())
                ->default(RequestTemplateStatus::Active->value);
            $table->boolean('show_title_field')->default(false);
            $table->string('title_field_label')->default('Título');
            $table->string('title_field_placeholder')->nullable();
            $table->boolean('title_field_required')->default(false);;
            $table->boolean('show_details_field')->default(true);
            $table->string('details_field_label')->default('Detalhes');
            $table->string('details_field_placeholder')->nullable();
            $table->boolean('details_field_required')->default(false);
            $table->boolean('show_attachments_field')->default(false);
            $table->string('attachments_field_label')->default('Anexos');
            $table->boolean('attachments_field_required')->default(false);
            $table->foreignId('workflow_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_templates');
    }
};
