@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --color-primary: #e74c3c;
            --color-secondary: #2c3e50;
            --color-text-light: #7f8c8d;
            --color-bg-light: #ecf0f1;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --color-border: #e2e8f0;
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--color-secondary);
            text-decoration: none;
            padding: 10px 20px;
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }

        .back-btn:hover {
            background: #f8fafc;
            border-color: var(--color-primary);
            color: var(--color-primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Form Container */
        .form-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        /* Form Header */
        .form-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--color-border);
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .form-header h2 {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-secondary);
            margin: 0;
        }

        .form-header i {
            color: var(--color-primary);
            font-size: 1.25rem;
        }

        /* Form Content */
        .form-content {
            padding: 2rem;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Form Group */
        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-secondary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .required-mark {
            color: var(--color-danger);
        }

        /* Form Controls */
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--color-secondary);
            background: #ffffff;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        .form-control:hover {
            border-color: #cbd5e1;
        }

        /* Select Styling */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org2000/svg' fill='none' viewBox='0 0 24 24' stroke='%237f8c8d'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.25em;
            padding-right: 2.5rem;
        }

        /* Textarea */
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* Price Input */
        .price-input-group {
            position: relative;
        }

        .price-prefix {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-light);
            font-weight: 500;
        }

        .price-input {
            padding-left: 3.5rem !important;
        }

        /* File Upload */
        .file-upload {
            position: relative;
        }

        .file-upload input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed var(--color-border);
            border-radius: 10px;
            background: #f8fafc;
            color: var(--color-text-light);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            border-color: var(--color-primary);
            background: rgba(231, 76, 60, 0.02);
        }

        .file-upload-label i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--color-primary);
        }

        .file-upload-label span {
            font-size: 0.9rem;
        }

        /* Image Preview */
        .image-preview-container {
            margin-bottom: 1.5rem;
        }

        .current-image-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-secondary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .image-preview {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            border: 1px solid var(--color-border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Form Info */
        .form-info {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: var(--color-text-light);
            line-height: 1.4;
        }

        .form-info i {
            margin-top: 1px;
        }

        /* Form Actions */
        .form-actions {
            padding: 2rem;
            border-top: 1px solid var(--color-border);
            background: #f8fafc;
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 576px) {
            .form-actions {
                flex-direction: column;
            }
        }

        /* Buttons */
        .btn {
            padding: 0.875rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary) 0%, #c0392b 100%);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(231, 76, 60, 0.2);
        }

        .btn-secondary {
            background: white;
            color: var(--color-secondary);
            border: 1px solid var(--color-border);
            flex: 1;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: var(--color-primary);
            color: var(--color-primary);
            transform: translateY(-2px);
        }

        /* Full Width Items */
        .full-width {
            grid-column: 1 / -1;
        }

        /* Error Styling */
        .error-message {
            color: var(--color-danger);
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .error-message i {
            font-size: 0.7rem;
        }
    </style>

    <!-- Back Button -->
    <a href="{{ route('admin.vehicles.index') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Daftar
    </a>

    <!-- Form Container -->
    <div class="form-container">
        <!-- Form Header -->
        <div class="form-header">
            <h2>
                <i class="fas fa-plus-circle"></i>
                Tambah Kendaraan Baru
            </h2>
        </div>

        <!-- Form Content -->
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-content">
                <!-- Vehicle Details Grid -->
                <div class="form-grid">
                    <!-- Brand -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag"></i>
                            Merk Kendaraan
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text" 
                               name="brand" 
                               class="form-control" 
                               value="{{ old('brand') }}" 
                               required 
                               placeholder="Contoh: Honda, Toyota, Yamaha">
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-car-side"></i>
                            Tipe/Model
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text" 
                               name="type" 
                               class="form-control" 
                               value="{{ old('type') }}" 
                               required 
                               placeholder="Contoh: Civic, Vario, Avanza">
                    </div>

                    <!-- Plate Number -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-id-card"></i>
                            Plat Nomor
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text" 
                               name="plate_number" 
                               class="form-control" 
                               value="{{ old('plate_number') }}" 
                               required 
                               placeholder="Contoh: B 1234 ABC"
                               style="text-transform: uppercase; font-family: 'Courier New', monospace; font-weight: bold;">
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-list-alt"></i>
                            Kategori
                            <span class="required-mark">*</span>
                        </label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="mobil" {{ old('category') == 'mobil' ? 'selected' : '' }}>
                                🚗 Mobil
                            </option>
                            <option value="motor" {{ old('category') == 'motor' ? 'selected' : '' }}>
                                🏍️ Motor
                            </option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-tags"></i>
                            Harga Sewa per Hari
                            <span class="required-mark">*</span>
                        </label>
                        <div class="price-input-group">
                            <span class="price-prefix">Rp</span>
                            <input type="number" 
                                   name="price_per_day" 
                                   class="form-control price-input" 
                                   value="{{ old('price_per_day') }}" 
                                   required 
                                   min="0" 
                                   step="1000"
                                   placeholder="50000">
                        </div>
                        <div class="form-info">
                            <i class="fas fa-info-circle"></i>
                            Masukkan harga tanpa titik atau koma. Contoh: 50000 untuk Rp 50.000
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-circle"></i>
                            Status
                            <span class="required-mark">*</span>
                        </label>
                        <select name="status" class="form-control" required>
                            <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>
                                <i class="fas fa-check-circle" style="color: #10b981;"></i> Tersedia
                            </option>
                            <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>
                                <i class="fas fa-key" style="color: #f59e0b;"></i> Disewa
                            </option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                <i class="fas fa-tools" style="color: #ef4444;"></i> Maintenance
                            </option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-align-left"></i>
                            Deskripsi (Opsional)
                        </label>
                        <textarea name="description" 
                                  class="form-control" 
                                  rows="4"
                                  placeholder="Masukkan deskripsi kendaraan, fitur, kondisi, dll.">{{ old('description') }}</textarea>
                        <div class="form-info">
                            <i class="fas fa-info-circle"></i>
                            Deskripsi membantu calon penyewa memahami detail kendaraan
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-camera"></i>
                            Foto Kendaraan
                        </label>
                        <div class="file-upload">
                            <input type="file" 
                                   name="image" 
                                   id="image-upload" 
                                   accept="image/*">
                            <label for="image-upload" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Klik untuk mengunggah foto kendaraan</span>
                                <span style="font-size: 0.8rem; margin-top: 0.5rem;">
                                    Format: JPG, PNG, JPEG. Maksimal 2MB.
                                </span>
                            </label>
                        </div>
                        <div class="form-info">
                            <i class="fas fa-info-circle"></i>
                            Rekomendasi ukuran foto: 800x600px. Kosongkan jika belum ada foto.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Kendaraan
                </button>
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- JavaScript for File Upload Preview -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image-upload');
            const fileUploadLabel = document.querySelector('.file-upload-label');
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileUploadLabel.innerHTML = `
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <span>${fileName}</span>
                        <span style="font-size: 0.8rem; margin-top: 0.5rem; color: #10b981;">
                            File siap diunggah
                        </span>
                    `;
                    fileUploadLabel.style.borderColor = '#10b981';
                    fileUploadLabel.style.background = 'rgba(16, 185, 129, 0.05)';
                }
            });
            
            // Auto focus first field with error
            const firstError = document.querySelector('.error-message');
            if (firstError) {
                const input = firstError.closest('.form-group').querySelector('.form-control');
                if (input) input.focus();
            }
        });
    </script>
@endsection