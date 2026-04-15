<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-xs font-bold text-gold-dark uppercase tracking-[0.3em] mb-1">Health & Nutrition</span>
            <h2 class="text-3xl font-playfair font-black text-royal-navy italic leading-tight">
                Konsultasi Gizi Pribadi
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Side: Information -->
            <div class="lg:w-2/5 space-y-8">
                <div class="space-y-4">
                    <h3 class="text-4xl font-playfair font-black text-royal-navy leading-tight">Optimalkan <span class="text-gold-premium italic">Kesehatan</span> Anda.</h3>
                    <p class="text-royal-navy/60 leading-relaxed font-medium">
                        Dapatkan panduan nutrisi yang dipersonalisasi dari ahli gizi profesional kami. Kami membantu Anda mencapai tujuan kesehatan melalui pola makan yang tepat dan seimbang.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-6 bg-white rounded-3xl border border-gold/10 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-gold-light/30 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 14.535a12.02 12.02 0 0010.182 9.026 12.022 12.022 0 0010.182-9.026L21.618 5.724z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-playfair font-bold text-royal-navy">Terverifikasi Ahli</h4>
                            <p class="text-xs text-royal-navy/50 font-medium">Konsultasi langsung dengan ahli gizi bersertifikat.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white rounded-3xl border border-gold/10 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-gold-light/30 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-playfair font-bold text-royal-navy">Personalisasi Cepat</h4>
                            <p class="text-xs text-royal-navy/50 font-medium">Rencana diet yang disesuaikan dengan profil tubuh Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-royal-navy rounded-[2.5rem] relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gold/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                    <p class="text-gold-light font-playfair italic text-lg relative z-10">"Kesehatan bukan sekadar apa yang Anda makan, tetapi apa yang Anda pikirkan dan rasakan."</p>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="lg:w-3/5">
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gold/5 border border-gold/10 overflow-hidden">
                    <div class="p-10 space-y-8">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-playfair font-black text-royal-navy uppercase tracking-tight">Form Pendaftaran</h3>
                            <div class="bg-gold-light/20 text-gold-dark text-[10px] font-black px-3 py-1 rounded-full tracking-widest uppercase italic">Step 01 / Basic Info</div>
                        </div>

                        <!-- Alerts -->
                        @if(session('success'))
                            <div class="p-6 bg-emerald-50 border border-emerald-200 rounded-3xl flex items-center gap-4 animate-bounce">
                                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm font-bold text-emerald-800 leading-tight">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="p-6 bg-red-50 border border-red-200 rounded-3xl space-y-2">
                                <p class="text-xs font-black text-red-600 uppercase tracking-widest">Terdapat Kesalahan:</p>
                                <ul class="list-disc list-inside text-xs font-bold text-red-800">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('nutrition.consultation.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Nama Lengkap</label>
                                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                                        class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-bold text-royal-navy transition-all duration-300 placeholder:text-royal-navy/20">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Umur (Tahun)</label>
                                    <input type="number" name="age" required placeholder="25"
                                        class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-bold text-royal-navy transition-all duration-300 placeholder:text-royal-navy/20">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Berat Badan (kg)</label>
                                    <div class="relative group">
                                        <input type="number" step="0.1" name="weight" required placeholder="65.0"
                                            class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-bold text-royal-navy transition-all duration-300">
                                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                            <span class="text-xs font-black text-gold-dark italic">KG</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Tinggi Badan (cm)</label>
                                    <div class="relative group">
                                        <input type="number" name="height" required placeholder="170"
                                            class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-bold text-royal-navy transition-all duration-300">
                                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                            <span class="text-xs font-black text-gold-dark italic">CM</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Tujuan Utama Konsultasi</label>
                                <select name="goal" required
                                    class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-bold text-royal-navy transition-all duration-300 appearance-none">
                                    <option value="" disabled selected>Pilih Tujuan...</option>
                                    <option value="weight_loss">Menurunkan Berat Badan</option>
                                    <option value="muscle_gain">Meningkatkan Massa Otot</option>
                                    <option value="health_maintenance">Menjaga Kesehatan Umum</option>
                                    <option value="medical_diet">Diet Kondisi Medis Khusus</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Riwayat Alergi / Kondisi Medis</label>
                                <textarea name="medical_history" rows="3" placeholder="Sebutkan jika ada..."
                                    class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-medium text-royal-navy transition-all duration-300 placeholder:text-royal-navy/20"></textarea>
                            </div>

                            <button type="submit" 
                                class="w-full bg-royal-navy hover:bg-gold-premium text-white hover:text-royal-navy font-playfair font-black text-xl py-6 rounded-2xl transition-all duration-500 shadow-xl shadow-royal-navy/10 flex items-center justify-center gap-3 group">
                                <span>DAFTAR SEKARANG</span>
                                <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
