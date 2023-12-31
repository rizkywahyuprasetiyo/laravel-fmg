@extends('layouts.base', ['title' => 'Drive Saya'])
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Drive Saya</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('file.simpan') }}" method="post" enctype="multipart/form-data">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary">Upload File</h6>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="card-body">
                        @csrf
                        <input type="file" name="path" id="path" multiple>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-3">
                    <h4>Drive Saya</h4>
                    <div>
                        <a href="#" class="btn btn-primary"><i class="fas fa-folder-plus"></i> Folder</a>
                        <a href="#" class="btn btn-success"><i class="fas fa-file-upload"></i> File</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Pemilik</th>
                                    <th>Terakhir Diubah</th>
                                    <th>Ukuran File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($folders as $folder)
                                <tr>
                                    <td><a href="#"><i class="far fa-folder"></i> {{ $folder->nama }}</a></td>
                                    <td>{{ $folder->user->name }}</td>
                                    <td>{{ $folder->updated_at->diffForHumans() }}</td>
                                    <td>__</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @foreach($files as $file)
                                <tr>
                                    <td><a href="#"><i class="far fa-file"></i> {{ $file->nama }}</a></td>
                                    <td>{{ $file->user->name }}</td>
                                    <td>{{ $file->updated_at->diffForHumans() }}</td>
                                    <td>{{ $file->size }} byte</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css-libraries')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select.bootstrap4.min.css') }}">
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
@endpush

@push('custom-css')
<style>
    svg {
        vertical-align: baseline;
    }
</style>
@endpush

@push('js-libraries')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/iziToast.min.js') }}"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
@endpush

@push('js-page')
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
    // Register plugin
    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[id="path"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement, {
        labelIdle: 'Seret file ke sini atau klik tulisan ini',
        // plugin validasi type file
        acceptedFileTypes: ['application/pdf'],
        labelFileTypeNotAllowed: 'Jenis file tidak didukung',
        fileValidateTypeLabelExpectedTypes: 'Yang didukung {allButLastType} or {lastType}',
        fileValidateTypeLabelExpectedTypesMap: {
            'application/pdf': '.pdf'
        },
        // validasi ukuran file
        maxFileSize: '200MB',
        labelMaxFileSizeExceeded: 'File yang diupload terlalu besar',
        labelMaxFileSize: 'Ukuran file yang diizinkan {filesize}'
    });
    FilePond.setOptions({
        server: {
            process: '{{ route('tmp.upload') }}',
            revert: '{{ route('tmp.delete') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });
</script>
<script>
    @if(session()->has('success'))
    iziToast.success({
        title: 'Berhasil!',
        message: '{{ session('success') }}',
        position: 'topRight'
    });
    @endif
    @if(session()->has('error'))
    iziToast.error({
        title: 'Gagal!',
        message: '{{ session('error') }}',
        position: 'topRight'
    });
    @endif
</script>
@endpush