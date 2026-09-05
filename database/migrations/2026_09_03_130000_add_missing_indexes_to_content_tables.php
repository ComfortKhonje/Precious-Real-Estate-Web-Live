<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The 2026-09-02 pass indexed the properties table but stopped there. Every
 * other content table is still queried on unindexed columns on public pages:
 * services.visible on the home and services pages, announcements.status +
 * published_at on the home page, news index and sitemap, inquiries.type in
 * the CMS filter, and team_members.visible/order on the team page.
 *
 * Cheap now, and cheaper than noticing later.
 */
return new class extends Migration
{
    /** table => [[columns...], ...] */
    private const INDEXES = [
        'services' => [['visible']],
        'announcements' => [['status', 'published_at'], ['is_featured']],
        'inquiries' => [['type'], ['created_at']],
        'team_members' => [['visible', 'order']],
        'property_images' => [['property_id', 'sort_order']],
        'announcement_images' => [['announcement_id', 'sort_order']],
    ];

    public function up(): void
    {
        foreach (self::INDEXES as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
                foreach ($indexes as $columns) {
                    if ($this->missingColumns($table, $columns)) {
                        continue;
                    }

                    $blueprint->index($columns);
                }
            });
        }
    }

    public function down(): void
    {
        foreach (self::INDEXES as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
                foreach ($indexes as $columns) {
                    if ($this->missingColumns($table, $columns)) {
                        continue;
                    }

                    $blueprint->dropIndex($columns);
                }
            });
        }
    }

    private function missingColumns(string $table, array $columns): bool
    {
        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                return true;
            }
        }

        return false;
    }
};
