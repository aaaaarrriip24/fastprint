<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table thead th {
            background: #f9fafb;
            border-bottom: 1px solid #eef2f7;
        }

        .table tbody tr:hover {
            background: #f7faff;
        }

        .dataTables_wrapper .dt-buttons .btn {
            margin-right: .5rem;
        }

        .dataTables_wrapper .dataTables_paginate .pagination {
            margin: 0;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: none !important;
            text-align: right !important;
        }

    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="mb-0">Halaman Produk</h4>
                    <button id="btnOpenAddProduct" class="btn btn-primary">
                        + Tambah Produk
                    </button>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <select id="filter_jual" class="form-select">
                            <option value="">-- Semua Produk --</option>
                            <option value="jual">Bisa Dijual</option>
                            <option value="tidak">Tidak Bisa Dijual</option>
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <table class="table table-striped table-hover mb-0" id="tbSP">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>ID Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- rows via JS --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- MODAL ADD --}}
            <div class="modal fade" id="modalAddProduct" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form id="formAddProduct">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk"
                                        placeholder="Masukkan nama produk">
                                </div>

                                <div class="mb-3">
                                    <label>Harga</label>
                                    <input type="number" class="form-control" name="harga"
                                        placeholder="Masukkan harga produk" min="0" step="1">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori_id" id="add_kategori_id" class="form-select">
                                        <option value="">-- Pilih Kategori --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status_id" id="add_status_id" class="form-select">
                                        <option value="">-- Pilih Status --</option>
                                    </select>
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- MODAL EDIT --}}
            <div class="modal fade" id="modalEditProduct" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form id="formEditProduct">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="id_produk" name="id_produk">

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="edit_nama_produk"
                                        placeholder="Nama produk">
                                </div>

                                <div class="mb-3">
                                    <label>Harga</label>
                                    <input type="number" class="form-control" name="harga" id="edit_harga"
                                        placeholder="Harga produk" min="0" step="1">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori_id" id="edit_kategori_id" class="form-select">
                                        <option value="">-- Pilih Kategori --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status_id" id="edit_status_id" class="form-select">
                                        <option value="">-- Pilih Status --</option>
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </main>
    </div>

    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables core -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    {{-- Optional libs --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

    <script>
        // CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        // URL
        const U = {
            data: "{{ route('product.data') }}",
            store: "{{ route('product.store') }}",
            show: id => "{{ url('/products') }}/" + id,
            update: id => "{{ url('/products') }}/" + id,
            del: id => "{{ url('/products') }}/" + id,

            kategori: "{{ url('/kategori/list') }}",
            status: "{{ url('/status/list') }}"
        };

        //  HELPER LOAD SELECT
        function loadSelect(url, $el, selected = null) {
            $.get(url, res => {
                $el.empty().append('<option value="">-- Pilih --</option>');
                res.data.forEach(v => {
                    $el.append(`
                        <option value="${v.id}" ${selected == v.id ? 'selected' : ''}>
                            ${v.nama}
                        </option>
                    `);
                });
            });
        }

        //  INIT
        let dtProducts;
        let modalAdd = new bootstrap.Modal('#modalAddProduct');
        let modalEdit = new bootstrap.Modal('#modalEditProduct');

        $(function () {

            // DATATABLE
            dtProducts = $('#tbSP').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: U.data,
                    data: function (d) {
                        d.filter_jual = $('#filter_jual').val();
                    }
                },
                pageLength: 10,
                order: [
                    [1, 'asc']
                ],
                dom: "<'row mb-3'<'col-md-6'l><'col-md-6 text-end'f>>" +
                    "<'table-responsive'tr>" +
                    "<'row mt-3'<'col-md-5'i><'col-md-7 text-end'p>>",
                columns: [{
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: (d, t, r, m) => m.row + m.settings._iDisplayStart + 1
                    },
                    {
                        data: 'id_produk'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'harga'
                    },
                    {
                        data: 'kategori.nama'
                    },
                    {
                        data: 'status.nama'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: r => `
                    <button class="btn btn-sm btn-warning btn-edit" data-id="${r.id}">Edit</button>
                    <button class="btn btn-sm btn-danger btn-del" data-id="${r.id}">Hapus</button>
                `
                    }
                ]
            });

            // FILTER CHANGE
            $('#filter_jual').on('change', function () {
                dtProducts.ajax.reload();
            });

            // OPEN ADD
            $('#btnOpenAddProduct').on('click', () => {
                $('#formAddProduct')[0].reset();
                loadSelect(U.kategori, $('#add_kategori_id'));
                loadSelect(U.status, $('#add_status_id'));
                modalAdd.show();
            });

            // SUBMIT ADD
            $('#formAddProduct').on('submit', function (e) {
                e.preventDefault();

                const harga = $('input[name="harga"]', this).val();

                if (!/^\d+$/.test(harga)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Input tidak valid',
                        text: 'Harga harus berupa angka'
                    });
                    return;
                }

                $.post(U.store, $(this).serialize())
                    .done(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message ?? 'Produk berhasil ditambahkan',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        modalAdd.hide();
                        dtProducts.ajax.reload(null, false);
                        $('#formAddProduct')[0].reset();
                    })
                    .fail(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON?.message ?? 'Gagal menambahkan produk'
                        });
                    });
            });


            // OPEN EDIT
            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');

                $.get(U.show(id), res => {
                    const d = res.data;

                    $('#id_produk').val(d.id_produk);
                    $('#edit_nama_produk').val(d.nama_produk);
                    $('#edit_harga').val(d.harga);

                    loadSelect(U.kategori, $('#edit_kategori_id'), d.kategori_id);
                    loadSelect(U.status, $('#edit_status_id'), d.status_id);

                    modalEdit.show();
                });
            });

            // SUBMIT EDIT
            $('#formEditProduct').on('submit', function (e) {
                e.preventDefault();

                const id = $('#id_produk').val();

                if (!id) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'ID produk tidak ditemukan'
                    });
                    return;
                }

                $.ajax({
                    url: `/products/${id}`,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        
                        modalEdit.hide();
                        dtProducts.ajax.reload(null, false);
                    },
                    error: err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON?.message ?? 'Gagal update produk'
                        });

                        console.error(err.responseJSON);
                    }
                });
            });


            // DELETE
            $(document).on('click', '.btn-del', function () {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus produk?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus'
                }).then(r => {
                    if (r.isConfirmed) {
                        $.ajax({
                            url: U.del(id),
                            method: 'DELETE'
                        }).done(() => {
                            dtProducts.ajax.reload(null, false);
                        });
                    }
                });
            });

            $(document).on('input', '#edit_harga, #add_harga', function () {
                const val = $(this).val();

                if (!/^\d*$/.test(val)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Harga tidak valid',
                        text: 'Harga hanya boleh angka',
                        timer: 1200,
                        showConfirmButton: false
                    });

                    $(this).val(val.replace(/\D/g, ''));
                }
            });

        });
    </script>
</body>

</html>
