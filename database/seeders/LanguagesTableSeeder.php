<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\Language\LanguageService;
use App\Services\Language\LanguageServiceContract;

/**
 * Class LanguagesTableSeeder
 *
 * @package Database\Seeders
 */
final class LanguagesTableSeeder extends Seeder
{
    /**
     * Insert locales to table
     */
    private const LOCALES = LanguageServiceContract::DEFAULT_LOCALES;

    /**
     * Default locale set
     */
    private const DEFAULT_LOCALE = LanguageServiceContract::DEFAULT_LOCALE;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderPosition = 0;
        $supportLocales = LanguageService::makeSupportedLocales(self::LOCALES);
        foreach ($supportLocales as $locale => $language) {
            $data['locale'] = $locale;
            $data['name'] = $language['name'];
            $data['regional'] = $language['regional'];
            $data['default'] = (int)($locale === self::DEFAULT_LOCALE);
            $data['position'] = $orderPosition;
            $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            DB::table('languages')->insert($data);
            ++$orderPosition;
        }
    }
}
