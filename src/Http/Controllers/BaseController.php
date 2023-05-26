<?php

namespace OpenStrong\StrongAdmin\Http\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{

    use \OpenStrong\StrongAdmin\Repositories\Traits\AppTrait;

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function view($view = null, $data = [], $mergeData = [])
    {
        if ($view)
        {
            $view = 'strongadmin::' . $view;
        }
        return view($view, $data, $mergeData);
    }

    protected function isApi()
    {
        $data = config('strongadmin.middleware');
        return array_search('api', $data) !== false ? true : false;
    }

}
