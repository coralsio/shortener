<?php

namespace Corals\Modules\Shortener\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShortenerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortener_short_domains', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('base_url');
            $table->string('status')->default('active');
            $table->text('description')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->text('properties')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('shortener_links', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->charset = 'utf8mb4';

            $table->text('url');
            $table->string('alias')->nullable();
            $table->unsignedBigInteger('short_domain_id')->nullable();
            $table->string('code')->index()->collation('utf8mb4_bin')->nullable();
            $table->string('short_url')->index()->nullable();
            $table->dateTime('expired_at')->index()->nullable();
            $table->string('password')->nullable();
            $table->text('description')->nullable();
            $table->boolean('show_splash_page')->default(true);
            $table->text('parameters')->nullable();
            $table->string('type')->index()->default('direct');
            $table->string('status')->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->text('properties')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('short_domain_id')->references('id')
                ->on('shortener_short_domains')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('shortener_url_codes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->charset = 'utf8mb4';

            $table->string('code')->unique()->collation('utf8mb4_bin');

            $table->unsignedBigInteger('link_id')->nullable();
            $table->unsignedBigInteger('short_domain_id')->nullable();

            $table->string('generation_code');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('link_id')->references('id')
                ->on('shortener_links')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('short_domain_id')->references('id')
                ->on('shortener_short_domains')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('shortener_impressions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('link_id');

            $table->string('browser')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('browser_version')->nullable();
            $table->boolean('is_phone')->default(false);
            $table->boolean('is_tablet')->default(false);
            $table->boolean('is_desktop')->default(false);
            $table->boolean('is_robot')->default(false);
            $table->string('robot')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->text('languages')->nullable();
            $table->text('referer')->nullable();

            $table->softDeletes();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->timestamps();

            $table->foreign('link_id')->references('id')
                ->on('shortener_links')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('shortener_tracking_pixels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('short_domain_id')->nullable();

            $table->string('provider');
            $table->string('name');

            $table->text('head_script')->nullable();
            $table->text('body_script')->nullable();

            $table->string('status');


            $table->softDeletes();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->timestamps();

            $table->foreign('short_domain_id')
                ->references('id')
                ->on('shortener_short_domains')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shortener_tracking_pixels');
        Schema::dropIfExists('shortener_impressions');
        Schema::dropIfExists('shortener_url_codes');
        Schema::dropIfExists('shortener_links');
        Schema::dropIfExists('shortener_short_domains');
    }
}
