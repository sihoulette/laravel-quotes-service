<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Entities\Localization\LocalizationEntityContract;

/**
 * Class LanguagesTableSeeder
 *
 * @package Database\Seeders
 */
final class LanguagesTableSeeder extends Seeder
{
    /**
     * @var string $table
     */
    private string $table = 'languages';

    /**
     * Default locale set
     */
    private const DEFAULT_LANGUAGE = LocalizationEntityContract::DEFAULT_LANGUAGE;

    /**
     * List of default support languages
     */
    public const SUPPORT_LANGUAGES = LocalizationEntityContract::SUPPORT_LANGUAGES;

    /**
     * ist of all available languages
     */
    public const AVAILABLE_LANGUAGES = LocalizationEntityContract::AVAILABLE_LANGUAGES;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderPosition = 0;
        foreach (self::SUPPORT_LANGUAGES as $locale) {
            if (isset(self::AVAILABLE_LANGUAGES[$locale])) {
                $language = self::AVAILABLE_LANGUAGES[$locale];
                $data['locale'] = $locale;
                $data['name'] = $language['name'];
                $data['native'] = $language['native'];
                $data['regional'] = $language['regional'];
                $data['default'] = (int)($locale === self::DEFAULT_LANGUAGE);
                $data['position'] = $orderPosition;
                $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

                DB::table($this->table)->insert($data);
                ++$orderPosition;
            }
        }
    }
}
