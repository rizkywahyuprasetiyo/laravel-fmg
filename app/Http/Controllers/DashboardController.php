<?php

namespace App\Http\Controllers;

use App\Models\{File, Folder};

class DashboardController extends Controller
{
    public function index(Folder $folder, File $file)
    {
        $parent = $folder->find(request('f'))?->folder_id;

        $folders = $folder
            ->when(request('f') != '', function ($query) {
                $query->where('folder_id', request('f'));
            })
            ->when(request('f') == '', function ($query) {
                $query->whereNull('folder_id');
            })
            ->orderBy('nama', 'asc')->get();

        $files = $file
            ->when(request('f') != '', function ($query) {
                $query->where('folder_id', request('f'));
            })
            ->when(request('f') == '', function ($query) {
                $query->whereNull('folder_id');
            })
            ->orderBy('nama', 'asc')->get();


        // if (request('f')) {
        //     $folders = $folder->where('folder_id', request('f'))->orderBy('nama', 'asc')->get();
        //     $files = $file->where('folder_id', request('f'))->orderBy('nama', 'asc')->get();
        // }

        // if (!request('f')) {
        //     $folders = $folder->whereNull('folder_id')->orderBy('nama', 'asc')->get();
        //     $files = $file->whereNull('folder_id')->orderBy('nama', 'asc')->get();
        // }

        return view('index', compact('folders', 'files', 'parent'));
    }
}
