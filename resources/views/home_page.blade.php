<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurasi Produk Bantul</title>
    <link rel="icon" href="https://diskominfo.bantulkab.go.id/assets/Site/img/favicon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <!-- Tambahkan Library Tom Select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.2.2/js/tom-select.complete.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.2.2/css/tom-select.bootstrap5.min.css">


    <script>
        function filterProducts() {
            const form = document.getElementById('filter-form');
            form.submit();
        }

        function handleSearch(event) {
            if (event.key === 'Enter') {
                const form = document.getElementById('filter-form');
                form.submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col m-0">
    <!-- Header -->
    <header class="bg-[#678FAA] text-white py-4 px-6 w-full">
        <div class="w-full mx-auto">
            <img src="https://diskominfo.bantulkab.go.id/assets/Site/img/logo-font-white.png" alt="Logo Bantul">
            
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow p-4">
    <h1 class="text-xl font-semibold text-center mb-1">Daftar Produk</h1>
            <p class="text-sm text-center text-black/90 leading-tight px-4">
                Admin dapat meninjau setiap produk yang diajukan serta mencatat riwayat perubahan status secara transparan.
            </p>
        <div class="w-full mx-auto my-4">
            <!-- Search and Filter -->
            <form id="filter-form" action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 mb-4 px-4">
                <!-- Search Field -->
                <div class="relative flex-grow">
                    <input type="text" 
                        name="search" 
                        placeholder="Cari produk..." 
                        value="{{ request('search') }}"
                        onkeypress="handleSearch(event)"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                
                <!-- Status Field -->
                <div class="relative w-full md:w-32 ">
                    <select name="status" onchange="window.location.href=this.value" 
                            class="w-full h-[42px] px-4 py-2 border border-gray-300 rounded-md bg-white appearance-none pr-10">
                        <option value="" disabled {{ !request('status') ? 'selected' : '' }} hidden>Status</option>
                        <option value="{{ request()->url() }}" {{ request('status') === null ? 'selected' : '' }}>
                            Semua
                        </option>
                        @foreach($statuses as $status)
                            <option value="{{ request()->fullUrlWithQuery(['status' => strtolower($status)]) }}" 
                                    {{ strtolower(request('status')) === strtolower($status) ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    <img src="{{ asset('images/down-arrow.png') }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 pointer-events-none" alt="Dropdown Icon">
                </div>

                <!-- Category Field - Menggunakan CSS yang sama persis dengan Status Field -->
                <div class="relative w-full md:w-80">
                    <select id="category-select" name="category" onchange="filterCategory(this)" 
                        class="w-full h-[42px] px-4 py-2 border border-gray-300 rounded-md bg-white appearance-none pr-10">
                        <option value="" disabled selected hidden>Pilih Kategori</option>
                        <option value="{{ url('/') }}">Semua Kategori</option>

                        @foreach($categories as $category)
                            <option value="{{ request()->fullUrlWithQuery(['category' => $category->id]) }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>

                            @if ($category->children->isNotEmpty()) 
                                @foreach ($category->children as $child)
                                    <option value="{{ request()->fullUrlWithQuery(['category' => $child->id]) }}" 
                                        {{ request('category') == $child->id ? 'selected' : '' }}
                                        class="text-gray-700">
                                        {{ $category->name }} > {{ $child->name }}
                                    </option>

                                    @if ($child->children->isNotEmpty())
                                        @foreach ($child->children as $subChild)
                                            <option value="{{ request()->fullUrlWithQuery(['category' => $subChild->id]) }}" 
                                                {{ request('category') == $subChild->id ? 'selected' : '' }}
                                                class="text-gray-600">
                                                {{ $category->name }} > {{ $child->name }} > {{ $subChild->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                    <img src="{{ asset('images/down-arrow.png') }}" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 pointer-events-none" 
                        alt="Dropdown Icon">
                </div>
            </form>

            <style>
            /* Pastikan Tom Select memiliki ukuran yang sama dengan dropdown biasa */
            .ts-wrapper {
                height: 42px !important;
                width: 100% !important;
            }

            .ts-control {
                height: 42px !important;
                padding: 0.5rem 1rem !important;
                border-radius: 0.375rem !important;
                border-color: rgb(209, 213, 219) !important;
            }

            /* Mengatasi ukuran dropdown */
            .ts-dropdown {
                width: 100% !important;
            }
            </style>

            <script>
                function handleSearch(event) {
                    if (event.key === "Enter") {
                        document.getElementById("filter-form").submit();
                    }
                }

                function filterCategory(select) {
                    var selectedValue = select.value;
                    if (selectedValue) {
                        window.location.href = selectedValue;
                    }
                }

                document.addEventListener("DOMContentLoaded", function() {
                    // Konfigurasi TomSelect untuk kategori
                    var categorySelect = new TomSelect("#category-select", {
                        create: false,
                        sortField: {
                            field: "text",
                            direction: "asc"
                        },
                        placeholder: "Pilih atau cari kategori",
                        render: {
                            option: function(data, escape) {
                                return '<div>' + escape(data.text) + '</div>';
                            },
                            item: function(data, escape) {
                                return '<div>' + escape(data.text) + '</div>';
                            }
                        }
                    });
                });
            </script>
            </form>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all hover:shadow-xl">
                <!-- Header with border -->
                <div class="grid grid-cols-5 py-4 px-6 text-sm font-semibold text-gray-600 border-b border-gray-100 bg-gray-50 text-center">
                    <div class="pl-3">Produk</div>
                    <div>Kategori</div>
                    <div>Harga</div>
                    <div>Status</div>
                    <div>Aksi</div>
                </div>

                <!-- Ganti bagian product-item menjadi seperti ini -->
                @foreach($products as $product)
                    <div class="product-item grid grid-cols-5 items-center py-4 px-6 border-b border-gray-100 hover:bg-gray-50 transition-colors text-center">
                        <div class="flex items-start gap-3"> <!-- Ubah 'items-center' menjadi 'items-start' dan 'gap-4' menjadi 'gap-3' -->
                            @if($product->first_photo)
                                <img src="{{ $product->first_photo->url }}" alt="{{ $product->name }}" 
                                    class="w-16 h-16 object-cover bg-gray-100 rounded-lg shadow-sm">
                            @else
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-xl"></i>
                                </div>
                            @endif
                            <div class="text-left"> <!-- Tambahkan class 'text-left' -->
                                <p class="text-blue-600 font-medium mb-1">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">Variasi :</p>
                                <div class="flex flex-wrap gap-1 mt-1"> <!-- Ubah 'gap-2' menjadi 'gap-1' dan tambahkan 'mt-1' -->
                                    @if($product->variations->isNotEmpty())
                                        @foreach($product->variations as $variation)
                                            <span class="px-2 py-1 text-xs bg-purple-100 text-purple-600 rounded-full"> <!-- Ubah 'px-3' menjadi 'px-2' -->
                                                {{ $variation->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded-full"> <!-- Ubah 'px-3' menjadi 'px-2' -->
                                            Tidak Ada
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $product->rootCategory ? $product->rootCategory->name : 'Tanpa Kategori' }}
                        </div>
                        <div class="text-sm font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div>
                            @php
                                $status = ucfirst($product->latestHistory->status ?? 'Diajukan'); // Default 'pending' jika null
                                $statusColor = [
                                    'Diterima' => ['bg' => 'bg-green-500', 'text' => 'text-white'],
                                    'Ditolak' => ['bg' => 'bg-red-500', 'text' => 'text-white'],
                                    'Diterima dengan revisi' => ['bg' => 'bg-yellow-500', 'text' => 'text-white'],
                                    'Diajukan' => ['bg' => 'bg-blue-500', 'text' => 'text-white'],
                                ];
                                $color = $statusColor[$status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-white'];
                            @endphp

                            <span class="{{ $color['bg'] }} {{ $color['text'] }} 
                                        inline-flex items-center justify-center 
                                        px-3 py-1 rounded-full text-xs font-medium 
                                        min-w-[100px] min-h-[24px] text-center">
                                {{ $status }}
                            </span>
                        </div>
                        <div>
                            <a href="{{ route('products.show', $product->id) }}" 
                                class="inline-flex items-center gap-2 bg-[#678FAA] hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
            <div class="flex justify-center mt-4 gap-1">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <button disabled class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md text-gray-400 bg-gray-100">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md hover:bg-blue-50">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <button class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md bg-blue-500 text-white">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md hover:bg-blue-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md hover:bg-blue-50">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                @else
                    <button disabled class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md text-gray-400 bg-gray-100">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                @endif
            </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r bg-[#678FAA] text-white py-4 mt-8 w-full">
        <div class="w-full mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm font-medium">
                © 2025 Pemkab Bantul. All rights reserved.
            </p>
            <div class="flex items-center gap-6">
                <a href="https://www.instagram.com/diskominfobantul/" class="text-white hover:text-blue-100 transition-colors">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="https://x.com/kominfobantul" class="text-white hover:text-blue-100 transition-colors">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="https://www.facebook.com/kominfobantul/" class="text-white hover:text-blue-100 transition-colors">
                    <i class="fab fa-facebook text-xl"></i>
                </a>
                <a href="https://www.youtube.com/c/BantulTV" class="text-white hover:text-blue-100 transition-colors">
                    <i class="fab fa-youtube text-xl"></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
