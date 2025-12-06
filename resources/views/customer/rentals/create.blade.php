<x-layouts.customer title="Form Booking">

    {{-- CUSTOM STYLES (inherits from layouts.customer, only adding specific class styles) --}}
    <style>
        :root {
            --color-primary: #e74c3c; /* Red Accent */
            --color-secondary: #2c3e50; /* Dark Grey/Blue */
            --color-text-light: #7f8c8d; /* Grey for minor text */
            --color-bg-light: #ecf0f1; /* Light background */
            --color-dark-text: #111827;
            --color-info-bg: #f4d0d0; /* Very light Red for accents */
        }

        /* Progress Indicator Styles */
        .step-circle {
            width: 36px; 
            height: 36px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: 700; 
            font-size: 14px;
        }
        /* Step 1 & 2 are ACTIVE (using Primary Red) */
        .step-active .step-circle {
            background: var(--color-primary); 
            color: white;
        }
        .step-active span {
            font-weight: 600; 
            color: var(--color-primary);
        }
        /* Step 3 is INACTIVE (using Light Grey/Text Light) */
        .step-inactive .step-circle {
            background: var(--color-bg-light);
            color: var(--color-text-light);
        }
        .step-inactive span {
            font-weight: 500; 
            color: var(--color-text-light);
        }
        .step-connector {
            width: 60px; 
            height: 2px; 
            background: var(--color-bg-light);
        }

        /* Form Controls Overrides */
        .form-control-styled {
            width: 100%; 
            padding: 12px 16px; 
            border: 1.5px solid #d8dbe0; 
            border-radius: 8px; 
            font-size: 15px; 
            transition: all 0.2s; 
            font-family: inherit; 
            resize: vertical;
        }
        
        /* Action Buttons */
        .btn-confirm {
            background: linear-gradient(135deg, var(--color-secondary) 0%, #34495e 100%) !important; /* Use Secondary/Dark for confirmation */
            color: white; 
            border: none; 
            border-radius: 10px; 
            font-weight: 700; 
            font-size: 17px; 
            cursor: pointer; 
            box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
            transition: all 0.3s;
        }
        .btn-confirm:hover {
            transform: translateY(-2px); 
            box-shadow: 0 6px 20px rgba(44, 62, 80, 0.4);
        }
        .btn-cancel {
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: white; 
            color: var(--color-secondary); 
            border: 2px solid var(--color-bg-light); 
            border-radius: 10px; 
            font-weight: 600; 
            font-size: 17px; 
            text-decoration: none; 
            transition: all 0.2s;
        }
        .btn-cancel:hover {
            border-color: var(--color-primary); 
            color: var(--color-primary);
        }
        
        /* Info Notice Box */
        .info-notice-box {
            padding: 16px;
            border-radius: 8px;
            background: var(--color-info-bg); 
            border-left: 4px solid var(--color-primary); 
            color: var(--color-primary);
        }
        .info-notice-box .info-icon {
            color: var(--color-primary);
        }
        .info-notice-box .info-title {
             color: var(--color-secondary);
        }
        .info-notice-box p {
             color: var(--color-secondary);
        }
        
        /* JS Focus/Blur styles using new colors */
        .form-control-styled:focus {
            border-color: var(--color-secondary) !important; 
            box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.1) !important;
        }

        /* Summary Card Styling */
        .summary-card {
             background: var(--color-bg-light); 
             border: 2px solid var(--color-secondary);
        }
        .summary-total-row {
            background: var(--color-info-bg);
            border-top: 1px solid var(--color-primary);
        }
        
    </style>

    <!-- Progress Indicator -->
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: center; align-items: center; gap: 16px;">
            <div class="step-active" style="display: flex; align-items: center;">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <span style="margin-left: 12px;">Pilih Kendaraan</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-active" style="display: flex; align-items: center;">
                <div class="step-circle">2</div>
                <span style="margin-left: 12px;">Isi Detail</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-inactive" style="display: flex; align-items: center;">
                <div class="step-circle">3</div>
                <span style="margin-left: 12px;">Konfirmasi</span>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        
        <h2 style="font-size: 28px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 32px; padding-bottom: 16px; border-bottom: 2px solid var(--color-bg-light);">
            <i class="fas fa-file-alt" style="margin-right: 8px; color: var(--color-primary);"></i> Form Booking Kendaraan
        </h2>

        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px;">
            
            <!-- Vehicle Info Card -->
            <div>
                <div style="position: sticky; top: 24px;">
                    <!-- Vehicle Image -->
                    <div style="border-radius: 12px; overflow: hidden; background: var(--color-bg-light); margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->brand }}" 
                                 style="width: 100%; height: 280px; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 280px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-{{ $vehicle->category == 'motor' ? 'motorcycle' : 'car' }}" style="font-size: 80px; opacity: 0.4; color: var(--color-secondary);"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Vehicle Details -->
                    <div style="background: var(--color-bg-light); padding: 24px; border-radius: 12px;">
                        <h3 style="font-size: 20px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 8px;">
                            {{ $vehicle->brand }} {{ $vehicle->type }}
                        </h3>
                        <div style="display: flex; align-items: center; color: var(--color-text-light); font-size: 14px; margin-bottom: 20px;">
                            <i class="fas fa-map-marker-alt" style="margin-right: 4px;"></i>
                            {{ $vehicle->plate_number }}
                        </div>

                        <!-- Price Display -->
                        <div style="background: var(--color-info-bg); padding: 20px; border-radius: 10px; text-align: center; border: 1px solid var(--color-primary);">
                            <div style="font-size: 13px; color: var(--color-secondary); margin-bottom: 4px;">Harga Sewa</div>
                            <div style="font-size: 28px; font-weight: 700; color: var(--color-primary);">
                                Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 14px; color: var(--color-secondary); margin-top: 2px;">per hari</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div>
                <form action="{{ route('customer.rentals.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    <!-- Date Inputs -->
                    <div style="background: var(--color-bg-light); padding: 28px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #d8dbe0;">
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 20px;">
                            <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i> Pilih Tanggal Sewa
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                                    Tanggal Mulai <span style="color: var(--color-primary);">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" class="form-control-styled" 
                                        value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}" 
                                        onchange="calculateTotal()"
                                        onfocus="this.style.borderColor='var(--color-secondary)'; this.style.boxShadow='0 0 0 3px rgba(44, 62, 80, 0.1)'"
                                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                            </div>

                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                                    Tanggal Selesai <span style="color: var(--color-primary);">*</span>
                                </label>
                                <input type="date" name="end_date" id="end_date" class="form-control-styled" 
                                        value="{{ old('end_date') }}" required min="{{ date('Y-m-d') }}" 
                                        onchange="calculateTotal()"
                                        onfocus="this.style.borderColor='var(--color-secondary)'; this.style.boxShadow='0 0 0 3px rgba(44, 62, 80, 0.1)'"
                                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: var(--color-secondary); margin-bottom: 8px;">
                            <i class="fas fa-pencil-alt" style="margin-right: 4px;"></i> Catatan Tambahan (Opsional)
                        </label>
                        <textarea name="notes" class="form-control-styled" rows="4" 
                                     placeholder="Contoh: Perlu antar ke bandara, atau keperluan khusus lainnya..."
                                     onfocus="this.style.borderColor='var(--color-secondary)'; this.style.boxShadow='0 0 0 3px rgba(44, 62, 80, 0.1)'"
                                     onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Summary Card -->
                    <div class="summary-card" style="padding: 28px; border-radius: 12px; margin-bottom: 24px;">
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--color-dark-text); margin-bottom: 20px;">
                            <i class="fas fa-clipboard-list" style="margin-right: 6px;"></i> Ringkasan Booking
                        </h3>
                        
                        <div style="display: grid; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #d1d5db;">
                                <span style="color: var(--color-text-light); font-size: 15px;">Harga per Hari</span>
                                <span style="font-weight: 600; color: var(--color-secondary); font-size: 15px;">
                                    Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #d1d5db;">
                                <span style="color: var(--color-text-light); font-size: 15px;">Durasi Sewa</span>
                                <span style="font-weight: 600; color: var(--color-secondary); font-size: 15px;">
                                    <span id="totalDays">0</span> hari
                                </span>
                            </div>
                            
                            <div class="summary-total-row" style="padding: 16px 0; margin: 8px -12px -12px -12px; padding-left: 12px; padding-right: 12px; border-radius: 0 0 10px 10px;">
                                <span style="font-weight: 700; color: var(--color-secondary); font-size: 18px;">Total Harga</span>
                                <span style="font-weight: 700; color: var(--color-primary); font-size: 24px;">
                                    Rp <span id="totalPrice">0</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
                        <button type="submit" class="btn-confirm"
                                style="padding: 16px;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(44, 62, 80, 0.4)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(44, 62, 80, 0.3)'">
                            <i class="fas fa-check" style="margin-right: 6px;"></i> Konfirmasi Booking
                        </button>
                        
                        <a href="{{ route('customer.vehicles.show', $vehicle) }}" class="btn-cancel"
                           style="padding: 16px;">
                            <i class="fas fa-times" style="margin-right: 4px;"></i> Batal
                        </a>
                    </div>

                    <!-- Info Notice -->
                    <div style="margin-top: 24px; padding: 16px; border-radius: 8px;" class="info-notice-box">
                        <div style="display: flex; align-items: start;">
                            <i class="fas fa-lightbulb info-icon" style="font-size: 20px; margin-right: 12px;"></i>
                            <div>
                                <div style="font-weight: 600; margin-bottom: 4px; font-size: 14px;" class="info-title">
                                    Tips Booking
                                </div>
                                <p style="font-size: 13px; line-height: 1.5; margin: 0;">
                                    Pastikan data Anda sudah lengkap di profil sebelum melakukan booking. Admin akan menghubungi Anda untuk konfirmasi.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ensure the form controls get the correct styles if they are not using Laravel's form-control class structure
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.add('form-control-styled');
        });

        function calculateTotal() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const pricePerDay = {{ $vehicle->price_per_day }};

            // Set minimum end date to start date
            if (startDate) {
                endDateInput.min = startDate;
            }

            if (startDate && endDate && new Date(endDate) >= new Date(startDate)) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                // Calculate difference in milliseconds
                const diffTime = end.getTime() - start.getTime();
                
                // Calculate difference in days (+1 to include the start day)
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                const totalPrice = diffDays * pricePerDay;
                document.getElementById('totalDays').textContent = diffDays;
                document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('id-ID');
            } else {
                document.getElementById('totalDays').textContent = 0;
                document.getElementById('totalPrice').textContent = 0;
            }
        }

        // Initialize calculation and min date constraints on load
        window.addEventListener('load', function() {
            calculateTotal();
            const startDate = document.getElementById('start_date').value;
            if (startDate) {
                 document.getElementById('end_date').min = startDate;
            }
        });
        
        // Ensure event listeners are attached correctly (already done via onchange inline, but re-adding for robustness)
        document.getElementById('start_date').addEventListener('change', calculateTotal);
        document.getElementById('end_date').addEventListener('change', calculateTotal);
    </script>
</x-layouts.customer>