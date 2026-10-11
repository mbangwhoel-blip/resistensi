@if ($paginator->hasPages() || $paginator->total() > 0)
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs w-full">
        
        {{-- INFORMASI JUMLAH DATA --}}
        <div class="flex flex-wrap items-center gap-2 text-slate-500 font-medium text-xs">
            @if ($paginator->total() > 0)
                <span>Menampilkan data <strong class="text-slate-800 font-bold">{{ $paginator->firstItem() }}</strong> - <strong class="text-slate-800 font-bold">{{ $paginator->lastItem() }}</strong> dari total <strong class="text-slate-900 font-extrabold">{{ number_format($paginator->total()) }}</strong> data</span>
            @else
                <span>Tidak ada data untuk ditampilkan</span>
            @endif
        </div>

        {{-- TOMBOL KONTROL HALAMAN --}}
        <div class="inline-flex items-center gap-1">
            
            {{-- TOMBOL PREVIOUS (SEBELUMNYA) --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-400 cursor-not-allowed">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 hover:border-blue-400 hover:text-blue-600 transition cursor-pointer">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Sebelumnya</span>
                </a>
            @endif

            {{-- DAFTAR NOMOR HALAMAN --}}
            @if ($paginator->hasPages())
                <div class="inline-flex items-center gap-1 mx-1">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="inline-flex h-7 w-7 items-center justify-center text-xs text-slate-400 font-medium">...</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white shadow-2xs">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition cursor-pointer">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @else
                <div class="inline-flex items-center gap-1 mx-1">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white shadow-2xs">
                        1
                    </span>
                </div>
            @endif

            {{-- TOMBOL NEXT (SELANJUTNYA) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 hover:border-blue-400 hover:text-blue-600 transition cursor-pointer">
                    <span>Selanjutnya</span>
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-400 cursor-not-allowed">
                    <span>Selanjutnya</span>
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif

        </div>

    </nav>
@endif
