<x-app-layout>
    <style>
        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .form-card { background: #1e293b; border-color: #334155; }
        
        .form-card-header {
            background: linear-gradient(to right, #ffffff, #f8fafc);
            border-bottom: 1px solid #f1f5f9;
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .dark .form-card-header { background: linear-gradient(to right, #1e293b, #0f172a); border-bottom-color: #334155; }

        .header-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px;
            box-shadow: 0 8px 16px rgba(37,99,235,0.25);
        }

        .header-text h3 {
            font-size: 18px; font-weight: 700; color: #1e293b; margin: 0;
            letter-spacing: -0.3px;
        }
        .dark .header-text h3 { color: #f8fafc; }
        .header-text p {
            font-size: 12px; color: #64748b; margin: 2px 0 0 0;
        }

        .avatar-upload-box {
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 4px solid #f8fafc;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            background: #f1f5f9;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }
        .dark .avatar-upload-box { border-color: #1e293b; background: #0f172a; }

        .avatar-upload-box img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .avatar-upload-box .overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.5);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            color: white; font-size: 13px; font-weight: 500;
            opacity: 0; transition: opacity 0.3s;
        }
        .avatar-upload-box:hover .overlay { opacity: 1; }
        
        .input-group-custom { position: relative; margin-bottom: 20px; }
        .input-group-custom .icon-wrapper {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 15px; pointer-events: none;
        }
        .input-group-custom .form-control, .input-group-custom .form-select {
            padding: 12px 16px 12px 42px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-size: 14px; color: #334155;
            transition: all 0.2s;
        }
        .dark .input-group-custom .form-control, .dark .input-group-custom .form-select {
            background: #0f172a; border-color: #334155; color: #f8fafc;
        }
        .input-group-custom .form-control:focus, .input-group-custom .form-select:focus {
            background: #ffffff; border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .dark .input-group-custom .form-control:focus, .dark .input-group-custom .form-select:focus {
            background: #1e293b;
        }

        .btn-submit {
            padding: 12px 24px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white; border-radius: 12px; font-size: 14px; font-weight: 600;
            border: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s; box-shadow: 0 4px 12px rgba(16,185,129,0.2);
            text-decoration: none;
        }
        .btn-submit:hover {
            transform: translateY(-2px); box-shadow: 0 6px 16px rgba(16,185,129,0.3);
            color: white;
        }
        
        .btn-cancel {
            padding: 12px 24px;
            background: white; border: 1px solid #e2e8f0;
            color: #475569; border-radius: 12px; font-size: 14px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s; text-decoration: none;
        }
        .dark .btn-cancel { background: #1e293b; border-color: #334155; color: #cbd5e1; }
        .btn-cancel:hover { background: #f1f5f9; color: #1e293b; }
        .dark .btn-cancel:hover { background: #334155; color: #f8fafc; }
    </style>

    <x-slot name="header">Manajemen Data Petugas</x-slot>

    <div class="container-fluid py-4">
        
        @if ($errors->any())
        <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4" style="background:#fef2f2; color:#991b1b;">
            <div class="d-flex align-items-center gap-2 mb-2 fw-bold">
                <i class="fas fa-exclamation-circle"></i> Terdapat Kesalahan:
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-card">
            <div class="form-card-header">
                <div class="header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="header-text">
                    <h3>{{ isset($user) ? 'Edit Data Petugas' : 'Tambah Petugas Baru' }}</h3>
                    <p>Lengkapi formulir di bawah ini untuk {{ isset($user) ? 'memperbarui profil' : 'menambahkan' }} petugas.</p>
                </div>
            </div>

            <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST" enctype="multipart/form-data" class="p-4 p-md-5">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="row g-5">
                    <!-- Kiri: Foto -->
                    <div class="col-md-4 text-center">
                        <label class="fw-semibold text-muted d-block mb-3">Foto Profil</label>
                        
                        <div class="avatar-upload-box" onclick="document.getElementById('foto').click()">
                            @if(isset($user) && $user->foto)
                                <img id="photo-preview" src="{{ asset('storage/' . $user->foto) }}" alt="Preview">
                            @else
                                <img id="photo-preview" src="" alt="Preview" class="d-none">
                                <i id="photo-icon" class="fas fa-camera text-secondary" style="font-size: 40px;"></i>
                            @endif
                            <div class="overlay">
                                <i class="fas fa-upload mb-1"></i> Pilih Foto
                            </div>
                        </div>
                        <input type="file" name="foto" id="foto" accept="image/*" class="d-none" onchange="previewImage(this)">
                        
                        <div class="mt-3 text-muted" style="font-size: 12px;">
                            Format: JPG, PNG, WEBP<br>Maks: 5MB
                        </div>
                    </div>

                    <!-- Kanan: Form Data -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">Nama Lengkap</label>
                            <div class="input-group-custom">
                                <div class="icon-wrapper"><i class="fas fa-user"></i></div>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">Alamat Email</label>
                            <div class="input-group-custom">
                                <div class="icon-wrapper"><i class="fas fa-envelope"></i></div>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" placeholder="email@contoh.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">Password</label>
                            <div class="input-group-custom">
                                <div class="icon-wrapper"><i class="fas fa-lock"></i></div>
                                <input type="password" name="password" class="form-control" placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin diubah' : 'Minimal 6 karakter' }}" {{ isset($user) ? '' : 'required' }}>
                            </div>
                            @if(isset($user))
                                <div class="form-text mt-1 text-muted"><i class="fas fa-info-circle me-1"></i>Abaikan field ini jika tidak ingin mengganti password.</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small text-uppercase">Hak Akses (Role)</label>
                            <div class="input-group-custom">
                                <div class="icon-wrapper"><i class="fas fa-id-badge"></i></div>
                                <select name="role" class="form-select" required>
                                    <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                        </div>
                        
                        <hr class="my-4" style="border-color: #e2e8f0;">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('user.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> {{ isset($user) ? 'Simpan Perubahan' : 'Tambah Petugas' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('photo-preview');
                    var icon = document.getElementById('photo-icon');
                    
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    
                    if(icon) {
                        icon.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
