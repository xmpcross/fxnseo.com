<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('site_name')->nullable();
            $table->text('site_description')->nullable();
            $table->string('organization_name')->nullable();
            $table->text('organization_logo')->nullable();
            $table->text('default_image')->nullable();
            $table->string('author_name')->nullable();
            $table->string('twitter_site')->nullable();
            $table->text('social_profiles')->nullable();
            $table->boolean('organization_schema')->default(true);
            $table->boolean('website_schema')->default(true);
            $table->boolean('webpage_schema')->default(true);
            $table->boolean('article_schema')->default(true);
            $table->boolean('software_schema')->default(true);
            $table->boolean('breadcrumb_schema')->default(true);
            $table->boolean('faq_schema')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_settings');
    }
}
