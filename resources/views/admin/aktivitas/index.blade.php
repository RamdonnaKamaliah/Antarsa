@extends('layouts.admin')

@section('title', 'Riwayat Aktivitas')

@section('content')

    <div class="container mx-auto px-6 py-8">
        <div class="relative overflow-hidden bg-slate-100 p-8 rounded-3xl shadow-lg mb-8">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>

            <div class="relative flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-primary">Log Aktivitas</h2>
                    <p class="text-gray-600 mt-1 text-sm font-medium opacity-90">Rekam jejak seluruh kegiatan sistem ARSA.</p>
                </div>
                <div class="bg-white/20 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/30 shadow-xl">
                    <span class="text-gray-700 text-xs uppercase font-bold tracking-wider">Total Aktivitas</span>
                    <div class="text-gray-500 text-2xl font-black mt-1">{{ $logs->total() }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100  overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-primary border-b border-slate-100 ">
                    <tr>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-100">Waktu</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-100">User</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-100">Aksi</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-100">Entitas</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-100">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 ">
                    @foreach ($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-700">
                                    {{ $log->created_at->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {{ $log->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold text-xs">
                                        {{ substr($log->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $log->user->name ?? 'System' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $color = match (strtolower($log->aksi)) {
                                        'tambah',
                                        'create'
                                            => 'bg-emerald-100 text-emerald-700 bg-emerald-500/10 text-emerald-400',
                                        'update',
                                        'ubah'
                                            => 'bg-amber-100 text-amber-700 bg-amber-500/10 text-amber-400',
                                        'hapus', 'delete' => 'bg-rose-100 text-rose-700 bg-rose-500/10 text-rose-400',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $color }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600">
                                    {{ $log->entitas }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 truncate max-w-xs">
                                    {{ $log->keterangan }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        </div>
    </div>


@endsection
