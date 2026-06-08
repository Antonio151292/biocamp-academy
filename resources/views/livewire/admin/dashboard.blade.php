<div>
    {{-- ============================================================ --}}
    {{--  BIOCAMP ACADEMY — Premium Admin Dashboard                  --}}
    {{-- ============================================================ --}}

    {{-- ---- KPI stat cards ---- --}}
    <div class="row pt-2" style="gap:0">

        {{-- Students --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border-top:3px solid #06b6d4 !important; background:linear-gradient(145deg,#1e293b,#162032) !important;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#0891b2,#0e7490);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(6,182,212,0.3);">
                            <i class="fas fa-users" style="color:#fff;font-size:18px;"></i>
                        </div>
                        <span style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#06b6d4;text-transform:uppercase;">Total</span>
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:2.2rem;font-weight:800;color:#f1f5f9;line-height:1;">{{ number_format($totalStudents) }}</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:6px;font-weight:500;">Estudiantes registrados</div>
                    <div style="margin-top:16px;height:3px;border-radius:2px;background:rgba(255,255,255,0.06);">
                        <div style="height:3px;border-radius:2px;width:68%;background:linear-gradient(90deg,#0891b2,#06b6d4);"></div>
                    </div>
                </div>
                <div class="card-footer" style="padding:12px 20px !important;">
                    <a href="{{ route('admin.roles') }}" style="font-size:12px;color:#67e8f9;text-decoration:none;font-weight:600;">
                        Ver gestión de roles <i class="fas fa-arrow-right ml-1" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Courses --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border-top:3px solid #10b981 !important; background:linear-gradient(145deg,#1e293b,#162032) !important;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#059669,#047857);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(16,185,129,0.3);">
                            <i class="fas fa-graduation-cap" style="color:#fff;font-size:18px;"></i>
                        </div>
                        <span style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#10b981;text-transform:uppercase;">Activos</span>
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:2.2rem;font-weight:800;color:#f1f5f9;line-height:1;">{{ number_format($totalCourses) }}</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:6px;font-weight:500;">Cursos publicados</div>
                    <div style="margin-top:16px;height:3px;border-radius:2px;background:rgba(255,255,255,0.06);">
                        <div style="height:3px;border-radius:2px;width:82%;background:linear-gradient(90deg,#059669,#10b981);"></div>
                    </div>
                </div>
                <div class="card-footer" style="padding:12px 20px !important;">
                    <a href="{{ route('admin.courses.index') }}" style="font-size:12px;color:#34d399;text-decoration:none;font-weight:600;">
                        Administrar cursos <i class="fas fa-arrow-right ml-1" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Earnings --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border-top:3px solid #7c3aed !important; background:linear-gradient(145deg,#1e293b,#162032) !important;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(124,58,237,0.35);">
                            <i class="fas fa-dollar-sign" style="color:#fff;font-size:18px;"></i>
                        </div>
                        <span style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#8b5cf6;text-transform:uppercase;">Total</span>
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:2.2rem;font-weight:800;color:#f1f5f9;line-height:1;">${{ number_format($totalEarnings, 0) }}</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:6px;font-weight:500;">Ganancias consolidadas</div>
                    <div style="margin-top:16px;height:3px;border-radius:2px;background:rgba(255,255,255,0.06);">
                        <div style="height:3px;border-radius:2px;width:55%;background:linear-gradient(90deg,#7c3aed,#8b5cf6);"></div>
                    </div>
                </div>
                <div class="card-footer" style="padding:12px 20px !important;">
                    <a href="#" style="font-size:12px;color:#c4b5fd;text-decoration:none;font-weight:600;">
                        Ver reportes financieros <i class="fas fa-arrow-right ml-1" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Pending Transfers --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border-top:3px solid #ef4444 !important; background:linear-gradient(145deg,#1e293b,#162032) !important;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#dc2626,#b91c1c);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(239,68,68,0.3);">
                            <i class="fas fa-university" style="color:#fff;font-size:18px;"></i>
                        </div>
                        @if($pendingTransfers > 0)
                            <span style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#ef4444;text-transform:uppercase;background:rgba(239,68,68,0.15);padding:3px 10px;border-radius:20px;border:1px solid rgba(239,68,68,0.3);">
                                ⚠ Pendientes
                            </span>
                        @else
                            <span style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#10b981;text-transform:uppercase;">OK</span>
                        @endif
                    </div>
                    <div style="font-family:'Outfit',sans-serif;font-size:2.2rem;font-weight:800;color:#f1f5f9;line-height:1;">{{ number_format($pendingTransfers) }}</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:6px;font-weight:500;">Transferencias a aprobar</div>
                    <div style="margin-top:16px;height:3px;border-radius:2px;background:rgba(255,255,255,0.06);">
                        <div style="height:3px;border-radius:2px;width:{{ $pendingTransfers > 0 ? '40%' : '5%' }};background:linear-gradient(90deg,#dc2626,#ef4444);"></div>
                    </div>
                </div>
                <div class="card-footer" style="padding:12px 20px !important;">
                    <a href="{{ route('admin.payments.transfers') }}" style="font-size:12px;color:#f87171;text-decoration:none;font-weight:600;">
                        Revisar transferencias <i class="fas fa-arrow-right ml-1" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ---- Quick Actions ---- --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background:linear-gradient(135deg,rgba(124,58,237,0.12),rgba(79,70,229,0.08)) !important;border:1px solid rgba(124,58,237,0.25) !important;">
                <div class="card-body py-3 px-4">
                    <div class="d-flex align-items-center flex-wrap" style="gap:12px;">
                        <span style="font-size:12px;font-weight:700;color:#8b5cf6;letter-spacing:1px;text-transform:uppercase;margin-right:8px;">Accesos rápidos</span>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Nuevo Curso
                        </a>
                        <a href="{{ route('admin.page-builder') }}" class="btn btn-sm" style="background:rgba(6,182,212,0.15);border:1px solid rgba(6,182,212,0.4);color:#67e8f9;border-radius:10px;">
                            <i class="fas fa-paint-brush mr-1"></i> Editor de Páginas
                        </a>
                        <a href="{{ route('admin.roles') }}" class="btn btn-sm" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.35);color:#34d399;border-radius:10px;">
                            <i class="fas fa-shield-alt mr-1"></i> Gestionar Roles
                        </a>
                        <a href="{{ route('admin.settings.payments') }}" class="btn btn-sm" style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.35);color:#fbbf24;border-radius:10px;">
                            <i class="fas fa-credit-card mr-1"></i> Medios de Pago
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ---- Tables ---- --}}
    <div class="row">
        {{-- Recent Purchases --}}
        <div class="col-md-6 mb-4">
            <div class="card card-primary h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <span style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#8b5cf6;">Ventas</span>
                        <h3 class="card-title mt-0" style="font-size:15px !important;">Compras de Cursos</h3>
                    </div>
                    <a href="{{ route('admin.payments.transfers') }}" style="font-size:11px;color:#c4b5fd;text-decoration:none;">Ver todo →</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Curso</th>
                                <th>Precio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPurchases as $purchase)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;margin-right:10px;flex-shrink:0;font-size:12px;font-weight:700;color:white;">
                                                {{ strtoupper(substr($purchase->user->name, 0, 1)) }}
                                            </div>
                                            <span style="font-size:13px;">{{ $purchase->user->name }}</span>
                                        </div>
                                    </td>
                                    <td style="font-size:12px;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#94a3b8;">{{ $purchase->course->title }}</td>
                                    <td style="font-weight:600;color:#c4b5fd;">${{ number_format($purchase->amount, 2) }}</td>
                                    <td>
                                        @if($purchase->status === 'approved')
                                            <span class="badge badge-success">Aprobado</span>
                                        @elseif($purchase->status === 'pending')
                                            <span class="badge badge-warning">Pendiente</span>
                                        @else
                                            <span class="badge badge-danger">Rechazado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div style="text-align:center;padding:40px 20px;">
                                            <i class="fas fa-shopping-cart" style="font-size:32px;color:#334155;margin-bottom:12px;display:block;"></i>
                                            <span style="color:#475569;font-size:13px;">No se registran compras recientes.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent Subscriptions --}}
        <div class="col-md-6 mb-4">
            <div class="card h-100" style="border-top:3px solid #06b6d4 !important;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <span style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#06b6d4;">Membresías</span>
                        <h3 class="card-title mt-0" style="font-size:15px !important;">Suscripciones Recientes</h3>
                    </div>
                    <a href="{{ route('admin.settings.payments') }}" style="font-size:11px;color:#67e8f9;text-decoration:none;">Ver planes →</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Plan</th>
                                <th>Método</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSubscriptions as $sub)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#0891b2,#0e7490);display:flex;align-items:center;justify-content:center;margin-right:10px;flex-shrink:0;font-size:12px;font-weight:700;color:white;">
                                                {{ strtoupper(substr($sub->user->name, 0, 1)) }}
                                            </div>
                                            <span style="font-size:13px;">{{ $sub->user->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-info">{{ ucfirst($sub->plan_type) }}</span></td>
                                    <td style="font-size:12px;color:#94a3b8;">{{ ucfirst($sub->payment_method) }}</td>
                                    <td>
                                        @if($sub->status === 'active')
                                            <span class="badge badge-success">Activo</span>
                                        @elseif($sub->status === 'pending')
                                            <span class="badge badge-warning">Pendiente</span>
                                        @else
                                            <span class="badge badge-danger">Expirado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div style="text-align:center;padding:40px 20px;">
                                            <i class="fas fa-id-card" style="font-size:32px;color:#334155;margin-bottom:12px;display:block;"></i>
                                            <span style="color:#475569;font-size:13px;">No se registran suscripciones recientes.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
