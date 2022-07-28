<?php

namespace App\Http\Controllers\Api;

use App\Common\Parabuilder;
use App\Models\Model;
use App\Models\User;
use Cocur\Slugify\Slugify;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller;
use stdClass as StdClass;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var string */
    protected string $name;

    /** @var class-string<Model> */
    protected string $model;

    /** @var class-string<JsonResource> */
    protected string $resource;

    protected int|null $ipp        = null;
    protected string   $orderField = 'id';
    protected string   $orderSort  = 'ASC';

    protected string|null $showDeleted         = null;
    protected bool        $enableFlashMessages = true;

    public function list(Request $request): JsonResource|ResourceCollection|array
    {
        /** @var User $user */
        $user = auth()->user();

        if (empty($this->model)) {
            return [];
        }

        $ipp = settings('admin.ipp');

        $q = $request->query('q', ''); // Keywords
        $l = (int)$request->query('l', $this->ipp ?? $ipp);
        $f = $request->query('f', []); // Filter
        $x = $request->query('x', []); // Filter Exclusion
        $s = $request->query('s', []); // Sort
        $p = $request->query('p', 1);  // Page
        $r = $request->query('r');     // Parent
        $m = $request->query('m', 0);  // Simplified

        $whereQ = new Parabuilder();
        $whereF = new Parabuilder();
        $whereX = new Parabuilder();

        $appends = [];

        if ($q != '') {
            $whereQ       = $this->buildKeywords($q, $whereQ);
            $appends['q'] = $q;
        }

        $whereF       = $this->buildRouteFilters($request, $whereF);
        $whereF       = $this->buildFilters($f, $whereF);
        $appends['f'] = $f;

        $whereX       = $this->buildExclusions($x, $whereX);
        $appends['x'] = $f;

        if ($l != $ipp) {
            $appends['l'] = $l;
        }

        $appends['m'] = $m;

        if (!is_null($r)) {
            $whereF->string[] = ' parent_id = ? ';
            $whereF->params[] = $r;
        }

        $array_str = [
            (count($whereQ->string) > 0 ? implode(' OR  ', $whereQ->string) : '1'),
            (count($whereF->string) > 0 ? implode(' AND ', $whereF->string) : '1'),
            (count($whereX->string) > 0 ? implode(' AND ', $whereX->string) : '1'),
        ];

        $where         = new StdClass();
        $where->string = implode(' AND ', $array_str);
        $where->params = array_merge($whereQ->params, $whereF->params, $whereX->params);

        $query = $this->model::query();

        $show_trashed = !is_null($this->showDeleted) && !empty($user) && $user->hasAnyRole($this->showDeleted);

        if ($show_trashed) {
            $query = $query->withTrashed();
        }

        if (empty($s)) {
            $query = $query->orderBy($this->orderField, $this->orderSort);
        } else {
            [$query, $appends] = $this->buildSort($s, $query, $appends);
        }

        $query->where(function ($query) use ($where) {
            $query->whereRaw($where->string, $where->params);
        });

        if ($l > 0) {
            $items = $query->paginate($l, ['*'], 'p')->appends($appends);
        } else {
            $items = $query->get();
        }

        return !empty($this->resource) ? $this->resource::collection($items) : new ResourceCollection($items);
    }

    public function show($id): JsonResource
    {
        return new $this->resource($this->model::findOrFail($id));
    }

    protected function storeRecord($request, $data)
    {
        $entity = new $this->model();
        $entity = $this->save($data, $entity);

        if ($this->enableFlashMessages) {
            $this->flashMessage($request, 'success', __(sprintf('%s has been created.', $this->name)));
        }

        return new $this->resource($this->model::findOrFail($entity->id));
    }

    protected function updateSingleRecord($request, $id, $data)
    {
        $entity = $this->model::findOrFail($id);
        $entity = $this->save($data, $entity);

        if ($this->enableFlashMessages) {
            $this->flashMessage($request, 'success', __(sprintf('%s has been updated.', $this->name)));
        }

        return new $this->resource($this->model::findOrFail($entity->id));
    }

    public function destroySingle(Request $request, $id): JsonResponse
    {
        unset($request);

        $entity = $this->model::findOrFail($id);
        $this->model::destroy($entity->id);

        return response()->json(['data' => null]);
    }

    public function destroyMultiple(Request $request): JsonResponse
    {
        $ids = $request->get('ids');

        try {
            $this->model::whereIn('id', $ids)->forceDelete();

            return response()->json(['data' => null]);
        } catch (Exception $e) {
            return response()->setStatusCode(500)->json([
                'status'  => '500',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param  string       $q       Query string
     * @param  Parabuilder  $whereQ  Builder object
     *
     * @return Parabuilder
     */
    protected function buildKeywords(string $q, Parabuilder $whereQ): Parabuilder
    {
        $whereQ->string[] = ' slug LIKE ? OR name LIKE ? ';

        $whereQ->params[] = "%{$q}%";
        $whereQ->params[] = "%{$q}%";

        return $whereQ;
    }

    /**
     * @param  Request      $request
     * @param  Parabuilder  $whereF
     *
     * @return Parabuilder
     */
    protected function buildRouteFilters(Request $request, Parabuilder $whereF): Parabuilder
    {
        return $whereF;
    }

    /**
     * @param  array        $f
     * @param  Parabuilder  $whereF
     *
     * @return Parabuilder
     */
    protected function buildFilters(array $f, Parabuilder $whereF): Parabuilder
    {
        unset($f);

        return $whereF;
    }

    /**
     * @param  array        $x
     * @param  Parabuilder  $whereX
     *
     * @return Parabuilder
     */
    protected function buildExclusions(array $x, Parabuilder $whereX): Parabuilder
    {
        unset($x);

        return $whereX;
    }

    /**
     * @param  array  $s
     * @param         $query
     * @param         $appends
     *
     * @return array
     */
    protected function buildSort(array $s, $query, $appends): array
    {
        if (empty($s)) {
            $query = $query->orderBy($this->orderField, $this->orderSort);
        } else {
            foreach ($s as $key => $value) {
                $query                      = $query->orderBy($key, Model::SORT_ORDER[$value]);
                $appends['s[' . $key . ']'] = $value;
            }
        }

        return [$query, $appends];
    }

    protected function buildSimplifiedMakeHiddenFields($items)
    {
        $items->makeHidden(['description', 'notes', 'urls', 'ordering']);
        return $items;
    }

    protected function save($data, $record)
    {
        $name     = $data['name'];
        $fillable = $record->getFillable();

        if (in_array('slug', $fillable)) {
            $slugify = new Slugify();

            if (isset($data['slug'])) {
                $slug = $data['slug'];
                $slug = empty($slug) ? $slugify->slugify($name) : $slug;
                $record->slug = $slug;
            }
        }

        if (in_array('name', $fillable)) {
            $record->name = $data['name'];
        }

        if (in_array('description', $fillable)) {
            $record->description = $data['description'] ?? null;
        }

        if (in_array('email', $fillable)) {
            $record->email = $data['email'];
        }

        if (in_array('notes', $fillable)) {
            $record->notes = $data['notes'] ?? null;
        }

        $record->save();

        return $record;
    }

    protected function flashMessage(Request $request, $status, $content): ?bool
    {
        if (!$this->enableFlashMessages) {
            return null;
        }

        $message          = new StdClass();
        $message->status  = $status;
        $message->content = $content;

        $request->session()->flash('message', $message);

        return true;
    }
}
