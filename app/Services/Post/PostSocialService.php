<?php

namespace App\Services\Post;

use App\Models\PostSocial;
use App\Services\AbstractService;
use Illuminate\Support\Facades\DB;
use App\Jobs\PostShareTelegramJob;
use App\Jobs\PostShareViberJob;
use App\Jobs\PostShareEmailJob;
use Exception;

/**
 * Class PostSocialService
 *
 * @package App\Services\Post
 */
final class PostSocialService extends AbstractService
{
    /**
     * @return void
     * @author sihoullete
     */
    public function boot()
    {
        parent::boot();
        $this->setCrudDialog('share.success', trans('services.post.share.success'));
        $this->setCrudDialog('share.error', trans('services.post.share.error'));
    }

    /**
     * @param array $data
     *
     * @return PostSocial
     * @author sihoullete
     */
    public function makeModel(array $data = []): PostSocial
    {
        $model = PostSocial::where('post_id', $data['post_id'] ?? null)
            ->where('social_alias', $data['social_alias'] ?? null)
            ->first();
        if (!$model instanceof PostSocial) {
            $model = new PostSocial;
            $model->share_count = 0;
        }
        $model->fill($data);
        ++$model->share_count;

        return $model;
    }

    /**
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function telegram(array $data = []): array
    {
        DB::beginTransaction();
        try {
            $resp['success'] = true;
            $model = $this->makeModel($data);
            $model->save();
            dispatch(new PostShareTelegramJob($model));
            $resp['share_count'] = $model->share_count;
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $resp['success'] = false;
            $resp['exception'] = $e->getMessage();
        }
        $resp['msg'] = $resp['success']
            ? $this->getCrudDialog('share.success')
            : $this->getCrudDialog('share.error');

        return $resp;
    }

    /**
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function viber(array $data = []): array
    {
        DB::beginTransaction();
        try {
            $resp['success'] = true;
            $model = $this->makeModel($data);
            $model->save();
            dispatch(new PostShareViberJob($model));
            $resp['share_count'] = $model->share_count;
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $resp['success'] = false;
            $resp['exception'] = $e->getMessage();
        }
        $resp['msg'] = $resp['success']
            ? $this->getCrudDialog('share.success')
            : $this->getCrudDialog('share.error');

        return $resp;
    }

    /**
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function email(array $data = []): array
    {
        DB::beginTransaction();
        try {
            $resp['success'] = true;
            $model = $this->makeModel($data);
            $model->save();
            dispatch(new PostShareEmailJob($model));
            $resp['share_count'] = $model->share_count;
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $resp['success'] = false;
            $resp['exception'] = $e->getMessage();
        }
        $resp['msg'] = $resp['success']
            ? $this->getCrudDialog('share.success')
            : $this->getCrudDialog('share.error');

        return $resp;
    }
}
