<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('home_page_title', 350)->nullable();
            $table->string('career_page_title', 350)->nullable();
            $table->string('contact_page_title', 350)->nullable();
            $table->string('sitename', 200)->nullable();
            $table->string('sitelogo_english', 200)->nullable();
            $table->string('sitelogo_arabic', 200)->nullable();
            $table->string('sublogo_english', 255)->nullable();
            $table->string('sublogo_arabic', 255)->nullable();
            $table->string('google_captcha_key', 255)->nullable();
            $table->string('location_map', 255)->nullable();
            $table->string('location_map_file_ext', 10)->nullable();
            $table->string('employee_webmail', 250)->nullable();
            $table->string('site_meta_title', 250)->nullable();
            $table->text('site_meta_description')->nullable();
            $table->text('site_meta_keyword')->nullable();
            $table->text('contact_meta_description')->nullable();
            $table->string('contactus_meta_title', 255)->nullable();
            $table->text('contact_meta_keyword')->nullable();
            $table->string('contact_meta_author', 350)->nullable();
            $table->string('default_lang', 2)->default('en')->comment('default language');
            $table->string('default_search', 150)->default('farm');
            $table->integer('disable_language')->default(3)->comment('1 - English, 2- Arabic, 3 - none');
            $table->string('enquiry_send_email', 250)->nullable();
            $table->text('admin_alert_phone_numbers')->nullable();
            $table->string('facebook_link', 200)->nullable();
            $table->string('twitter_link', 200)->nullable();
            $table->string('pinterest_link', 200)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->string('google_plus_link', 255)->nullable();
            $table->string('vimeo_link', 255)->nullable();
            $table->string('youtube_link', 200)->nullable();
            $table->string('linkedin_link', 250)->nullable();
            $table->timestamp('last_updated')->useCurrent();
            $table->string('map_longitude', 200)->nullable();
            $table->string('map_latitude', 200)->nullable();
            $table->integer('show_iframe_google_map')->default(1);
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('address3', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->integer('twitterDisplayCount')->default(1);
            $table->integer('showTwitterFeeds');
            $table->string('email', 255)->nullable();
            $table->string('instagram_access_token', 350)->nullable();
            $table->string('instagram_user_id', 255)->nullable();
            $table->string('googleCaptchaSiteKey', 255)->nullable();
            $table->dateTime('tweet_last_updated')->nullable();
            $table->dateTime('settings_updated_at')->nullable();
            $table->dateTime('settings_created_at')->nullable();
            $table->text('twitter_hash_tag')->nullable();
            $table->integer('search_radius')->default(0);
            $table->integer('delivery_radius')->default(0);
            $table->integer('delivery_charge')->nullable()->comment('delivery charge in USD');
            $table->integer('free_delivery_minimum_price')->nullable()->comment('minimum price for free delivery in USD');
            $table->integer('daily_order_limit')->default(-1);
            $table->json('delivery_emirates')->nullable();
            $table->text('terms_n_conditions')->nullable();
            $table->text('seller_tc')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->text('landing_notify_message')->nullable();
            $table->text('refund_policy')->nullable();
            $table->integer('tax_percentage')->nullable();
            $table->integer('service_charge')->nullable()->comment('Farmsgate commission in percentage ');
            $table->integer('farm_deactivation_notice_period')->nullable();
            $table->string('landing_page')->nullable();
            $table->string('gstin_number', 255)->nullable();
            $table->string('pan_number', 255)->nullable();
            $table->text('company_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
