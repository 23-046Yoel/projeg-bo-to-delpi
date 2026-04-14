<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    Upload Tanda Tangan
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Spesimen TTD untuk Surat Pesanan (PO)</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-sm font-bold">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-[11px] uppercase tracking-wider">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Staff Info Card -->
            <div class="bg-white/40 backdrop-blur-xl rounded-[3rem] shadow-xl border border-white/60 p-10 mb-8">
                <div class="flex items-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-royal-navy flex items-center justify-center text-gold font-black text-xl shadow-lg mr-5">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xl font-black text-royal-navy uppercase tracking-tight">{{ $user->name }}</p>
                        <p class="text-xs font-bold text-gold uppercase tracking-widest">{{ $user->role_title }}</p>
                        <p class="text-[10px] text-gray-400 font-medium">{{ $user->sppg->name ?? 'Belum ditugaskan' }}</p>
                    </div>
                </div>

                <!-- Current Signature Preview -->
                <div class="mb-8">
                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-4">
                        Tanda Tangan Saat Ini
                    </label>
                    @if($user->signature_path)
                        <div class="border-2 border-dashed border-gold/30 rounded-2xl p-6 bg-white text-center">
                            <img src="{{ asset('storage/' . $user->signature_path) }}"
                                 alt="Tanda Tangan {{ $user->name }}"
                                 class="max-h-32 mx-auto object-contain"
                                 id="current-sig">
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-3">Tanda Tangan Tersimpan</p>
                        </div>
                    @else
                        <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center bg-gray-50">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Belum ada tanda tangan</p>
                        </div>
                    @endif
                </div>

                <!-- Upload Form -->
                <form action="{{ route('users.signature.upload', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-4">
                        Upload Tanda Tangan Baru
                    </label>

                    <!-- Drag & Drop Zone -->
                    <div id="drop-zone"
                         class="border-2 border-dashed border-royal-navy/20 rounded-2xl p-10 text-center cursor-pointer hover:border-gold hover:bg-gold/5 transition-all duration-300"
                         onclick="document.getElementById('sig-input').click()">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm font-black text-royal-navy uppercase tracking-widest">Klik atau Seret File ke Sini</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-2">PNG, JPG — Maks. 2MB — Latar Transparan/Putih</p>

                        <!-- Preview di drop zone -->
                        <img id="preview-img" src="#" alt="Preview" class="hidden max-h-32 mx-auto mt-4 object-contain rounded-xl border border-gold/20">
                    </div>

                    <input type="file" name="signature" id="sig-input" accept="image/png,image/jpg,image/jpeg" class="hidden" required>

                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-3 text-center">
                        💡 Tips: Gunakan tanda tangan di atas kertas putih, foto, lalu potong (crop) dan simpan sebagai PNG untuk hasil terbaik.
                    </p>

                    <div class="mt-8 flex space-x-4">
                        <button type="submit" class="flex-1 py-4 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl hover:bg-royal-navy/90 hover:-translate-y-1 transition-all">
                            Simpan Tanda Tangan
                        </button>
                        <a href="{{ route('users.index') }}" class="px-8 py-4 border-2 border-gray-100 rounded-2xl text-gray-400 font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-gray-50 transition-all flex items-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const input = document.getElementById('sig-input');
        const preview = document.getElementById('preview-img');
        const dropZone = document.getElementById('drop-zone');

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Drag & drop
        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-gold', 'bg-gold/10'); });
        dropZone.addEventListener('dragleave', e => { dropZone.classList.remove('border-gold', 'bg-gold/10'); });
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-gold', 'bg-gold/10');
            const file = e.dataTransfer.files[0];
            if (file) {
                // Transfer to real input
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>
