@extends('Operator.layout')

@section('content')
<h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Detail Booth</h2>

<div class="bg-white rounded-3xl shadow-2xl p-6 max-w-3xl mx-auto mt-8">

    {{-- NAMA BOOTH --}}
    <h2 class="text-3xl font-bold mb-6 text-pink-600 text-center">{{ $booth->nama_booth }}</h2>

    {{-- SLIDER GAMBAR --}}
    <div class="relative flex justify-center mb-6">

        @if ($booth->gambar && count($booth->gambar) > 0)

            <div class="relative w-72 h-72 overflow-hidden rounded-xl shadow">
                <img id="sliderImage"
                     src="{{ asset('storage/' . $booth->gambar[0]) }}"
                     class="w-full h-full object-cover transition-all duration-500 ease-in-out">
            </div>

            {{-- PANAH KIRI --}}
            @if (count($booth->gambar) > 1)
            <button onclick="prevImage()" 
                class="absolute left-20 top-1/2 -translate-y-1/2 
                bg-white/80 hover:bg-white text-gray-700 px-3 py-2 rounded-full shadow-lg
                transition-all duration-300 hover:scale-110 hover:shadow-xl">
                ◀
            </button>

            {{-- PANAH KANAN --}}
            <button onclick="nextImage()" 
                class="absolute right-20 top-1/2 -translate-y-1/2 
                bg-white/80 hover:bg-white text-gray-700 px-3 py-2 rounded-full shadow-lg
                transition-all duration-300 hover:scale-110 hover:shadow-xl">
                ▶
            </button>
            @endif

        @else
            <div class="w-64 h-64 bg-gray-100 flex items-center justify-center rounded-xl shadow-md">
                <span class="text-gray-400 italic">Tidak ada gambar</span>
            </div>
        @endif

    </div>

    {{-- DOT INDICATOR --}}
    @if ($booth->gambar && count($booth->gambar) > 1)
    <div class="flex justify-center space-x-2 mb-5">
        @foreach ($booth->gambar as $i => $g)
        <div id="dot-{{ $i }}"
            class="w-5 h-2 rounded-full bg-gray-300 transition-all duration-300 dot cursor-pointer hover:scale-110 hover:bg-gray-400">
        </div>
        @endforeach
    </div>
    @endif

    {{-- KAPASITAS --}}
    <div class="text-lg font-semibold text-gray-700 mb-2 text-center">
        Kapasitas: <span class="text-pink-500">Max {{ $booth->kapasitas }} orang</span>
    </div>

    {{-- INFORMASI TANGGAL --}}
    <div class="text-sm text-gray-500 mb-4 text-center">
        Dibuat: {{ $booth->created_at->format('d M Y, H:i') }} <br>
        Terakhir diperbarui: {{ $booth->updated_at->format('d M Y, H:i') }}
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="text-center">
        <a href="{{ route('operator.booth.index') }}"
           class="inline-block mt-4 bg-pink-500 text-white px-6 py-2 rounded-xl hover:bg-pink-600 shadow-lg transition-all">
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
