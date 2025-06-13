<?php

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
        Schema::create('common_masters', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum("type",["disciplines", "heights", "sexes", "breeds", "colors", "training_show_experiences", "green_eligibilities", "qualifies", "current_fence_height", "potential_fence_height", "tried_upcoming_shows", "property_types", "stable_amenities", "housing_stables_around_horse_shows", "housing_amenities", "realtors", "property_manager", "job_listing_types", "services", "contract_types", "assistance_upcoming_shows", "horse_apparels", "rider_apparels", "horse_tacks", "trailer_trucks", "for_barns", "equine_supplements", "conditions", "brands", "horse_sizes", "rider_sizes", "exchanged_upcoming_horse_shows"]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_masters');
    }
};
