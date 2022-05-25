<?php

namespace App\Http\Repositories;

use App\Models\FileShare;
use Illuminate\Support\Str;
use App\Http\Resources\FileResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Support\ResponseActionsTrait;

class FileShareRepository
{
    use ResponseActionsTrait;

    public function generateShareUrl($request, $file)
    {
        $token = hash_hmac('sha256',Str::random(40), $file->uuid);

        $shareLink = $file->link()->firstOrCreate([], [
            'token' => $token,
        ]);

        $url = [
            'url' => config('app.client_url') . "/download/{$file->uuid}?token={$shareLink->token}"
        ];

        return $this->sendSuccessfullyResponse('success', 'url generada con éxito', 200, $url);

    }
    public function downloadFile($request, $file)
    {
        $fileShare = FileShare::where('token', $request->token)
                        ->where('file_id', $file->id)
                        ->firstOrFail();
        return (new FileResource($file))->additional([
                'metadata' => [
                    'url' => Storage::disk('s3')->temporaryUrl(
                        $file->path,
                        now()->addHours(24),
                        ['ResponseContentDisposition' => 'attachment; filename=' . $file->name
                    ])
                ]
            ]);
    }
}
