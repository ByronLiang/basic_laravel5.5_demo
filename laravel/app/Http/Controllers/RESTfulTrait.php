<?php

namespace App\Http\Controllers;

trait RESTfulTrait
{
    public function __construct()
    {
        /**
         * @var \Eloquent
         */
        $model = new $this->model();

        if ('admin' == \Auth::getDefaultDriver() && method_exists($model, 'trashed')) {
            $model = $model->withTrashed();
        }
        $this->model = $model;
        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    public function index()
    {
        $models = $this->model
            ->when(method_exists($this->model, 'scopeFilter'), function ($q) {
                return $q->filter(request()->all());
            });

        if (request('per_page') || request('page')) {
            if (request('simplePaginate')) {
                $models = $models
                    ->simplePaginate(request('per_page'))
                    ->appends(request()->all());
            } else {
                $models = $models
                    ->paginate(request('per_page'))
                    ->appends(request()->all());
            }
        } else {
            $take = request('take');
            $models = $models
                ->when(is_null($take), function ($q) use ($take) {
                    return $q->take(1000);
                })
                ->when(!is_null($take) && is_numeric($take) && $take, function ($q) use ($take) {
                    return $q->take($take);
                })
                ->get();
        }

        return \Response::success($models);
    }

    /**
     * @param $id
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function show($id)
    {
        /**
         * @var \Illuminate\Support\Collection
         */
        $models = $this->model
            ->when(method_exists($this->model, 'scopeFilter'), function ($q) {
                return $q->filter(request()->all());
            })
            ->findOrFail(explode(',', $id));

        1 == $models->count() && $models = $models->first();

        return \Response::success($models);
    }

    public function destroy($id)
    {
        /**
         * @var \Illuminate\Support\Collection
         */
        $models = $this->model->findOrFail(explode(',', $id));
        foreach ($models as $key => $model) {
            if ('force' == request('ac')) {
                $model->forceDelete();
            } elseif (method_exists($model, 'trashed') && $model->trashed()) {
                $model->restore();
            } else {
                $model->delete();
            }
        }

        return \Response::success();
    }
}
