<div class="pt-3">
    @if (session()->has('role_message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('role_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('role_error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('role_error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        {{-- Create New Role --}}
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Crear Nuevo Rol</h3>
                </div>
                <form wire:submit.prevent="createRole">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="newRoleName">Nombre del Rol</label>
                            <input type="text" id="newRoleName"
                                class="form-control @error('newRoleName') is-invalid @enderror"
                                placeholder="ej: docente, tutor, moderador"
                                wire:model="newRoleName">
                            @error('newRoleName') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            <small style="color:#475569;font-size:11px;margin-top:6px;display:block;">El nombre debe ser único. Los roles del sistema (admin, student) no pueden eliminarse.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-plus mr-1"></i> Crear Rol
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- List Roles --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Roles y Permisos del Sistema</h3>
                    <span style="font-size:11px;color:#64748b;">{{ count($roles) }} rol(es) activos</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nombre del Rol</th>
                                <th>Permisos Asignados</th>
                                <th style="width: 180px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px;">
                                            <div style="width:28px;height:28px;border-radius:8px;background:{{ in_array($role->name, ['admin']) ? 'linear-gradient(135deg,#7c3aed,#4f46e5)' : (in_array($role->name, ['student']) ? 'linear-gradient(135deg,#0891b2,#0e7490)' : 'linear-gradient(135deg,#059669,#047857)') }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fas {{ in_array($role->name, ['admin']) ? 'fa-crown' : (in_array($role->name, ['student']) ? 'fa-user-graduate' : 'fa-user-tag') }}" style="color:white;font-size:11px;"></i>
                                            </div>
                                            <div>
                                                <strong style="color:#f1f5f9;">{{ ucfirst($role->name) }}</strong>
                                                @if(in_array($role->name, ['admin', 'student']))
                                                    <span class="badge badge-info ml-1">Sistema</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                            @forelse($role->permissions as $perm)
                                                <span class="badge badge-secondary">{{ $perm->name }}</span>
                                            @empty
                                                <span style="color:#334155;font-size:12px;font-style:italic;">Sin permisos específicos</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <button wire:click="openEditPermissionsModal({{ $role->id }})" class="btn btn-sm btn-info">
                                            <i class="fas fa-key"></i> Permisos
                                        </button>
                                        @if(!in_array($role->name, ['admin', 'student']))
                                            <button onclick="confirm('¿Estás seguro de que deseas eliminar este rol?') || event.stopImmediatePropagation()" wire:click="deleteRole({{ $role->id }})" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- =====================================================
         Edit Permissions Modal — Fixed scrollable overlay
         ===================================================== --}}
    @if($editingRoleId)
    <div
        style="position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(4px);overflow-y:auto;padding:40px 20px;"
        wire:click.self="$set('editingRoleId', null)"
        role="dialog"
        aria-modal="true"
    >
        <div style="max-width:520px;width:100%;margin:0 auto;position:relative;">
            <div style="background:#1e293b;border:1px solid rgba(255,255,255,0.08);border-radius:20px;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,0.6);">

                {{-- Modal header --}}
                <div style="padding:22px 28px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;background:rgba(6,182,212,0.08);">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#0891b2,#0e7490);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 16px rgba(6,182,212,0.35);">
                            <i class="fas fa-key" style="color:white;font-size:16px;"></i>
                        </div>
                        <div>
                            <div style="font-family:'Outfit',sans-serif;font-size:17px;font-weight:700;color:#f1f5f9;">Configurar Permisos</div>
                            @php $activeRole = \Spatie\Permission\Models\Role::find($editingRoleId); @endphp
                            <div style="font-size:11px;color:#64748b;margin-top:1px;">
                                Rol: <strong style="color:#67e8f9;">{{ ucfirst($activeRole?->name ?? '') }}</strong>
                            </div>
                        </div>
                    </div>
                    <button type="button" wire:click="$set('editingRoleId', null)"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;width:34px;height:34px;border-radius:10px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;"
                        onmouseover="this.style.background='rgba(239,68,68,0.2)';this.style.color='#f87171'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)';this.style.color='#94a3b8'">
                        &times;
                    </button>
                </div>

                {{-- Modal body --}}
                <form wire:submit.prevent="savePermissions">
                    <div style="padding:28px;">
                        <div style="font-size:12px;color:#64748b;margin-bottom:16px;">
                            Selecciona los permisos que tendrá este rol. Los cambios se aplican inmediatamente al guardar.
                        </div>

                        @if(count($permissions) > 0)
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                @foreach($permissions as $perm)
                                    <label style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:10px;cursor:pointer;transition:all 0.15s;"
                                        onmouseover="this.style.background='rgba(6,182,212,0.08)';this.style.borderColor='rgba(6,182,212,0.3)'"
                                        onmouseout="this.style.background='rgba(255,255,255,0.03)';this.style.borderColor='rgba(255,255,255,0.07)'">
                                        <input type="checkbox"
                                            id="perm_{{ $perm->id }}"
                                            value="{{ $perm->name }}"
                                            wire:model="selectedPermissions"
                                            style="width:16px;height:16px;accent-color:#06b6d4;cursor:pointer;flex-shrink:0;">
                                        <span style="font-size:12px;font-weight:500;color:#94a3b8;text-transform:none;letter-spacing:0;">{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align:center;padding:30px;color:#334155;">
                                <i class="fas fa-lock" style="font-size:28px;display:block;margin-bottom:10px;"></i>
                                <span style="font-size:13px;">No hay permisos registrados en el sistema.</span>
                            </div>
                        @endif
                    </div>

                    {{-- Modal footer --}}
                    <div style="padding:16px 28px;border-top:1px solid rgba(255,255,255,0.07);display:flex;justify-content:flex-end;gap:10px;background:rgba(0,0,0,0.1);">
                        <button type="button" class="btn btn-secondary" wire:click="$set('editingRoleId', null)">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-info" style="min-width:150px;">
                            <i class="fas fa-save mr-1"></i> Guardar Permisos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>(function(){ document.body.style.overflow = 'hidden'; })();</script>
    @else
    <script>(function(){ document.body.style.overflow = ''; })();</script>
    @endif

</div>
