<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\Social\SocialServiceContract;

/**
 * Class SocialsTableSeeder
 *
 * @package Database\Seeders
 */
final class SocialsTableSeeder extends Seeder
{
    /**
     * @var string $table
     */
    private string $table = 'socials';

    /**
     * @var array $socials
     */
    private array $socials = SocialServiceContract::SUPPORT_NETWORKS;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderPosition = 0;
        foreach ($this->socials as $social) {
            $social['position'] = $orderPosition;
            $social['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $social['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            DB::table($this->table)->insert($social);
            ++$orderPosition;
        }
    }
}
