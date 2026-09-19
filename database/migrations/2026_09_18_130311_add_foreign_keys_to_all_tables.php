<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('property_types');
            $table->foreign('listing_id')->references('id')->on('listing_types');
            $table->foreign('status_id')->references('id')->on('property_statuses');
            $table->foreign('assigned_agent_id')->references('id')->on('users');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('user_roles');
            $table->foreign('status_id')->references('id')->on('user_statuses');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('assigned_agent_id')->references('id')->on('users');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('status_id')->references('id')->on('lead_statuses');
        });

        Schema::table('interested_properties', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('lead_id')->references('id')->on('leads');
        });

        Schema::table('property_owners', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('type_id')->references('id')->on('contact_types');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['listing_id']);
            $table->dropForeign(['status_id']);
            $table->dropForeign(['assigned_agent_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['status_id']);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['assigned_agent_id']);
            $table->dropForeign(['contact_id']);
            $table->dropForeign(['status_id']);
        });

        Schema::table('interested_properties', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
            $table->dropForeign(['lead_id']);
        });

        Schema::table('property_owners', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
            $table->dropForeign(['contact_id']);
            $table->dropForeign(['type_id']);
        });
    }
};