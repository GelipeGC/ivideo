<?php

namespace App\Http\Repositories;

use App\Models\File;
use Aws\S3\PostObjectV4;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;
use Illuminate\Support\Facades\Storage;

class FileRepository
{
    protected $model;

    public function __construct(File $file)
    {
        return $this->model = $file;
    }

    public function all(Request $request)
    {
        return FileResource::collection($request->user()->files);
    }
    public function create(Request $request)
    {
        $file = $request->user()->files()->firstOrCreate($request->only('path'), $request->only('name', 'size'));

        return new FileResource($file);
    }
    public function delete(File $file)
    {
        $file->delete();
    }
    public function signedURL(Request $request)
    {
        $filename = md5($request->name . microtime()) . '.' . $request->extension;

        $userId = auth()->user()->id;

        $object = new PostObjectV4(
            Storage::disk('s3')->getAdapter()->getClient(),
            config('filesystems.disks.s3.bucket'),
            ['key' => "files/$userId/$filename"],
            [
                ['bucket' => config('filesystems.disks.s3.bucket')],
                ['starts-with', '$key', "files/$userId"]
            ]
        );

        return response()->json([
            'attributes' => $object->getFormAttributes(),
            'additionalData' => $object->getFormInputs()
        ]);
    }
}
