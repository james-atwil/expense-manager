<?php

namespace App\Http\Controllers\Api\System\Options;

use App\Common\Parabuilder;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\System\Options\OptionRequest;
use App\Http\Resources\System\Options\OptionResource;
use App\Models\Options\Group;
use App\Models\Options\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class OptionsController extends BaseController
{

    protected string $name     = 'Option';
    protected string $model    = Option::class;
    protected string $resource = OptionResource::class;

    public function list(Request $request): JsonResource|ResourceCollection|array
    {
        $slug = $request->route('slug');

        if ($slug) {
            $group = Group::where('slug', '=', $slug)->first();
            $request->query->set('f', ['g' => $group->id]);
            $request->query->set('m', 1);
        }

        return parent::list($request);
    }

    public function store(OptionRequest $request)
    {
        $data = $request->validated();
        return $this->storeRecord($request, $data);
    }

    public function updateSingle(OptionRequest $request, $id)
    {
        $data = $request->validated();
        return $this->updateSingleRecord($request, $id, $data);
    }

    protected function buildKeywords(string $q, Parabuilder $whereQ): Parabuilder
    {
        $whereQ->string = [
            ' name LIKE ? ',
            ' value LIKE ? ',
        ];

        for ($i = 1; $i <= count($whereQ->string); $i++) {
            $whereQ->params[] = "%$q%";
        }

        return $whereQ;
    }

    protected function buildFilters(array $f, Parabuilder $whereF): Parabuilder
    {
        if (isset($f['g']) && !empty($f['g'])) {
            $whereF->string[] = ' group_id = ? ';
            $whereF->params[] = $f['g'];
        }

        return $whereF;
    }

    /**
     * @param  array  $data
     * @param  Option  $record
     *
     * @return Option
     */
    protected function save($data, $record): Option
    {
        $record->group_id = $data['group']['id'];
        $record->name     = $data['name'];
        $record->value    = $data['value'];

        $record->save();

        return $record;
    }
}
