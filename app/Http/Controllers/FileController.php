<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Requests\FileSignedRequest;
use App\Http\Repositories\FileRepository;

class FileController extends Controller
{
    private $fileRepository;
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(FileRepository $file)
    {
        $this->fileRepository = $file;
    }
    public function index(Request $request)
    {
        return $this->fileRepository->all($request);
    }
    public function store(Request $request)
    {
        return $this->fileRepository->create($request);
    }
    public function destroy(Request $request, File $file)
    {
        $this->authorize('destroy', $file);

        return $this->fileRepository->delete($file);
    }
    public function signedURL(FileSignedRequest $request)
    {
        return $this->fileRepository->signedURL($request);
    }
}
