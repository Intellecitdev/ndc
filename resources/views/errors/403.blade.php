@include('errors._page', ['code' => 403, 'icon' => 'fa-solid fa-lock', 'message' => $exception->getMessage() ?: 'You do not have permission to access this page.'])
