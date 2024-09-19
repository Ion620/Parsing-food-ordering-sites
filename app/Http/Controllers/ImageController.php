<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ImageController extends Controller
{
    public function show(string $hash): HttpResponse
    {
        /** @var Images $image */
        $image = Images::query()->where('hash', '=', $hash)->firstOrFail();

        $path = storage_path().'/app/'.$image->path;
        $file = File::get($path);
        /** @var string $type */
        $type = File::mimeType($path);

        $response = Response::make($file, ResponseAlias::HTTP_OK);
        $response->header("Content-Type", $type);

        return $response;
    }
}
