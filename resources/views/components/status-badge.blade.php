@props(['active'])
@if ($active)
    <span class="badge bg-bs-success text-white">Active</span>
@else
    <span class="badge bg-bs-danger text-white">Inactive</span>
@endif
