<?php

namespace App\Http\Controllers;

use App\Models\{File, Folder};
use App\Http\Requests\FolderRequest;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    public function tambah()
    {
        $folderId = request('f') ?? '';
        return view('folder.tambah', compact('folderId'));
    }

    public function simpan(Folder $folder, FolderRequest $folderRequest)
    {
        $data = $folderRequest->validated();
        $data['user_id'] = auth()->user()->id;
        $data['folder_id'] = request('f') ?? null;

        $folder->create($data);

        return redirect(route('dashboard.home') . '?f=' . request('f') ?? '');
    }

    public function edit(Folder $folder)
    {
        return view('folder.edit', compact('folder'));
    }

    public function update(Folder $folder, FolderRequest $folderRequest)
    {
        $data = $folderRequest->validated();

        $folder->update($data);

        return redirect(route('dashboard.home') . '?f=' . $folder->folder_id)->with('success', 'Folder berhasil diedit.');
    }

    public function hapus(Folder $folder, File $file)
    {
        // hapus semua folder di dalam folder ini
        $folder->where('folder_id', $folder->id)->delete();

        // hapus semua fild di folder ini
        $dataFile = $file->where('folder_id', $folder->id)->get();
        foreach ($dataFile as $files) {
            Storage::delete($files->path);
            $files->delete();
        }

        // hapus foldernya
        $folder->delete();

        return back()->with('success', 'Folder berhasil dihapus.');
    }
}
