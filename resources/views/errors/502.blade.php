@include('errors.minimal', [
    'code' => 502,
    'title' => 'Temporary Connection Issue',
    'message' => 'The server received an invalid response upstream. Please try again shortly.'
])
