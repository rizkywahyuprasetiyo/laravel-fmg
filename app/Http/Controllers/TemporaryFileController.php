<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

class TemporaryFileController extends Controller
{
    public function upload(TemporaryFile $temporaryFile, Request $request)
    {
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $extension = $file->extension();
            $fileName = $file->hashName();
            $fileNameUnformatted = $file->getClientOriginalName();
            $size = $file->getSize();
            $folder = Str::ulid();
            $file->storeAs('tmp/', $folder . '/' . $fileName);

            $temporaryFile->create([
                'folder' => $folder,
                'nama_file' => $fileName,
                'nama_file_unformatted' => $fileNameUnformatted,
                'extension' => $extension,
                'size' => $size
            ]);

            return response()->json([
                'data' => $folder
            ]);
        }

        return response()->noContent();
    }

    public function delete(TemporaryFile $temporaryFile, Request $request)
    {
        $fileRequest = $request->getContent();
        $dataPath = json_decode($fileRequest);
        $dataRequest = $dataPath->data;

        $tempFile = $temporaryFile->where('folder', $dataRequest)->first();
        if ($tempFile) {
            Storage::deleteDirectory('tmp/' . $tempFile->folder);
            $tempFile->delete();
            return response()->noContent();
        }
    }
}
