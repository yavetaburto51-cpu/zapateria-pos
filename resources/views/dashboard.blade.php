@extends('layouts.app')

@section('content')

<div class="grid gap-8 lg:grid-cols-[320px_minmax(0,1fr)]">
    <aside class="sticky top-6 self-start space-y-6">
        <div class="app-card p-6">
            <p class="text-sm uppercase tracking-[0.24em] text-secondary mb-3">Accesos rápidos</p>
            <div class="grid gap-3">
                @if(auth()->user()->isEmployee() || auth()->user()->isAdmin())
                    <a href="{{ route('sales.index') }}" class="app-btn-secondary w-full text-center">Nueva venta</a>
                @endif
                @if(auth()->user()->isManager() || auth()->user()->isAdmin())
                    <a href="{{ route('products.index') }}" class="app-btn-secondary w-full text-center">Productos</a>
                @endif
                @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                    <a href="{{ route('users.index') }}" class="app-btn-secondary w-full text-center">Usuarios</a>
                @endif
                @if(auth()->user()->isManager() || auth()->user()->isOwner() || auth()->user()->isAdmin())
                    <a href="{{ route('sales.history') }}" class="app-btn-secondary w-full text-center">Historial</a>
                @endif
                @if(auth()->user()->isManager() || auth()->user()->isAdmin())
                    <a href="{{ route('reports.daily') }}" class="app-btn-secondary w-full text-center">Corte</a>
                @endif
                @if(auth()->user()->isManager() || auth()->user()->isOwner() || auth()->user()->isAdmin())
                    <a href="{{ route('reports.top') }}" class="app-btn-secondary w-full text-center">Reportes</a>
                @endif
            </div>
        </div>

        <div class="app-card p-6">
            <div class="mb-6">
                <p class="text-sm uppercase tracking-[0.24em] text-secondary">Panel de control</p>
            </div>

            <div class="space-y-4">
                <div class="app-card-flat p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-secondary">Estado 2FA</p>
                    <p class="mt-3 text-lg font-semibold text-white">{{ auth()->user()->two_factor_confirmed_at ? 'Activo' : 'Pendiente' }}</p>
                </div>

                <div class="app-card-flat p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-secondary">Stock crítico</p>
                    <p class="mt-3 text-lg font-semibold text-accent">{{ $lowStock->count() }} productos</p>
                </div>

                <div class="app-card-flat p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-secondary">Usuario</p>
                    <p class="mt-3 text-lg font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-secondary">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="space-y-6">
        <section class="app-card p-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-secondary">Indicador de ventas</p>
                    <h1 class="text-3xl font-semibold text-white">Ventas semanales</h1>
                    <p class="app-section-subtitle">Resumen de los últimos 7 días</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="app-card-flat p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-secondary">Total</p>
                        <p class="mt-3 text-3xl font-semibold text-accent">{{ number_format($weeklySalesTotal, 2, ',', '.') }} $</p>
                    </div>
                    <div class="app-card-flat p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-secondary">Ventas</p>
                        <p class="mt-3 text-3xl font-semibold text-white">{{ $weeklySalesCount }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="app-card p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-white">
                        {{ auth()->user()->isEmployee() ? 'Tu reporte de ventas' : 'Reporte de ventas por empleado' }}
                    </h2>
                    <p class="app-section-subtitle">Datos cotejados desde la base de datos para esta última semana</p>
                </div>
                <span class="app-badge {{ auth()->user()->isEmployee() ? 'badge-muted' : 'badge-accent' }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            @if(auth()->user()->isEmployee())
                <div class="grid gap-4 sm:grid-cols-2 mt-6">
                    <div class="app-card-flat p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-secondary">Total de ventas</p>
                        <p class="mt-3 text-3xl font-semibold text-white">{{ $employeeSales->sales_count ?? 0 }}</p>
                    </div>
                    <div class="app-card-flat p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-secondary">Total facturado</p>
                        <p class="mt-3 text-3xl font-semibold text-accent">{{ number_format($employeeSales->sales_total ?? 0, 2, ',', '.') }} $</p>
                    </div>
                </div>

                <div class="overflow-x-auto mt-6">
                    <table class="app-table w-full">
                        <thead>
                            <tr>
                                <th class="p-4">Fecha</th>
                                <th class="p-4">Venta #</th>
                                <th class="p-4">Total</th>
                                <th class="p-4">Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employeeSaleRecords as $sale)
                                <tr>
                                    <td class="p-4">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="p-4">{{ $sale->id }}</td>
                                    <td class="p-4">{{ number_format($sale->total, 2, ',', '.') }} $</td>
                                    <td class="p-4">{{ $sale->details->sum('quantity') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-secondary">No hay ventas registradas esta semana.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="overflow-x-auto mt-6">
                    <table class="app-table w-full">
                        <thead>
                            <tr>
                                <th class="p-4">Empleado</th>
                                <th class="p-4">Ventas</th>
                                <th class="p-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employeeSales as $report)
                                <tr>
                                    <td class="p-4">{{ $report->name }}</td>
                                    <td class="p-4">{{ $report->sales_count }}</td>
                                    <td class="p-4">{{ number_format($report->sales_total, 2, ',', '.') }} $</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-secondary">No hay ventas registradas esta semana.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </main>
</div>

@endsection