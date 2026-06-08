<div class="pt-3">
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Tab navigation -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <button class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}" wire:click="$set('activeTab', 'pending')">
                <i class="fas fa-clock"></i> Pendientes de Verificación
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $activeTab === 'history' ? 'active' : '' }}" wire:click="$set('activeTab', 'history')">
                <i class="fas fa-history"></i> Historial de Acciones
            </button>
        </li>
    </ul>

    <!-- Purchases Section -->
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Compras de Cursos (Pago Único)</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Monto</th>
                        <th>Comprobante</th>
                        @if($activeTab === 'pending')
                            <th style="width: 200px">Acciones</th>
                        @else
                            <th>Estado</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingPurchases as $purchase)
                        <tr>
                            <td>
                                <strong>{{ $purchase->user->name }}</strong><br>
                                <small class="text-muted">{{ $purchase->user->email }}</small>
                            </td>
                            <td>{{ $purchase->course->title }}</td>
                            <td>${{ number_format($purchase->amount, 2) }}</td>
                            <td>
                                @if($purchase->receipt_path)
                                    <a href="{{ asset('storage/' . $purchase->receipt_path) }}" target="_blank" class="btn btn-xs btn-outline-info">
                                        <i class="fas fa-file-download"></i> Ver Comprobante
                                    </a>
                                @else
                                    <span class="text-danger">Sin archivo</span>
                                @endif
                            </td>
                            @if($activeTab === 'pending')
                                <td>
                                    <button class="btn btn-sm btn-success" wire:click="approvePurchase({{ $purchase->id }})">
                                        <i class="fas fa-check"></i> Aprobar
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="rejectPurchase({{ $purchase->id }})">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                </td>
                            @else
                                <td>
                                    <span class="badge badge-{{ $purchase->status === 'approved' ? 'success' : 'danger' }}">
                                        {{ $purchase->status === 'approved' ? 'Aprobada' : 'Rechazada' }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No se registran compras.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Subscriptions Section -->
    <div class="card card-purple card-outline">
        <div class="card-header">
            <h3 class="card-title">Suscripciones (Acceso Completo)</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Plan</th>
                        <th>Comprobante</th>
                        @if($activeTab === 'pending')
                            <th style="width: 200px">Acciones</th>
                        @else
                            <th>Estado / Duración</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingSubscriptions as $sub)
                        <tr>
                            <td>
                                <strong>{{ $sub->user->name }}</strong><br>
                                <small class="text-muted">{{ $sub->user->email }}</small>
                            </td>
                            <td>
                                <span class="badge badge-primary">Suscripción {{ ucfirst($sub->plan_type) }}</span>
                            </td>
                            <td>
                                @if($sub->receipt_path)
                                    <a href="{{ asset('storage/' . $sub->receipt_path) }}" target="_blank" class="btn btn-xs btn-outline-info">
                                        <i class="fas fa-file-download"></i> Ver Comprobante
                                    </a>
                                @else
                                    <span class="text-danger">Sin archivo</span>
                                @endif
                            </td>
                            @if($activeTab === 'pending')
                                <td>
                                    <button class="btn btn-sm btn-success" wire:click="approveSubscription({{ $sub->id }})">
                                        <i class="fas fa-check"></i> Aprobar
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="rejectSubscription({{ $sub->id }})">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                </td>
                            @else
                                <td>
                                    <span class="badge badge-{{ $sub->status === 'active' ? 'success' : 'danger' }} mr-2">
                                        {{ $sub->status === 'active' ? 'Activo' : 'Rechazada/Expirada' }}
                                    </span>
                                    @if($sub->status === 'active')
                                        <small class="text-muted">Expira el {{ $sub->ends_at->format('d/m/Y') }}</small>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No se registran suscripciones.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
