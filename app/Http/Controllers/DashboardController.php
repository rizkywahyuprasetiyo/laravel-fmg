<?php

namespace App\Http\Controllers;

use App\Models\{File, Folder};

class DashboardController extends Controller
{
    public function index(Folder $folder, File $file)
    {
        $meta = $folder->find(request('f'));

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

        return view('index', compact('folders', 'files', 'meta'));
    }
}
