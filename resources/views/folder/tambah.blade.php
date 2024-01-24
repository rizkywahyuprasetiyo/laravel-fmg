@extends('layouts.base', ['title' => 'Tambah Folder'])
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tambah Folder</h1>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary">Tambah Folder</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('folder.simpan') . '?f=' . $folderId ?? '' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Folder</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Berikan nama folder" value="{{ old('nama') }}">
                            @error('nama')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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