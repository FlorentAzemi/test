<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Load specified relationships on a model based on the 'with' key from the request.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function loadRelationships($model, $request)
    {
        // Check if the request includes 'with' parameter
        if ($request->has('with')) {
            // Get the 'with' parameter value as an array
            $withArray = $request->input('with');

            // Load the specified relationships on the model
            if (!empty($withArray) && is_array($withArray)) {
                foreach ($withArray as $relationship) {
                    try {
                        // Try to load the relationship, catch any exceptions
                        $model->load($relationship);
                    } catch (\Exception $e) {
                        // Log the exception or handle it as needed
                        // For now, we're just catching and ignoring it
                    }
                }
            }
        }

        return $model;
    }
}
