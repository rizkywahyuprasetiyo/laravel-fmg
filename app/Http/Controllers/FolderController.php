<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Requests\FolderRequest;

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
}
