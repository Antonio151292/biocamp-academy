<div class="pt-2">

    {{-- ============================================================ --}}
    {{--  BIOCAMP — Course Editor: Full Premium Layout               --}}
    {{-- ============================================================ --}}

    {{-- Top bar --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 4px 16px;flex-wrap:wrap;gap:10px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('admin.courses.index') }}" style="display:flex;align-items:center;gap:6px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;padding:7px 14px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.09)';this.style.color='#f1f5f9'"
                onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='#94a3b8'">
                <i class="fas fa-arrow-left" style="font-size:11px;"></i> Volver a Cursos
            </a>
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:8px;height:8px;border-radius:50%;background:{{ $courseIsPublished ? '#10b981' : '#f59e0b' }};box-shadow:0 0 0 3px {{ $courseIsPublished ? 'rgba(16,185,129,0.25)' : 'rgba(245,158,11,0.25)' }};"></div>
                <span style="font-size:12px;color:{{ $courseIsPublished ? '#34d399' : '#fbbf24' }};font-weight:600;">
                    {{ $courseIsPublished ? 'Publicado' : 'Borrador' }}
                </span>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            @if (session()->has('course_message') || session()->has('sections_message'))
                <div style="font-size:12px;color:#34d399;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);padding:5px 14px;border-radius:20px;">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ session('course_message') ?? session('sections_message') }}
                </div>
            @endif
            <button form="course-form" type="submit" class="btn btn-primary" style="font-size:13px;padding:8px 20px;">
                <i class="fas fa-save mr-1"></i> Guardar Curso
            </button>
        </div>
    </div>

    <div class="row">

        {{-- ============================================================ --}}
        {{-- LEFT: Course Settings                                         --}}
        {{-- ============================================================ --}}
        <div class="col-lg-4 mb-4">

            {{-- Course Info Card --}}
            <div class="card card-primary mb-4">
                <div class="card-header">
                    <span style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#8b5cf6;display:block;margin-bottom:2px;">Configuración</span>
                    <h3 class="card-title" style="font-size:15px !important;">Información del Curso</h3>
                </div>
                <form id="course-form" wire:submit.prevent="updateCourse">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="courseTitle">Título del Curso</label>
                            <input type="text" id="courseTitle"
                                class="form-control @error('courseTitle') is-invalid @enderror"
                                wire:model="courseTitle"
                                placeholder="Ej: Diseño Web desde Cero">
                            @error('courseTitle') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="coursePrice">Precio de Venta ($)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign" style="font-size:11px;"></i></span>
                                </div>
                                <input type="number" step="0.01" id="coursePrice"
                                    class="form-control @error('coursePrice') is-invalid @enderror"
                                    wire:model="coursePrice"
                                    placeholder="0.00">
                            </div>
                            @error('coursePrice') <span style="color:#f87171;font-size:12px;">{{ $message }}</span> @enderror
                            <small style="color:#475569;font-size:11px;margin-top:4px;display:block;">0.00 = gratuito o solo por suscripción.</small>
                        </div>

                        <div class="form-group">
                            <label for="courseDescription">Descripción</label>
                            <div wire:ignore>
                                <textarea id="courseDescription_editor"
                                    style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;color:#f1f5f9;font-size:13px;padding:10px 12px;resize:vertical;font-family:'Inter',sans-serif;line-height:1.7;min-height:100px;"
                                    placeholder="Describe el curso: qué aprenderán, para quién es, requisitos...">{{ $courseDescription }}</textarea>
                            </div>
                            {{-- Hidden sync field --}}
                            <input type="hidden" wire:model="courseDescription" id="courseDescHidden">
                        </div>

                        <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>

                        {{-- Cover Image --}}
                        <div class="form-group">
                            <label>Imagen de Portada</label>
                            @if ($course->getFirstMediaUrl('cover'))
                                <div style="margin-bottom:10px;border-radius:10px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);">
                                    <img src="{{ $course->getFirstMediaUrl('cover') }}" style="width:100%;max-height:130px;object-fit:cover;" alt="Portada actual">
                                </div>
                            @else
                                <div style="height:80px;border:2px dashed rgba(255,255,255,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#334155;margin-bottom:10px;font-size:12px;">
                                    <i class="fas fa-image mr-2"></i> Sin imagen de portada
                                </div>
                            @endif
                            <input type="file" class="form-control" wire:model="courseImage" accept="image/*" style="font-size:12px;padding:6px;">
                            <div wire:loading wire:target="courseImage" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo imagen...</div>
                        </div>

                        <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>

                        {{-- Publish toggle --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:14px;">
                            <div>
                                <div style="font-size:13px;font-weight:600;color:#f1f5f9;margin-bottom:2px;">Visibilidad del Curso</div>
                                <div style="font-size:11px;color:#475569;">Visible en el catálogo público</div>
                            </div>
                            <div class="custom-control custom-switch mb-0">
                                <input type="checkbox" class="custom-control-input" id="courseIsPublished" wire:model="courseIsPublished">
                                <label class="custom-control-label" for="courseIsPublished" style="text-transform:none !important;letter-spacing:0 !important;font-size:12px !important;"></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Course Stats summary --}}
            <div class="card" style="background:linear-gradient(145deg,rgba(124,58,237,0.1),rgba(79,70,229,0.05)) !important;border:1px solid rgba(124,58,237,0.2) !important;">
                <div class="card-body py-3 px-4">
                    <div style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#8b5cf6;margin-bottom:12px;">Resumen del Contenido</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div style="text-align:center;background:rgba(255,255,255,0.04);border-radius:10px;padding:12px;">
                            <div style="font-family:'Outfit',sans-serif;font-size:24px;font-weight:800;color:#f1f5f9;">{{ $sections->count() }}</div>
                            <div style="font-size:11px;color:#64748b;">Secciones</div>
                        </div>
                        <div style="text-align:center;background:rgba(255,255,255,0.04);border-radius:10px;padding:12px;">
                            <div style="font-family:'Outfit',sans-serif;font-size:24px;font-weight:800;color:#f1f5f9;">{{ $sections->sum(fn($s) => $s->lessons->count()) }}</div>
                            <div style="font-size:11px;color:#64748b;">Lecciones</div>
                        </div>
                    </div>
                    <div style="margin-top:10px;background:rgba(255,255,255,0.04);border-radius:10px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12px;color:#64748b;">Precio</span>
                        <span style="font-size:16px;font-weight:700;color:#c4b5fd;font-family:'Outfit',sans-serif;">
                            {{ $coursePrice > 0 ? '$' . number_format($coursePrice, 2) : 'Gratis' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- RIGHT: Curriculum Builder                                     --}}
        {{-- ============================================================ --}}
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <span style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#06b6d4;display:block;margin-bottom:2px;">Contenido</span>
                        <h3 class="card-title" style="font-size:15px !important;">Plan de Estudios</h3>
                    </div>
                    <span style="font-size:11px;color:#64748b;">{{ $sections->count() }} sección(es)</span>
                </div>
                <div class="card-body">

                    {{-- Add Section form --}}
                    <form wire:submit.prevent="addSection">
                        <div style="display:flex;gap:8px;margin-bottom:20px;">
                            <input type="text" class="form-control" placeholder="Nombre de la nueva sección (ej: Introducción al curso)" wire:model="newSectionTitle" style="flex:1;">
                            <button type="submit" class="btn btn-success" style="white-space:nowrap;flex-shrink:0;">
                                <i class="fas fa-folder-plus mr-1"></i> Agregar Sección
                            </button>
                        </div>
                    </form>

                    {{-- Sections & Lessons List --}}
                    @forelse($sections as $index => $section)
                        <div style="border:1px solid rgba(255,255,255,0.08);border-radius:14px;margin-bottom:12px;overflow:hidden;background:rgba(255,255,255,0.02);">

                            {{-- Section Header --}}
                            <div style="padding:12px 16px;background:rgba(255,255,255,0.04);border-bottom:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:space-between;gap:10px;">
                                <div style="display:flex;align-items:center;gap:10px;flex:1;min-width:0;">
                                    <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#0891b2,#0e7490);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <span style="font-size:11px;font-weight:800;color:white;">{{ $index + 1 }}</span>
                                    </div>

                                    @if($editingSectionId === $section->id)
                                        <div style="display:flex;gap:6px;flex:1;">
                                            <input type="text" class="form-control" wire:model="editingSectionTitle" style="font-size:13px;flex:1;">
                                            <button class="btn btn-sm btn-primary" wire:click="updateSection" style="flex-shrink:0;"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-secondary" wire:click="$set('editingSectionId', null)" style="flex-shrink:0;"><i class="fas fa-times"></i></button>
                                        </div>
                                    @else
                                        <span style="font-size:14px;font-weight:600;color:#f1f5f9;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $section->title }}</span>
                                        <span style="font-size:10px;color:#64748b;white-space:nowrap;">{{ $section->lessons->count() }} clase(s)</span>
                                    @endif
                                </div>

                                <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                                    <button type="button" wire:click="moveSection({{ $section->id }}, 'up')" style="width:28px;height:28px;border-radius:7px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#64748b;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;" title="Subir">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button type="button" wire:click="moveSection({{ $section->id }}, 'down')" style="width:28px;height:28px;border-radius:7px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#64748b;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;" title="Bajar">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    @if($editingSectionId !== $section->id)
                                    <button type="button" wire:click="editSection({{ $section->id }})" style="width:28px;height:28px;border-radius:7px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#94a3b8;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;" title="Renombrar">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    @endif
                                    <button type="button" wire:click="selectSectionForLesson({{ $section->id }})"
                                        style="padding:5px 12px;border-radius:7px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.35);color:#34d399;cursor:pointer;font-size:11px;font-weight:600;display:flex;align-items:center;gap:4px;"
                                        title="Añadir clase">
                                        <i class="fas fa-plus"></i> Clase
                                    </button>
                                    <button type="button" onclick="confirm('¿Eliminar sección y TODAS sus clases?') || event.stopImmediatePropagation()" wire:click="deleteSection({{ $section->id }})" style="width:28px;height:28px;border-radius:7px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;" title="Eliminar sección">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Add Lesson inline form --}}
                            @if ($selectedSectionId === $section->id)
                                <div style="padding:12px 16px;background:rgba(16,185,129,0.06);border-bottom:1px solid rgba(16,185,129,0.15);">
                                    <form wire:submit.prevent="addLesson" style="display:flex;gap:8px;align-items:center;">
                                        <i class="fas fa-play-circle" style="color:#34d399;font-size:14px;flex-shrink:0;"></i>
                                        <input type="text" class="form-control" placeholder="Nombre de la nueva lección/clase" wire:model="newLessonTitle" style="flex:1;font-size:13px;">
                                        <button type="submit" class="btn btn-success btn-sm" style="flex-shrink:0;white-space:nowrap;">Crear Clase</button>
                                        <button type="button" wire:click="$set('selectedSectionId', null)" style="background:transparent;border:none;color:#64748b;cursor:pointer;font-size:13px;flex-shrink:0;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif

                            {{-- Lessons list --}}
                            @if($section->lessons->count() > 0)
                                <div>
                                    @foreach($section->lessons->sortBy('order') as $lIndex => $lesson)
                                        <div style="padding:10px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;border-bottom:1px solid rgba(255,255,255,0.04);transition:background 0.15s;"
                                            onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                                            onmouseout="this.style.background='transparent'">
                                            <div style="display:flex;align-items:center;gap:10px;flex:1;min-width:0;">
                                                <div style="width:22px;height:22px;border-radius:6px;background:{{ $lesson->is_free ? 'rgba(16,185,129,0.2)' : 'rgba(124,58,237,0.2)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="fas {{ $lesson->video_provider === 'drive' ? 'fa-brands fa-google-drive' : 'fa-play' }}" style="color:{{ $lesson->is_free ? '#34d399' : '#8b5cf6' }};font-size:9px;"></i>
                                                </div>
                                                <span style="font-size:13px;color:#cbd5e1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                    {{ $lIndex + 1 }}. {{ $lesson->title }}
                                                </span>
                                                @if($lesson->is_free)
                                                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);border-radius:5px;padding:1px 7px;white-space:nowrap;flex-shrink:0;">
                                                        Vista previa
                                                    </span>
                                                @endif
                                                @if($lesson->video_url || $lesson->getFirstMediaUrl('video'))
                                                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;background:rgba(6,182,212,0.12);color:#67e8f9;border:1px solid rgba(6,182,212,0.25);border-radius:5px;padding:1px 7px;white-space:nowrap;flex-shrink:0;">
                                                        <i class="fas fa-video" style="font-size:8px;"></i> Video
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                                                <button type="button" wire:click="moveLesson({{ $lesson->id }}, 'up')" style="width:24px;height:24px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#64748b;cursor:pointer;font-size:9px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <button type="button" wire:click="moveLesson({{ $lesson->id }}, 'down')" style="width:24px;height:24px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#64748b;cursor:pointer;font-size:9px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                                <button type="button" wire:click="openEditLessonModal({{ $lesson->id }})"
                                                    style="padding:4px 12px;border-radius:7px;background:rgba(6,182,212,0.12);border:1px solid rgba(6,182,212,0.3);color:#67e8f9;cursor:pointer;font-size:11px;font-weight:600;display:flex;align-items:center;gap:4px;">
                                                    <i class="fas fa-cog"></i> Editar
                                                </button>
                                                <button type="button" onclick="confirm('¿Eliminar esta lección?') || event.stopImmediatePropagation()" wire:click="deleteLesson({{ $lesson->id }})" style="width:26px;height:26px;border-radius:6px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;cursor:pointer;font-size:10px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div style="padding:20px;text-align:center;color:#334155;">
                                    <i class="fas fa-play-circle" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                    <span style="font-size:12px;">Sin clases aún. Haz clic en <strong style="color:#34d399;">+ Clase</strong> para agregar la primera.</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="text-align:center;padding:50px 20px;border:2px dashed rgba(255,255,255,0.07);border-radius:14px;">
                            <i class="fas fa-folder-open" style="font-size:40px;color:#334155;display:block;margin-bottom:14px;"></i>
                            <h5 style="color:#475569;font-weight:600;margin-bottom:6px;">Sin secciones todavía</h5>
                            <p style="color:#334155;font-size:13px;max-width:300px;margin:0 auto;">Crea la primera sección del plan de estudios usando el campo de arriba.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- LESSON EDITOR MODAL — Fixed scrollable overlay              --}}
    {{-- ============================================================ --}}
    @if($editingLessonId)
    @php $activeLesson = \App\Models\Lesson::find($editingLessonId); @endphp
    <div
        style="position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.7);backdrop-filter:blur(5px);overflow-y:auto;padding:30px 16px;"
        wire:click.self="$set('editingLessonId', null)"
        role="dialog"
        aria-modal="true"
    >
        <div style="max-width:820px;width:100%;margin:0 auto;">
            <div style="background:#1e293b;border:1px solid rgba(255,255,255,0.08);border-radius:20px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,0.7);">

                {{-- Modal header --}}
                <div style="padding:20px 24px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;background:rgba(6,182,212,0.07);">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#0891b2,#0e7490);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 16px rgba(6,182,212,0.3);">
                            <i class="fas fa-play" style="color:white;font-size:14px;"></i>
                        </div>
                        <div>
                            <div style="font-family:'Outfit',sans-serif;font-size:16px;font-weight:700;color:#f1f5f9;">Editar Clase</div>
                            <div style="font-size:11px;color:#64748b;margin-top:1px;">{{ $lessonTitle }}</div>
                        </div>
                    </div>
                    <button type="button" wire:click="$set('editingLessonId', null)"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;width:34px;height:34px;border-radius:10px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;"
                        onmouseover="this.style.background='rgba(239,68,68,0.2)';this.style.color='#f87171'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)';this.style.color='#94a3b8'">
                        &times;
                    </button>
                </div>

                {{-- Modal body --}}
                <form wire:submit.prevent="updateLesson">
                    <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:24px;">

                        {{-- Left column --}}
                        <div>
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#0891b2;margin-bottom:14px;">Información Básica</div>

                            <div class="form-group">
                                <label>Título de la Clase</label>
                                <input type="text" class="form-control" wire:model="lessonTitle" placeholder="Ej: Introducción a HTML">
                            </div>

                            <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#8b5cf6;margin-bottom:14px;">Configuración del Video</div>

                            <div class="form-group">
                                <label>Fuente del Video</label>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                                    <label style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:{{ $lessonVideoProvider === 'local' ? 'rgba(124,58,237,0.2)' : 'rgba(255,255,255,0.03)' }};border:1px solid {{ $lessonVideoProvider === 'local' ? 'rgba(124,58,237,0.6)' : 'rgba(255,255,255,0.07)' }};border-radius:10px;cursor:pointer;transition:all 0.15s;">
                                        <input type="radio" wire:model="lessonVideoProvider" value="local" style="accent-color:#7c3aed;width:14px;height:14px;">
                                        <div>
                                            <div style="font-size:12px;font-weight:600;color:{{ $lessonVideoProvider === 'local' ? '#c4b5fd' : '#94a3b8' }};">Archivo Local</div>
                                            <div style="font-size:10px;color:#475569;">.mp4, .webm</div>
                                        </div>
                                    </label>
                                    <label style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:{{ $lessonVideoProvider === 'drive' ? 'rgba(16,185,129,0.15)' : 'rgba(255,255,255,0.03)' }};border:1px solid {{ $lessonVideoProvider === 'drive' ? 'rgba(16,185,129,0.5)' : 'rgba(255,255,255,0.07)' }};border-radius:10px;cursor:pointer;transition:all 0.15s;">
                                        <input type="radio" wire:model="lessonVideoProvider" value="drive" style="accent-color:#10b981;width:14px;height:14px;">
                                        <div>
                                            <div style="font-size:12px;font-weight:600;color:{{ $lessonVideoProvider === 'drive' ? '#34d399' : '#94a3b8' }};">Google Drive</div>
                                            <div style="font-size:10px;color:#475569;">URL embed</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            @if ($lessonVideoProvider === 'drive')
                                <div class="form-group">
                                    <label>URL de Google Drive (embed)</label>
                                    <input type="text" class="form-control" wire:model="lessonVideoUrl" placeholder="https://drive.google.com/file/d/.../preview">
                                    <small style="color:#475569;font-size:11px;margin-top:4px;display:block;">
                                        En Drive: botón "Compartir" → "Copiar enlace". Luego cambia <code style="color:#8b5cf6;">/view</code> por <code style="color:#8b5cf6;">/preview</code>
                                    </small>
                                </div>

                                @if(!empty($lessonVideoUrl))
                                    <div style="border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);margin-bottom:12px;">
                                        <div style="padding:8px 12px;background:rgba(16,185,129,0.08);border-bottom:1px solid rgba(255,255,255,0.06);font-size:11px;color:#34d399;font-weight:600;">
                                            <i class="fas fa-eye mr-1"></i> Vista previa del video
                                        </div>
                                        <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;background:#0f172a;">
                                            <iframe src="{{ $lessonVideoUrl }}" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="form-group">
                                    <label>Subir Video Local</label>
                                    @if ($activeLesson && $activeLesson->getFirstMediaUrl('video'))
                                        <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.25);border-radius:10px;padding:10px 14px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                                            <i class="fas fa-check-circle" style="color:#34d399;"></i>
                                            <div>
                                                <div style="font-size:12px;font-weight:600;color:#34d399;">Video subido</div>
                                                <div style="font-size:11px;color:#475569;">{{ basename($activeLesson->getFirstMediaPath('video')) }}</div>
                                            </div>
                                            <a href="{{ $activeLesson->getFirstMediaUrl('video') }}" target="_blank" style="margin-left:auto;font-size:11px;color:#67e8f9;">
                                                <i class="fas fa-external-link-alt"></i> Ver
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" wire:model="lessonVideoFile" accept="video/mp4,video/webm,video/quicktime" style="font-size:12px;padding:6px;">
                                    <div wire:loading wire:target="lessonVideoFile" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo video... (puede tardar)</div>
                                    <small style="color:#475569;font-size:11px;margin-top:4px;display:block;">Formatos: MP4, WebM, MOV. Máx. 500MB.</small>
                                </div>
                            @endif

                            {{-- Free preview toggle --}}
                            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:14px;display:flex;align-items:center;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:600;color:#f1f5f9;">Vista Previa Gratuita</div>
                                    <div style="font-size:11px;color:#475569;">Visible sin comprar el curso</div>
                                </div>
                                <div class="custom-control custom-switch mb-0">
                                    <input type="checkbox" class="custom-control-input" id="lessonIsFreeModal" wire:model="lessonIsFree">
                                    <label class="custom-control-label" for="lessonIsFreeModal" style="text-transform:none !important;letter-spacing:0 !important;"></label>
                                </div>
                            </div>
                        </div>

                        {{-- Right column --}}
                        <div>
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#f59e0b;margin-bottom:14px;">Contenido de la Clase</div>

                            <div class="form-group">
                                <label>Notas / Texto de la Clase</label>
                                <textarea
                                    wire:model="lessonContent"
                                    rows="8"
                                    placeholder="Escribe las notas, instrucciones, o descripción de esta lección..."
                                    style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:#f1f5f9;font-size:13px;padding:12px 14px;resize:vertical;font-family:'Inter',sans-serif;line-height:1.7;outline:none;"
                                    onfocus="this.style.borderColor='rgba(124,58,237,0.6)';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.2)';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none';"
                                ></textarea>
                            </div>

                            <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#ec4899;margin-bottom:14px;">Archivos Descargables</div>

                            {{-- Existing attachments --}}
                            @if ($activeLesson && $activeLesson->getMedia('downloads')->count() > 0)
                                <div style="margin-bottom:12px;">
                                    @foreach($activeLesson->getMedia('downloads') as $media)
                                        <div style="display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:8px;padding:8px 12px;margin-bottom:6px;">
                                            <div style="display:flex;align-items:center;gap:8px;overflow:hidden;">
                                                <i class="far fa-file" style="color:#8b5cf6;font-size:14px;flex-shrink:0;"></i>
                                                <div style="overflow:hidden;">
                                                    <div style="font-size:12px;color:#e2e8f0;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $media->name }}</div>
                                                    <div style="font-size:10px;color:#475569;">{{ number_format($media->size/1024/1024, 2) }} MB</div>
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removeMedia({{ $activeLesson->id }}, {{ $media->id }})"
                                                style="width:24px;height:24px;border-radius:6px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;cursor:pointer;font-size:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Upload new attachment --}}
                            <div style="background:rgba(255,255,255,0.02);border:1px dashed rgba(255,255,255,0.1);border-radius:10px;padding:14px;">
                                <label style="font-size:11px;color:#64748b;margin-bottom:6px;">Subir archivo (PDF, ZIP, DOCX...)</label>
                                <input type="file" class="form-control" wire:model="lessonAttachmentFile" style="font-size:12px;padding:6px;">
                                <div wire:loading wire:target="lessonAttachmentFile" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo archivo...</div>
                                <small style="color:#475569;font-size:10px;margin-top:6px;display:block;">El archivo se adjuntará al guardar los cambios.</small>
                            </div>
                        </div>
                    </div>

                    {{-- Modal footer --}}
                    <div style="padding:16px 24px;border-top:1px solid rgba(255,255,255,0.07);display:flex;justify-content:flex-end;gap:10px;background:rgba(0,0,0,0.1);">
                        <button type="button" class="btn btn-secondary" wire:click="$set('editingLessonId', null)">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" style="min-width:160px;">
                            <i class="fas fa-save mr-1"></i> Guardar Clase
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

{{-- Sync the course description textarea with Livewire --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var descTextarea = document.getElementById('courseDescription_editor');
    var hiddenInput = document.getElementById('courseDescHidden');
    if (descTextarea && hiddenInput) {
        descTextarea.addEventListener('input', function() {
            hiddenInput.value = this.value;
            hiddenInput.dispatchEvent(new Event('input'));
        });
    }
});
</script>
