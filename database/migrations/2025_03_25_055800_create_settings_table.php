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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_title');
            $table->text('description')->nullable();
            $table->text('keyword')->nullable();
            $table->string('og_locale')->nullable();
            $table->string('og_type')->nullable();
            $table->timestamp('article_modified_time')->nullable();
            $table->string('twitter_card')->nullable();
            $table->string('og_image_type')->nullable();
            $table->text('Google_tag')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('url_canonique')->nullable();
            $table->string('url_googleSearchConsole')->nullable();
            $table->string('url_googleMaps')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_twintter')->nullable();
            $table->string('url_instagram')->nullable();
            $table->string('url_behance')->nullable();
            $table->string('url_gitHub')->nullable();
            $table->string('url_tictok')->nullable();
            $table->string('copyright')->nullable();
            $table->string('sitemap')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
