<?php

namespace Darkwind\Contract;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class ContractOrigin extends Model
{
    //
    protected $connection = 'mongodb';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //
    public function saveInfo($request, $id)
    {

        $model = $id ? ContractOrigin::findOrFail($id) : new ContractOrigin();
        $params = $request->all();
        unset($params['id']);

        foreach ($params as $index => $value) {
            $model->$index = $value;
        }
        return $model->save() ? $model : false;
    }
}
