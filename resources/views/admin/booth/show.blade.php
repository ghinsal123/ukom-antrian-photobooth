@extends('admin.layouts.app')

@section('title', 'Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    {{-- JUDUL HALAMAN --}}
    <h2 class="text-2xl font-semibold text-gray-700 mb-5 text-center">Detail Booth</h2>

    {{-- TAMPILAN GAMBAR BOOTH (SLIDER) --}}
    <div class="relative flex justify-center mb-6">

        @if($booth->gambar && count($booth->gambar) > 0)

            <div class="relative w-72 h-72 overflow-hidden rounded-xl shadow">

                {{-- GAMBAR SLIDER --}}
                <img id="sliderImage"
                     src="{{ asset('storage/'.$booth->gambar[0]) }}"
                     class="w-full h-full object-cover transition-all duration-500 ease-in-out">

            </div>

            {{-- PANAH KIRI --}}
            @if(count($booth->gambar) > 1)
            {{-- PANAH KIRI --}}
            <button onclick="prevImage()" 
                class="absolute left-8 top-1/2 -translate-y-1/2 
                    bg-white/80 hover:bg-white text-gray-700 
                    px-3 py-2 rounded-full shadow-lg
                    transition-all duration-300 hover:scale-110 hover:shadow-xl">
                ◀
            </button>

            {{-- PANAH KANAN --}}
            <button onclick="nextImage()" 
                class="absolute right-8 top-1/2 -translate-y-1/2 
                    bg-white/80 hover:bg-white text-gray-700 
                    px-3 py-2 rounded-full shadow-lg
                    transition-all duration-300 hover:scale-110 hover:shadow-xl">
                ▶
            </button>
            @endif

        @else
            <p class="text-gray-500 italic">Belum ada gambar untuk booth ini.</p>
        @endif
    </div>

    {{-- DOT INDICATOR (ELIPS) --}}
    @if($booth->gambar && count($booth->gambar) > 1)
    <div class="flex justify-center space-x-2 mb-5">
        @foreach($booth->gambar as $i => $g)
            <div id="dot-{{ $i }}"
                class="w-5 h-2 rounded-full bg-gray-300 transition-all duration-300 dot cursor-pointer hover:scale-110 hover:bg-gray-400">
            </div>
        @endforeach
    </div>
    @endif

    {{-- INFORMASI DETAIL BOOTH --}}
    <div class="space-y-3">

        <p><strong>Nama Booth:</strong> {{ $booth->nama_booth }}</p>

        <p><strong>Kapasitas:</strong> Max {{ $booth->kapasitas }} orang</p>

        <p><strong>Dibuat:</strong> 
            {{ $booth->created_at ? $booth->created_at->format('d M Y H:i') : '-' }}
        </p>

        <p><strong>Diedit:</strong> 
            {{ $booth->updated_at ? $booth->updated_at->format('d M Y H:i') : '-' }}
        </p>
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.booth.index') }}"
            class="px-4 py-2 border rounded-xl hover:bg-gray-100">
            Kembali
        </a>
    </div>

</div>

{{-- SCRIPT SLIDER --}}
<script>
    const images = @json($booth->gambar);
    let index = 0;

    function updateDots() {
        images.forEach((_, i) => {
            document.getElementById("dot-" + i).classList.remove("bg-gray-700");
        });
        document.getElementById("dot-" + index).classList.add("bg-gray-700");
    }

    function showImage() {
        const img = document.getElementById('sliderImage');
        img.style.opacity = 0;

        setTimeout(() => {
            img.src = "/storage/" + images[index];
            img.style.opacity = 1;
        }, 200);

        updateDots();
    }

    function nextImage() {
        index = (index + 1) % images.length;
        showImage();
    }

    function prevImage() {
        index = (index - 1 + images.length) % images.length;
        showImage();
    }

    updateDots();
</script>

@endsection
