<?php

namespace App\Services;

/**
 * Class AbstractService
 *
 * @package App\Services
 */
abstract class AbstractService
{
    /**
     * @var array $crudDialog
     */
    private array $crudDialog = [];

    /**
     * AbstractService constructor.
     */
    public function __construct()
    {
        $this->boot();
    }

    /**
     * @return void
     *
     * @author sihoullete
     */
    public function boot()
    {
        $this->crudDialog['save.error'] = trans('services.save.error');
        $this->crudDialog['save.success'] = trans('services.save.success');
    }

    /**
     * @param string $key
     * @param string $msg
     *
     * @return $this
     *
     * @author sihoullete
     */
    public function setCrudDialog(string $key, string $msg): self
    {
        $this->crudDialog[$key] = $msg;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     *
     * @author sihoullete
     */
    public function getCrudDialog(string $key): string
    {
        return $this->crudDialog[$key] ?? 'Not set dialog msg';
    }
}
