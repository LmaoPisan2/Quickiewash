@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'History Laundry', 'titleSub' => ''. ucfirst(Auth::user()->auth). ' : '. Auth::user()->nama])
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<script src="{{ asset('js/custom.js') }}"></script>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Header Card -->
        <div class="card" style="background-color: #f56d37; padding-left: 20px;">
            <h5 class="mb-4 fw-bold text-white" style="border: 2px solid white; padding: 10px 20px; border-radius: 5px; display: inline-flex; justify-content: center; align-items: center;">
                Order History
            </h5>
            <div class="card-body text-center">
            </div>
        </div>
        {{-- Order History --}}
        <!-- Table -->
        <div class="card shadow border border-2 text-black" style="width: 100rem">
            <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead class="text-black fw-bold">
                        <tr class="border-bottom">
                            <th class="p-3 text-orange">ID</th>
                            <th class="p-3 text-orange">Nama Customer</th>
                            <th class="p-3 text-orange">Tanggal Masuk</th>
                            <th class="p-3 text-orange ">Tanggal Selesai</th>
                            <th class="p-3 text-orange ">Harga (Rp)</th>
                            <th class="p-3 text-orange ">Bukti</th>
                            <th class="p-3 text-orange">Status Pembayaran</th>
                            <th class="p-3 text-orange">Status Laundry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                        @if($pembayaran->status >= 0)
                        <tr class="bg-white">
                            <td>{{$pembayaran->id_customer}}</td>
                            <td>{{$pembayaran->users->nama}}</td>
                            <td>{{$pembayaran->tanggal_mulai}}</td>
                            <td>{{$pembayaran->tanggal_selesai}}</td>
                            <td>{{$pembayaran->total}}</td>
                            <td>
                                @if ($pembayaran->bukti)
                                <button type="button"
                                        class="btn btn-sm text-white"
                                        style="background-color: #f56d37"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewBuktiModal"
                                        data-bukti="{{ asset('storage/' . $pembayaran->bukti) }}">
                                    File
                                </button>
                            @else
                                @if (Auth::user()->auth == 'admin')
                                    <!-- If no proof exists, admin sees this message -->
                                    <span>Belum ada bukti</span>
                                @else
                                    <!-- Regular user can upload proof -->
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-id="{{ $pembayaran->id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#uploadBuktiModal">
                                        Upload Bukti
                                    </button>
                                @endif
                            @endif
                            </td>
                            <td>
                                @if (Auth::user()->auth  == "admin")
                                    <select class="form-select form-select-sm" id="statusBukti" onchange="updateStatus(this.value, {{$pembayaran->id}}, 'bukti')">
                                        <option value="0" {{ !$pembayaran->status_bukti != 1 ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="1" {{ $pembayaran->status_bukti == 1 ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                @else
                                    {{ $pembayaran->status_bukti == 1 ? 'Lunas' : 'Belum Lunas' }}
                                @endif
                            </td>
                            <td>
                                @if (Auth::user()->auth  == "admin")
                                    <select class="form-select form-select-sm" id="statusBukti" onchange="updateStatus(this.value, {{$pembayaran->id}}, 'status')">
                                        <option value="0" {{ $pembayaran->status != 1 ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="1" {{ $pembayaran->status == 1 ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                @else
                                    {{ $pembayaran->status == 1 ? 'Selesai' : 'Dalam Proses' }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->auth == "admin")
<script>
    function updateStatus(value, pembayaranId, typeStatus) {
        if (!value || !pembayaranId) {
            alert("Data tidak valid!");
            return;
        }
        fetch("{{ route('pages.updateStatus') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                status: value,
                pembayaran_id: pembayaranId,
                type: typeStatus,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeStatus == 'bukti') {
                    alert("Status Pembayaran diperbaharui!");
                } else {
                    alert("Status Laundry diperbaharui!");
                }
                window.reload();
            } else {
                alert("Terjadi kesalahan. Silakan coba lagi.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Terjadi kesalahan dalam koneksi.");
        });
    }
</script>
@else
<!-- Modal -->
<div class="modal fade" id="viewBuktiModal" tabindex="-1" aria-labelledby="viewBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBuktiModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- The Image will be dynamically added here -->
                <img id="buktiImage" src="#" alt="Bukti Pembayaran" class="img-fluid d-none">
                <p id="buktiText" class="text-muted d-none">Tidak dapat memuat file bukti.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadBuktiModalLabel">Upload Bukti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadBuktiForm" action="{{ route('upload.bukti') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Input Tersembunyi untuk Pembayaran ID -->
                    <input type="hidden" name="id_pembayaran" id="id_pembayaran" value="">

                    <div class="mb-3">
                        <label for="fileBukti" class="form-label">Pilih File Bukti</label>
                        <input type="file" class="form-control" id="fileBukti" name="file_bukti" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="preview" class="form-label">Preview File</label>
                        <img id="filePreview" src="#" alt="Preview File" class="img-thumbnail d-none" style="max-width: 100%; height: auto;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="uploadBuktiForm" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>
<script>
    const viewBuktiModal = document.getElementById('viewBuktiModal');
viewBuktiModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;  // Button that triggered the modal
    const buktiUrl = button.getAttribute('data-bukti');  // Get file path from data attribute
    const buktiImage = document.getElementById('buktiImage');
    const buktiText = document.getElementById('buktiText');

    if (buktiUrl) {
        buktiImage.src = buktiUrl; // Set the image source to the URL
        buktiImage.classList.remove('d-none'); // Show the image
        buktiText.classList.add('d-none'); // Hide the error text
    } else {
        buktiImage.classList.add('d-none'); // Hide the image if no URL
        buktiText.classList.remove('d-none'); // Show error text
    }
});
</script>

<script>
    const uploadBuktiModal = document.getElementById('uploadBuktiModal');
    uploadBuktiModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const pembayaranId = button.getAttribute('data-id');
        const pembayaranInput = document.getElementById('id_pembayaran');
        pembayaranInput.value = pembayaranId;
    });

    // Preview file
    document.getElementById('fileBukti').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('filePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
        }
    });

    $('#viewBuktiModal').on('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = $(event.relatedTarget);
    
    // Get the file URL from the data-bukti attribute
    var buktiUrl = button.data('bukti');
    
    // Get the modal and the image element inside it
    var modal = $(this);
    var buktiImage = modal.find('#buktiImage');
    var buktiText = modal.find('#buktiText');
    
    // Set the image src to the dynamic URL and show the image
    buktiImage.attr('src', buktiUrl).removeClass('d-none');
    buktiText.addClass('d-none');
    
    // Optionally handle error in case the image fails to load
    buktiImage.on('error', function() {
        buktiImage.addClass('d-none');
        buktiText.removeClass('d-none');
    });
});
</script>


@endif

@endsection
