<?php

namespace App\Jobs;

use App\Models\PostSocial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class PostShareTelegramJob
 *
 * @package App\Jobs
 */
final class PostShareTelegramJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int $postID
     */
    public int $postID;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PostSocial $model)
    {
        $this->postID = $model->post_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //@TODO Call API
        sleep(rand(5, 20));
    }
}
