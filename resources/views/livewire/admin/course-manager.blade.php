<div class="pt-3">
    <div class="row mb-3">
        <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Buscar curso por título..." wire:model.live="search">
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-primary" wire:click="openCreateModal">
                <i class="fas fa-plus"></i> Crear Nuevo Curso
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cursos Disponibles</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Slug</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th style="width: 250px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->title }}</td>
                            <td><code style="background:rgba(124,58,237,0.15);color:#c4b5fd;padding:2px 8px;border-radius:5px;font-size:12px;">{{ $course->slug }}</code></td>
                            <td style="font-weight:600;color:#c4b5fd;">${{ number_format($course->price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $course->is_published ? 'success' : 'secondary' }}">
                                    {{ $course->is_published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button onclick="confirm('¿Estás seguro de que deseas eliminar este curso?') || event.stopImmediatePropagation()" wire:click="delete({{ $course->id }})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div style="text-align:center;padding:40px 20px;">
                                    <i class="fas fa-graduation-cap" style="font-size:36px;color:#334155;display:block;margin-bottom:10px;"></i>
                                    <span style="color:#475569;font-size:13px;">No se encontraron cursos. Crea el primero usando el botón de arriba.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $courses->links() }}
        </div>
    </div>

    {{-- =====================================================
         Create Modal — Fixed fullscreen overlay with scroll
         ===================================================== --}}
    @if($showCreateModal)
    <div
        style="position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(4px);overflow-y:auto;padding:40px 20px;"
        wire:click.self="$set('showCreateModal', false)"
        role="dialog"
        aria-modal="true"
    >
        <div style="max-width:680px;width:100%;margin:0 auto;position:relative;">
            <div style="background:#1e293b;border:1px solid rgba(255,255,255,0.08);border-radius:20px;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,0.6);">

                {{-- Modal header --}}
                <div style="padding:22px 28px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;background:rgba(124,58,237,0.08);">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 16px rgba(124,58,237,0.35);">
                            <i class="fas fa-graduation-cap" style="color:white;font-size:16px;"></i>
                        </div>
                        <div>
                            <div style="font-family:'Outfit',sans-serif;font-size:17px;font-weight:700;color:#f1f5f9;">Crear Nuevo Curso</div>
                            <div style="font-size:11px;color:#64748b;margin-top:1px;">Completa los datos para publicar un nuevo curso</div>
                        </div>
                    </div>
                    <button type="button" wire:click="$set('showCreateModal', false)"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;width:34px;height:34px;border-radius:10px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                        onmouseover="this.style.background='rgba(239,68,68,0.2)';this.style.color='#f87171'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)';this.style.color='#94a3b8'">
                        &times;
                    </button>
                </div>

                {{-- Modal body --}}
                <form wire:submit.prevent="store">
                    <div style="padding:28px;">

                        <div class="form-group">
                            <label for="title">Título del Curso</label>
                            <input type="text" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                wire:model="title"
                                placeholder="Ej: Curso de Programación Web desde Cero">
                            @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Precio de Venta ($)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" step="0.01" id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    wire:model="price"
                                    placeholder="0.00">
                            </div>
                            @error('price') <span style="color:#f87171;font-size:12px;">{{ $message }}</span> @enderror
                            <small style="color:#475569;font-size:11px;margin-top:4px;display:block;">Ingresa 0.00 si el curso es gratuito o solo accesible por suscripción.</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción del Curso</label>
                            <textarea
                                id="description"
                                wire:model="description"
                                rows="6"
                                placeholder="Escribe una descripción atractiva del curso: qué aprenderán, para quién es, requisitos, etc."
                                style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:#f1f5f9;font-size:14px;padding:12px 14px;resize:vertical;font-family:'Inter',sans-serif;line-height:1.7;outline:none;transition:all 0.2s;"
                                onfocus="this.style.borderColor='rgba(124,58,237,0.6)';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.2)';"
                                onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none';"
                            ></textarea>
                            @error('description') <span style="color:#f87171;font-size:12px;">{{ $message }}</span> @enderror
                            <small style="color:#475569;font-size:11px;margin-top:4px;display:block;">Puedes usar texto plano. El formato avanzado se puede editar desde el editor completo del curso.</small>
                        </div>

                        <div class="form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" wire:model="is_published">
                                <label class="custom-control-label" for="is_published" style="text-transform:none !important;letter-spacing:0 !important;font-size:13px !important;font-weight:500 !important;color:#94a3b8 !important;">
                                    Publicar inmediatamente al guardar
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Modal footer --}}
                    <div style="padding:16px 28px;border-top:1px solid rgba(255,255,255,0.07);display:flex;justify-content:flex-end;gap:10px;background:rgba(0,0,0,0.1);">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showCreateModal', false)">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" style="min-width:140px;">
                            <i class="fas fa-save mr-1"></i> Guardar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    (function() {
        document.body.style.overflow = 'hidden';
    })();
    </script>
    @else
    <script>
    (function() {
        document.body.style.overflow = '';
    })();
    </script>
    @endif

</div>
