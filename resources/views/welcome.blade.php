<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise ERP Console - Compact Density</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Font: Inter (Standar Enterprise) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            /* Base size lebih kecil dari standar */
        }

        /* Custom Scrollbar tipis untuk kepadatan data */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased h-screen overflow-hidden flex flex-col" x-data="{ sidebarOpen: true, selectedTab: 'inventory' }">

    <!-- TOPBAR / GLOBAL HEADER (Sangat Ringkas, Height 40px) -->
    <header class="h-10 bg-slate-900 text-white px-3 flex items-center justify-between shrink-0 z-30 select-none">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white transition-colors">
                <i data-lucide="menu" class="w-4 h-4"></i>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-blue-600 rounded flex items-center justify-center font-bold text-[10px]">E</div>
                <span class="font-semibold text-xs tracking-wide text-slate-200">NEXUS ERP <span
                        class="text-[10px] bg-slate-800 text-blue-400 px-1 py-0.5 rounded border border-slate-700 font-mono">v4.12.0</span></span>
            </div>
        </div>

        <!-- System Quick Status & User Info -->
        <div class="flex items-center gap-4 text-[11px]">
            <div class="hidden md:flex items-center gap-3 text-slate-400 border-r border-slate-700 pr-3">
                <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> DB:
                    Online</span>
                <span class="font-mono">Sync: 10:54:21</span>
            </div>
            <div class="flex items-center gap-2 cursor-pointer hover:text-slate-200">
                <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-400"></i>
                <span class="font-medium text-slate-300">Alandrian S. (SysAdmin)</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500"></i>
            </div>
        </div>
    </header>

    <!-- MAIN WRAPPER -->
    <div class="flex flex-1 overflow-hidden">

        <!-- COMPACT SIDEBAR (Height full minus topbar) -->
        <aside :class="sidebarOpen ? 'w-48' : 'w-11'"
            class="bg-slate-800 border-r border-slate-700 flex flex-col justify-between transition-all duration-200 shrink-0 z-20 select-none">

            <nav class="p-1 space-y-0.5">
                <a href="#"
                    class="flex items-center gap-2.5 px-2 py-1.5 rounded text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <i data-lucide="layout-grid" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span x-show="sidebarOpen" class="truncate text-[11px] font-medium">Dashboard Exec</span>
                </a>

                <a href="#"
                    class="flex items-center gap-2.5 px-2 py-1.5 rounded bg-blue-600 text-white font-medium transition-colors">
                    <i data-lucide="boxes" class="w-4 h-4 shrink-0"></i>
                    <span x-show="sidebarOpen" class="truncate text-[11px]">Inventaris & Stok</span>
                </a>

                <a href="#"
                    class="flex items-center gap-2.5 px-2 py-1.5 rounded text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <i data-lucide="truck" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span x-show="sidebarOpen" class="truncate text-[11px] font-medium">Logistik & SCM</span>
                </a>

                <a href="#"
                    class="flex items-center gap-2.5 px-2 py-1.5 rounded text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span x-show="sidebarOpen" class="truncate text-[11px] font-medium">Faktur & Keuangan</span>
                </a>

                <a href="#"
                    class="flex items-center gap-2.5 px-2 py-1.5 rounded text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <i data-lucide="shield-check" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span x-show="sidebarOpen" class="truncate text-[11px] font-medium">Audit System Log</span>
                </a>
            </nav>

            <!-- Sidebar System Footnote -->
            <div x-show="sidebarOpen" class="p-2 border-t border-slate-700 text-[10px] text-slate-500 font-mono">
                NODE_ID: CGK-PRD-02<br>
                RAM: 3.2 / 16 GB
            </div>
        </aside>

        <!-- MAIN WORKSPACE CONTAINER -->
        <main class="flex-1 flex flex-col min-w-0 bg-slate-100 overflow-hidden">

            <!-- TOOLBAR / FILTER CONTROL BAR (Dense Action Bar) -->
            <div
                class="bg-white border-b border-slate-300 px-3 py-1.5 flex flex-wrap items-center justify-between gap-2 shrink-0">

                <!-- Quick Filter Inputs -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <div class="relative">
                        <i data-lucide="search"
                            class="w-3.5 h-3.5 absolute left-2 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" placeholder="Cari SKU / Part No / Nama..."
                            class="pl-7 pr-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] w-48 focus:bg-white focus:outline-none focus:border-blue-500 font-mono">
                    </div>

                    <select
                        class="py-1 px-2 bg-slate-50 border border-slate-300 rounded text-[11px] text-slate-700 focus:outline-none focus:border-blue-500">
                        <option value="">Gudang: Semua Gudang (Utama + Cabang)</option>
                        <option value="1">WH-01 Jakarta Barat</option>
                        <option value="2">WH-02 Cikarang Hub</option>
                        <option value="3">WH-03 Surabaya Logistics</option>
                    </select>

                    <select
                        class="py-1 px-2 bg-slate-50 border border-slate-300 rounded text-[11px] text-slate-700 focus:outline-none focus:border-blue-500">
                        <option value="">Status Stock: Semua Status</option>
                        <option value="critical">Stok Kritis (< Safety)</option>
                        <option value="overstock">Overstock</option>
                    </select>

                    <button
                        class="px-2 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[11px] font-medium flex items-center gap-1">
                        <i data-lucide="filter" class="w-3 h-3"></i> Apply Filter
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-1.5">
                    <button
                        class="px-2 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded text-[11px] font-medium flex items-center gap-1 shadow-sm">
                        <i data-lucide="plus" class="w-3 h-3"></i> Input Barang Masuk
                    </button>
                    <button
                        class="px-2 py-1 bg-slate-700 hover:bg-slate-800 text-white rounded text-[11px] font-medium flex items-center gap-1 shadow-sm">
                        <i data-lucide="file-spreadsheet" class="w-3 h-3"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- METRIC KPI STRIP (Dense Data Strip) -->
            <div
                class="grid grid-cols-2 md:grid-cols-5 gap-2 p-2 bg-slate-200/60 border-b border-slate-300 shrink-0 text-[11px]">
                <div class="bg-white p-2 rounded border border-slate-300 flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-semibold">Total SKU Aktif</p>
                        <p class="text-sm font-bold font-mono text-slate-900">42,891</p>
                    </div>
                    <span class="text-[10px] text-slate-400 font-mono">100%</span>
                </div>

                <div class="bg-white p-2 rounded border border-slate-300 flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-semibold">Stok Kritis / Reorder</p>
                        <p class="text-sm font-bold font-mono text-rose-600">142</p>
                    </div>
                    <span class="px-1 bg-rose-100 text-rose-700 rounded text-[9px] font-bold">PERLU PO</span>
                </div>

                <div class="bg-white p-2 rounded border border-slate-300 flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-semibold">Valuasi Inventaris</p>
                        <p class="text-sm font-bold font-mono text-slate-900">Rp 18.42B</p>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-bold">+2.1%</span>
                </div>

                <div class="bg-white p-2 rounded border border-slate-300 flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-semibold">In-Transit (PO Open)</p>
                        <p class="text-sm font-bold font-mono text-blue-600">1,200 Unit</p>
                    </div>
                    <span class="text-[10px] text-slate-500 font-mono">8 Shipment</span>
                </div>

                <div class="bg-white p-2 rounded border border-slate-300 flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-[10px] uppercase font-semibold">Stock Accuracy Rate</p>
                        <p class="text-sm font-bold font-mono text-emerald-600">99.4%</p>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-mono">Audited</span>
                </div>
            </div>

            <!-- HIGH DENSITY DATA TABLE AREA (Fills Remaining Screen Space) -->
            <div class="flex-1 p-2 overflow-hidden flex flex-col">
                <div class="bg-white border border-slate-300 rounded flex-1 flex flex-col overflow-hidden">

                    <!-- Scrollable Table Wrapper with Sticky Header -->
                    <div class="flex-1 overflow-auto">
                        <table class="w-full text-left border-collapse text-[11px]">
                            <thead
                                class="bg-slate-200 sticky top-0 z-10 text-slate-700 font-semibold border-b border-slate-300 uppercase tracking-tight font-mono text-[10px]">
                                <tr>
                                    <th class="p-1.5 border-r border-slate-300 text-center w-8"><input type="checkbox"
                                            class="rounded-none border-slate-400"></th>
                                    <th class="p-1.5 border-r border-slate-300 w-28">Part No / SKU</th>
                                    <th class="p-1.5 border-r border-slate-300">Deskripsi Material / Item</th>
                                    <th class="p-1.5 border-r border-slate-300 w-24">Kategori</th>
                                    <th class="p-1.5 border-r border-slate-300 w-28">Lokasi Bin</th>
                                    <th class="p-1.5 border-r border-slate-300 text-right w-20">On Hand</th>
                                    <th class="p-1.5 border-r border-slate-300 text-right w-20">Safety Stock</th>
                                    <th class="p-1.5 border-r border-slate-300 text-right w-24">HPP / Unit</th>
                                    <th class="p-1.5 border-r border-slate-300 text-center w-24">Status</th>
                                    <th class="p-1.5 text-center w-16">Cmd</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 font-mono">

                                <!-- Zebra Row 1 (Kritis) -->
                                <tr class="bg-rose-50/60 hover:bg-rose-100/70 transition-colors">
                                    <td class="p-1.5 border-r border-slate-200 text-center"><input type="checkbox"
                                            class="rounded-none border-slate-400"></td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-bold text-blue-700 underline cursor-pointer">
                                        SKU-IC-90821</td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-sans font-medium text-slate-800 truncate max-w-xs">
                                        Microcontroller ATmega328P-PU DIP-28</td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600 font-sans">Semiconductor
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600">WH1-A2-B04</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right font-bold text-rose-600">12
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-500">100</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-700">Rp 32.500
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-center font-sans">
                                        <span
                                            class="px-1 py-0.5 rounded text-[9px] font-bold bg-rose-200 text-rose-800 border border-rose-300 block">KRITIS</span>
                                    </td>
                                    <td class="p-1.5 text-center font-sans">
                                        <button
                                            class="text-blue-600 hover:text-blue-800 font-semibold text-[10px]">Edit</button>
                                    </td>
                                </tr>

                                <!-- Zebra Row 2 -->
                                <tr class="bg-white hover:bg-slate-100 transition-colors">
                                    <td class="p-1.5 border-r border-slate-200 text-center"><input type="checkbox"
                                            class="rounded-none border-slate-400"></td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-bold text-blue-700 underline cursor-pointer">
                                        SKU-RES-0012</td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-sans font-medium text-slate-800 truncate max-w-xs">
                                        Resistor 10k Ohm 1/4W 1% Metal Film</td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600 font-sans">Passive Comp
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600">WH1-C1-B01</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right font-bold text-slate-800">
                                        15,400</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-500">2,000</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-700">Rp 150</td>
                                    <td class="p-1.5 border-r border-slate-200 text-center font-sans">
                                        <span
                                            class="px-1 py-0.5 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 block">NORMAL</span>
                                    </td>
                                    <td class="p-1.5 text-center font-sans">
                                        <button
                                            class="text-blue-600 hover:text-blue-800 font-semibold text-[10px]">Edit</button>
                                    </td>
                                </tr>

                                <!-- Zebra Row 3 -->
                                <tr class="bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <td class="p-1.5 border-r border-slate-200 text-center"><input type="checkbox"
                                            class="rounded-none border-slate-400"></td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-bold text-blue-700 underline cursor-pointer">
                                        SKU-CAP-4091</td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-sans font-medium text-slate-800 truncate max-w-xs">
                                        Capacitor Electrolytic 470uF 25V</td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600 font-sans">Passive Comp
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600">WH2-B4-A02</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right font-bold text-slate-800">890
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-500">500</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-700">Rp 1.250</td>
                                    <td class="p-1.5 border-r border-slate-200 text-center font-sans">
                                        <span
                                            class="px-1 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-800 border border-amber-300 block">WARNING</span>
                                    </td>
                                    <td class="p-1.5 text-center font-sans">
                                        <button
                                            class="text-blue-600 hover:text-blue-800 font-semibold text-[10px]">Edit</button>
                                    </td>
                                </tr>

                                <!-- Zebra Row 4 -->
                                <tr class="bg-white hover:bg-slate-100 transition-colors">
                                    <td class="p-1.5 border-r border-slate-200 text-center"><input type="checkbox"
                                            class="rounded-none border-slate-400"></td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-bold text-blue-700 underline cursor-pointer">
                                        SKU-PCB-FR402</td>
                                    <td
                                        class="p-1.5 border-r border-slate-200 font-sans font-medium text-slate-800 truncate max-w-xs">
                                        Raw Board PCB FR4 Double Layer 10x15cm</td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600 font-sans">Raw Material
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-slate-600">WH3-A1-Z01</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right font-bold text-slate-800">
                                        4,320</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-500">1,000</td>
                                    <td class="p-1.5 border-r border-slate-200 text-right text-slate-700">Rp 18.000
                                    </td>
                                    <td class="p-1.5 border-r border-slate-200 text-center font-sans">
                                        <span
                                            class="px-1 py-0.5 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 block">NORMAL</span>
                                    </td>
                                    <td class="p-1.5 text-center font-sans">
                                        <button
                                            class="text-blue-600 hover:text-blue-800 font-semibold text-[10px]">Edit</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Compact Data Table Footer / Pagination -->
                    <div
                        class="bg-slate-200 border-t border-slate-300 px-3 py-1 flex items-center justify-between text-[11px] text-slate-700 font-mono shrink-0 select-none">
                        <div class="flex items-center gap-3">
                            <span>Baris per halaman:</span>
                            <select class="bg-white border border-slate-300 px-1 py-0.5 rounded text-[10px]">
                                <option>50</option>
                                <option>100</option>
                                <option>250</option>
                            </select>
                            <span>Menampilkan 1-50 dari 42,891 data</span>
                        </div>

                        <div class="flex items-center gap-1 font-sans">
                            <button
                                class="px-2 py-0.5 bg-white border border-slate-300 rounded hover:bg-slate-50 disabled:opacity-50 text-[10px]"
                                disabled>&lt; Prev</button>
                            <span class="px-2 py-0.5 bg-blue-600 text-white font-bold rounded text-[10px]">1</span>
                            <button
                                class="px-2 py-0.5 bg-white border border-slate-300 rounded hover:bg-slate-50 text-[10px]">2</button>
                            <button
                                class="px-2 py-0.5 bg-white border border-slate-300 rounded hover:bg-slate-50 text-[10px]">3</button>
                            <span>...</span>
                            <button
                                class="px-2 py-0.5 bg-white border border-slate-300 rounded hover:bg-slate-50 text-[10px]">858</button>
                            <button
                                class="px-2 py-0.5 bg-white border border-slate-300 rounded hover:bg-slate-50 text-[10px]">Next
                                &gt;</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- STATUS BAR FOOTER (Global System Footnote) -->
            <footer
                class="bg-slate-300 border-t border-slate-400 px-3 py-0.5 text-[10px] text-slate-600 flex items-center justify-between font-mono shrink-0 select-none">
                <div>MODE: PRODUCTION | CLUSTER: AP-SOUTHEAST-1 | LATENCY: 14ms</div>
                <div>AUTOSAVE: ON | SESSION EXP: 07h 42m</div>
            </footer>

        </main>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
