<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends CrudController
{
    protected string $model = Supplier::class;
    protected string $view = 'inventory.configuration.suppliers';
    protected string $label = 'Supplier';

    protected function query(Request $request): Builder
    {
        $s = $request->search;

        return Supplier::query()
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('code', 'like', "%$s%")->orWhere('name', 'like', "%$s%")
                ->orWhere('contact_person', 'like', "%$s%")->orWhere('contact_no', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")))
            ->latest('id');
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'Code' => ['required', 'string', 'max:50', Rule::unique('suppliers', 'code')->ignore($record)],
            'Supplier' => ['required', 'string', 'max:50'],
            'ContactPerson' => ['required', 'string', 'max:50'],
            'ContactNo' => ['required', 'regex:/^01[0-9]{9}$/'],
            'Email' => ['required', 'email', 'max:150'],
            'Address' => ['nullable', 'string', 'max:250'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['Supplier' => 'Supplier Name', 'ContactPerson' => 'Contact Person', 'ContactNo' => 'Contact No', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return [
            'code' => $d['Code'], 'name' => $d['Supplier'], 'contact_person' => $d['ContactPerson'], 'contact_no' => $d['ContactNo'],
            'email' => $d['Email'], 'address' => $d['Address'] ?? null, 'status' => $this->yn($d['C4S']),
        ];
    }
}
