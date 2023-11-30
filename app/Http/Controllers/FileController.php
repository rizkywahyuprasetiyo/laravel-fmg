<?php

namespace App\Http\Controllers;

use App\Models\{File, TemporaryFile};
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function simpan(File $file, TemporaryFile $temporaryFile, FileRequest $fileRequest)
    {
        // validasi manual apakah ada path yang diinput
        $data = $fileRequest->validated();

        if (!isset($data['path'])) {
            return back()->with('gagal', 'File upload tidak boleh kosong.')->withInput();
        }

        $dataPath = json_decode($data['path']);
        $data['path'] = $dataPath->data;

        $tempFile = $temporaryFile->where('folder', $data['path'])->first();

        if ($tempFile) {
            // cek apakah file ada di storage /tmp
            if (Storage::missing('tmp/' . $tempFile->folder)) {
                $tempFile->delete();
                return back()->with('gagal', 'File telah hilang dari penyimpanan sementara. Silahkan upload ulang.')->withInput();
            }

            // setup upload file
            $fileSementara = 'tmp/' . $tempFile->folder . '/' . $tempFile->nama_file;
            $fileTujuan = 'drive_saya/' . $tempFile->folder . '/' . now()->timestamp . '.' . $tempFile->extension;
            Storage::copy($fileSementara, $fileTujuan);

            $data['path'] = $fileTujuan;
            $data['size'] = $tempFile->size;
            $data['nama'] = $tempFile->nama_file_unformatted;
            $data['user_id'] = auth()->user()->id;
            $data['folder_id'] = request('f') ?? null;

            $file->create($data);

            Storage::deleteDirectory('tmp/' . $tempFile->folder);
            $tempFile->delete();

            return back()->with('success', 'File berhasil diunggah.');
        }

        return back()->with('error', 'File belum diungah.')->withInput();
    }
}
