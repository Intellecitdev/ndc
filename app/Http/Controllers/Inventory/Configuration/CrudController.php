<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * List + modal add/edit/delete pages of Inventory > Configuration
 * (same flow as the reference: AJAX save, toast, reload).
 */
abstract class CrudController extends Controller
{
    use JsonResponses;

    /** @var class-string<Model> */
    protected string $model;

    protected string $view;

    /** Shown in messages, e.g. "Brand created successfully." */
    protected string $label;

    protected int $perPage = 15;

    abstract protected function rules(Request $request, ?Model $record): array;

    /** Map validated request fields (reference names) to columns. */
    abstract protected function payload(array $data): array;

    protected function query(Request $request): Builder
    {
        return $this->model::query()->latest('id');
    }

    /** Extra variables for the view (dropdown options, ...). */
    protected function viewData(): array
    {
        return [];
    }

    protected function attributes(): array
    {
        return [];
    }

    public function index(Request $request): View
    {
        return view($this->view, [
            'records' => $this->query($request)->paginate($this->perPage)->withQueryString(),
        ] + $this->viewData());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->check($request, $this->rules($request, null), $this->attributes());
        $record = $this->model::create($this->payload($data));
        $this->saved($record);

        $message = ($record->approval_status ?? null) === 'Pending' ? "{$this->label} submitted for QM approval." : "{$this->label} created successfully.";

        return $this->ok($message, ['id' => $record->id]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = $this->model::findOrFail($id);
        $data = $this->check($request, $this->rules($request, $record), $this->attributes());
        $record->update($this->payload($data));
        $this->saved($record);

        return $this->ok("{$this->label} updated successfully.");
    }

    public function destroy(string $id): JsonResponse
    {
        $record = $this->model::findOrFail($id);
        try {
            $record->delete();
        } catch (QueryException) {
            return $this->fail("This {$this->label} is in use and can not be deleted.");
        }

        return $this->ok("{$this->label} deleted successfully.", ['id' => $record->id]);
    }

    /** Hook after create/update. */
    protected function saved(Model $record): void {}

    /** "Y"/"N" select → bool. */
    protected function yn(?string $v): bool
    {
        return $v === 'Y';
    }
}
