<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-royal-navy leading-tight italic font-playfair">
            {{ __('Manajemen & Unggah Berkas Resume') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Upload Form Card -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gold/10 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gold/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                
                <div class="p-10 relative z-10">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="w-12 h-12 bg-royal-navy rounded-2xl flex items-center justify-center text-gold shadow-lg shadow-royal-navy/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-royal-navy uppercase tracking-tight">Unggah Berkas Baru</h3>
                            <p class="text-xs font-bold text-gold-dark uppercase tracking-widest mt-1">Pilih PDF, Foto, atau Dokumen untuk disimpan secara aman</p>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold text-sm animate-bounce">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('reports.upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nama Berkas (Opsional)</label>
                                <input type="text" name="name" placeholder="Misal: Penyaluran Tahap 1" class="w-full bg-silk border-gold/10 rounded-2xl p-4 focus:ring-gold focus:border-gold font-bold text-royal-navy placeholder-slate-300">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Kategori Berkas</label>
                                <select name="category" class="w-full bg-silk border-gold/10 rounded-2xl p-4 focus:ring-gold focus:border-gold font-bold text-royal-navy">
                                    <option value="resume">Resume Harian/Mingguan</option>
                                    <option value="finance">Laporan Keuangan</option>
                                    <option value="activities">Foto & Bukti Kegiatan</option>
                                    <option value="legal">Dokumen Legal / SPTJ</option>
                                    <option value="general">Lain-lain</option>
                                </select>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="group flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gold/20 rounded-3xl cursor-pointer bg-silk hover:bg-white hover:border-gold transition-all duration-500">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gold-dark group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="mb-2 text-sm text-royal-navy font-black uppercase tracking-tight">Seret berkas atau klik untuk memilih</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">PDF, JPG, PNG, DOCX, XLSX (Max 10MB)</p>
                                </div>
                                <input type="file" name="document" class="hidden" required />
                            </label>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-10 py-4 bg-royal-navy text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl hover:bg-gold transition-all transform hover:-translate-y-1 active:scale-95 flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Unggah Berkas Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List of Uploaded Documents -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gold/10">
                <div class="p-10">
                    <h3 class="text-xl font-black text-royal-navy uppercase tracking-tight mb-8 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-gold/10 text-gold flex items-center justify-center mr-3 font-playfair italic">D</span>
                        Daftar Berkas Terunggah
                    </h3>

                    @if($documents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gold/10">
                                    <th class="py-4 px-6 text-[10px] font-black text-gold-dark uppercase tracking-widest">Nama Berkas</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-gold-dark uppercase tracking-widest">Katehori</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-gold-dark uppercase tracking-widest">Diunggah Oleh</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-gold-dark uppercase tracking-widest">Waktu</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-gold-dark uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($documents as $doc)
                                <tr class="hover:bg-silk transition-colors group">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-lg bg-royal-navy/5 flex items-center justify-center">
                                                @if(in_array($doc->extension, ['jpg', 'png', 'jpeg']))
                                                    <svg class="w-4 h-4 text-royal-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @else
                                                    <svg class="w-4 h-4 text-royal-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <span class="font-black text-royal-navy text-xs uppercase tracking-tight">{{ $doc->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 bg-royal-navy/5 text-[9px] font-black text-royal-navy rounded-full uppercase tracking-widest border border-royal-navy/10">{{ $doc->category }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-[10px] font-bold text-slate-500 uppercase">{{ $doc->user->name }}</td>
                                    <td class="py-4 px-6 text-[10px] font-bold text-slate-400">{{ $doc->created_at->translatedFormat('d M Y, H:i') }}</td>
                                    <td class="py-4 px-6">
                                        <a href="{{ Storage::url($doc->path) }}" target="_blank" class="text-gold-dark hover:text-gold font-black text-xs uppercase tracking-widest flex items-center group-hover:translate-x-1 transition-transform">
                                            Unduh
                                            <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-20 bg-silk rounded-3xl border border-dashed border-gold/20">
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Belum ada berkas yang diunggah.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
