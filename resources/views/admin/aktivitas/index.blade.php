@extends('layouts.admin')

@section('title', 'Riwayat Aktivitas')

@section('content')

    <div class="container mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Log Aktivitas</h2>
                <p class="text-slate-500 mt-1 text-sm">Rekam jejak seluruh kegiatan sistem ARSA.</p>
            </div>
            <div
                class="bg-white dark:bg-slate-800 px-4 py-2 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                <span class="text-slate-500 text-xs uppercase font-semibold tracking-wider">Total Aktivitas:</span>
                <span class="text-primary font-bold ml-2">{{ $logs->total() }}</span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Waktu</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">User</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Aksi</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Entitas</th>
                        <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach ($logs as $log)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                    {{ $log->created_at->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {{ $log->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary font-bold text-xs">
                                        {{ substr($log->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                        {{ $log->user->name ?? 'System' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $color = match (strtolower($log->aksi)) {
                                        'tambah',
                                        'create'
                                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                        'update',
                                        'ubah'
                                            => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                        'hapus',
                                        'delete'
                                            => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $color }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    {{ $log->entitas }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 dark:text-slate-400 truncate max-w-xs">
                                    {{ $log->keterangan }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $logs->links() }}
            </div>
        </div>
    </div>


@endsection
