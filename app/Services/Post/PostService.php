<?php

namespace App\Services\Post;

use Exception;
use Carbon\Carbon;
use App\Models\Post;
use App\Services\AbstractService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PostService
 *
 * @package App\Services\Post
 */
final class PostService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return LengthAwarePaginator
     *
     * @author sihoullete
     */
    public function index(array $data = []): LengthAwarePaginator
    {
        return Post::where('user_id', Auth::user()->id)
            ->where('language_locale', App::getLocale())
            ->paginate(5);
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @author sihoullete
     */
    public function create(array $data = []): array
    {
        $data['moderated_at'] = Carbon::now()
            ->format('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            Post::create($data);
            $resp['success'] = true;
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $resp['success'] = false;
            $resp['exception'] = $e->getMessage();
        }
        $resp['msg'] = $resp['success']
            ? $this->getCrudDialog('save.success')
            : $this->getCrudDialog('save.error');

        return $resp;
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return array
     *
     * @author sihoullete
     */
    public function update(int $id, array $data = []): array
    {
        $resp['success'] = false;
        $model = $this->getUpdateModel($id);
        if ($model instanceof Post) {
            DB::beginTransaction();
            try {
                $model->update($data);
                $resp['success'] = true;
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $resp['success'] = false;
                $resp['exception'] = $e->getMessage();
            }
        }
        $resp['msg'] = $resp['success']
            ? $this->getCrudDialog('save.success')
            : $this->getCrudDialog('save.error');

        return $resp;
    }

    /**
     * @param int $id
     *
     * @return Post|null
     *
     * @author sihoullete
     */
    public function getUpdateModel(int $id): ?Post
    {
        return Post::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->where('language_locale', App::getLocale())
            ->first();
    }
}
