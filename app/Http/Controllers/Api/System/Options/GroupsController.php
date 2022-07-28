<?php

namespace App\Http\Controllers\Api\System\Options;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\System\Options\GroupRequest;
use App\Http\Resources\System\Options\GroupResource;
use App\Models\Options\Group;
use App\Models\Options\Option;
use Cocur\Slugify\Slugify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class GroupsController extends BaseController
{

    protected string $name     = 'Group';
    protected string $model    = Group::class;
    protected string $resource = GroupResource::class;

    public function store(GroupRequest $request)
    {
        $data = $request->validated();
        return $this->storeRecord($request, $data);
    }

    public function updateSingle(GroupRequest $request, $id)
    {
        $data = $request->validated();
        return $this->updateSingleRecord($request, $id, $data);
    }

    /**
     * @param  array  $data
     * @param  Group  $record
     *
     * @return Group
     */
    protected function save($data, $record) : Group
    {
        $slugify = new Slugify();

        $slug = $data['slug'];
        $slug = empty($slug) ? $slugify->slugify($data['name']) : $slug;

        $record->slug = $slug;
        $record->name = $data['name'];


        $record->save();

        return $record;
    }

    public function destroySingle(Request $request, $id) : JsonResponse
    {
        unset($request);

        $entity = Group::findOrFail($id);

        Option::where('group_id', '=', $entity->id)->forceDelete();
        Group::destroy($entity->id);

        return response()->json(['data' => null]);
    }
}
