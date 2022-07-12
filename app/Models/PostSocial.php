<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PostSocial
 *
 * @package App\Models
 */
class PostSocial extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'posts_socials';

    /**
     * @var bool $incrementing
     */
    public $incrementing = false;

    /**
     * @var string[] $primaryKey
     */
    protected $primaryKey = ['post_id', 'social_alias'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'social_alias',
        'share_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Set the keys for a save update query.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    protected function setKeysForSaveQuery($query): Builder
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed|null $keyName
     *
     * @return mixed
     */
    protected function getKeyForSaveQuery(mixed $keyName = null): mixed
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
