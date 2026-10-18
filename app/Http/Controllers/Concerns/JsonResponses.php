<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Same AJAX contract the reference app uses:
 * { success, message, redirect?, errors? } — always HTTP 200 for validation
 * failures so the page shows each error as a toast.
 */
trait JsonResponses
{
    protected function ok(string $message, array $extra = []): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message] + $extra);
    }

    protected function fail(string $message, $errors = []): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors]);
    }

    /**
     * Validate, throwing a JSON "fail" response instead of a redirect.
     */
    protected function check(Request $request, array $rules, array $attributes = []): array
    {
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            throw new ValidationException($validator, $this->fail('Validation failed.', $validator->errors()));
        }

        return $validator->validated();
    }
}
