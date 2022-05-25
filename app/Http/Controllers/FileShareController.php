<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Repositories\FileShareRepository;

class FileShareController extends Controller
{
    private $fileShareRepository;
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(FileShareRepository $file)
    {
        $this->fileShareRepository = $file;
    }
    public function createShareUrl(Request $request, File $file)
    {
        $this->authorize('create-link', $file);

        return $this->fileShareRepository->generateShareUrl($request, $file);
    }
    public function downloadFile(Request $request, File $file)
    {
        return $this->fileShareRepository->downloadFile($request, $file);

    }
}
