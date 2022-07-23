<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class PostShareEmailJob
 *
 * @package App\Jobs
 */
final class PostShareEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int $postId
     */
    public int $postId;

    /**
     * @var string $contact
     */
    public string $contact;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->postId = $data['postId'];
        $this->contact = $data['contact'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $model = Post::where('id', $this->postId)
            ->first();
        if ($model instanceof Post) {
            //@TODO Call API
            sleep(rand(5, 20));
        }
    }
}
