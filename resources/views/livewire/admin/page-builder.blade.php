@php use Illuminate\Support\Str; @endphp
<div style="display:flex;flex-direction:column;height:calc(100vh - 80px);overflow:hidden;" class="pt-2">

    {{-- ============================================================ --}}
    {{--  BIOCAMP PAGE BUILDER — Canva-like 3-panel layout           --}}
    {{-- ============================================================ --}}

    {{-- Top toolbar --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 20px;background:rgba(15,23,42,0.98);border-bottom:1px solid rgba(255,255,255,0.07);flex-shrink:0;backdrop-filter:blur(16px);z-index:10;">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-paint-brush" style="color:white;font-size:14px;"></i>
                </div>
                <div>
                    <div style="font-family:'Outfit',sans-serif;font-size:14px;font-weight:700;color:#f1f5f9;line-height:1.2;">Editor de Páginas</div>
                    <div style="font-size:10px;color:#64748b;font-weight:500;">Página de Inicio — Guardado automático</div>
                </div>
            </div>

            {{-- Undo/Redo & tools --}}
            <div style="display:flex;align-items:center;gap:6px;padding-left:16px;border-left:1px solid rgba(255,255,255,0.07);">
                <button class="btn btn-sm" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);color:#94a3b8;border-radius:8px;padding:6px 10px;" title="Mover arriba" disabled>
                    <i class="fas fa-undo" style="font-size:11px;"></i>
                </button>
                <button class="btn btn-sm" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);color:#94a3b8;border-radius:8px;padding:6px 10px;" title="Mover abajo" disabled>
                    <i class="fas fa-redo" style="font-size:11px;"></i>
                </button>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            @if (session()->has('builder_message'))
                <div style="font-size:12px;color:#34d399;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);padding:4px 12px;border-radius:20px;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-check-circle"></i> {{ session('builder_message') }}
                </div>
            @endif
            <a href="/" target="_blank" class="btn btn-sm" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;border-radius:8px;font-size:12px;padding:6px 14px;">
                <i class="fas fa-external-link-alt mr-1" style="font-size:10px;"></i> Ver Sitio
            </a>
            <button wire:click="savePage" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:12px;padding:6px 16px;font-weight:600;">
                <i class="fas fa-save mr-1" style="font-size:11px;"></i> Publicar
            </button>
        </div>
    </div>

    {{-- Main 3-panel body --}}
    <div style="display:flex;flex:1;overflow:hidden;">

        {{-- ============================== --}}
        {{-- LEFT PANEL: Block palette      --}}
        {{-- ============================== --}}
        <div style="width:220px;flex-shrink:0;background:#0f172a;border-right:1px solid rgba(255,255,255,0.06);overflow-y:auto;padding:16px 12px;">

            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#4b5563;text-transform:uppercase;margin-bottom:12px;padding:0 4px;">Bloques</div>

            {{-- Block type buttons --}}
            @php
                $palette = [
                    'hero'        => ['icon' => 'fa-image',      'label' => 'Banner Hero',      'color' => '#7c3aed'],
                    'features'    => ['icon' => 'fa-th-large',   'label' => 'Características',  'color' => '#06b6d4'],
                    'courses'     => ['icon' => 'fa-graduation-cap', 'label' => 'Cursos',        'color' => '#10b981'],
                    'cta'         => ['icon' => 'fa-bullhorn',   'label' => 'CTA',               'color' => '#f59e0b'],
                    'faq'         => ['icon' => 'fa-question-circle', 'label' => 'FAQ',           'color' => '#ec4899'],
                    'rich_text'   => ['icon' => 'fa-font',       'label' => 'Texto Enriquecido', 'color' => '#8b5cf6'],
                    'image_block' => ['icon' => 'fa-photo-video','label' => 'Imagen',            'color' => '#0891b2'],
                    'video_block' => ['icon' => 'fa-play-circle','label' => 'Video',             'color' => '#dc2626'],
                ];
            @endphp

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:20px;">
                @foreach($palette as $type => $info)
                    <button type="button" wire:click="addSection('{{ $type }}')"
                        style="background:rgba(255,255,255,0.03);border:1px dashed rgba(255,255,255,0.1);border-radius:12px;padding:14px 6px;cursor:pointer;transition:all 0.2s ease;text-align:center;display:flex;flex-direction:column;align-items:center;gap:6px;"
                        onmouseover="this.style.background='rgba({{ implode(',', sscanf($info['color'], '#%02x%02x%02x')) }},0.15)';this.style.borderColor='{{ $info['color'] }}';"
                        onmouseout="this.style.background='rgba(255,255,255,0.03)';this.style.borderColor='rgba(255,255,255,0.1)';"
                        title="Agregar {{ $info['label'] }}">
                        <i class="fas {{ $info['icon'] }}" style="color:{{ $info['color'] }};font-size:18px;"></i>
                        <span style="font-size:10px;color:#94a3b8;font-weight:600;line-height:1.2;">{{ $info['label'] }}</span>
                    </button>
                @endforeach
            </div>

            <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;color:#4b5563;text-transform:uppercase;margin-bottom:12px;padding:0 4px;">Secciones activas</div>

            {{-- Active sections list with drag-handle --}}
            <div id="sortable-sections-sidebar"
                x-data
                x-init="
                    if(typeof Sortable !== 'undefined') {
                        Sortable.create($el, {
                            handle: '.drag-handle',
                            animation: 150,
                            onEnd: function () {
                                let orderIds = [];
                                $el.querySelectorAll('[data-id]').forEach(function (item) {
                                    orderIds.push(item.getAttribute('data-id'));
                                });
                                @this.call('updateSectionsOrder', orderIds);
                            }
                        });
                    }
                ">
                @forelse($sections as $index => $sec)
                    @php
                        $typeColors = [
                            'hero' => '#7c3aed', 'features' => '#06b6d4', 'courses' => '#10b981',
                            'cta' => '#f59e0b', 'faq' => '#ec4899', 'rich_text' => '#8b5cf6',
                            'image_block' => '#0891b2', 'video_block' => '#dc2626',
                        ];
                        $tc = $typeColors[$sec['type']] ?? '#8b5cf6';
                    @endphp
                    <div data-id="{{ $sec['id'] }}"
                        wire:click="selectSection('{{ $sec['id'] }}')"
                        style="background:{{ $selectedSectionId === $sec['id'] ? 'rgba(124,58,237,0.18)' : 'rgba(255,255,255,0.02)' }};border:1px solid {{ $selectedSectionId === $sec['id'] ? 'rgba(124,58,237,0.6)' : 'rgba(255,255,255,0.06)' }};border-radius:10px;padding:8px 10px;margin-bottom:6px;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all 0.2s ease;">
                        <span class="drag-handle" style="color:{{ $selectedSectionId === $sec['id'] ? '#8b5cf6' : '#334155' }};cursor:grab;font-size:11px;" title="Arrastrar para reordenar">
                            <i class="fas fa-grip-vertical"></i>
                        </span>
                        <div style="width:6px;height:6px;border-radius:50%;background:{{ $tc }};flex-shrink:0;"></div>
                        <div style="flex:1;overflow:hidden;">
                            <div style="font-size:11px;font-weight:600;color:{{ $selectedSectionId === $sec['id'] ? '#c4b5fd' : '#94a3b8' }};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $sec['title'] ?? ucfirst($sec['type']) }}
                            </div>
                            <div style="font-size:9px;color:#4b5563;text-transform:uppercase;letter-spacing:0.8px;">{{ $sec['type'] }}</div>
                        </div>
                        <button type="button" onclick="event.stopPropagation()" wire:click.stop="deleteSection('{{ $sec['id'] }}')"
                            style="background:transparent;border:none;color:#374151;padding:2px 4px;cursor:pointer;border-radius:4px;font-size:11px;"
                            onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#374151'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @empty
                    <div style="text-align:center;padding:30px 10px;color:#334155;">
                        <i class="fas fa-cubes" style="font-size:28px;margin-bottom:10px;display:block;"></i>
                        <span style="font-size:11px;">Sin secciones.<br>Añade un bloque arriba.</span>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ============================== --}}
        {{-- CENTER PANEL: Canvas preview   --}}
        {{-- ============================== --}}
        <div style="flex:1;background:#0f172a;overflow-y:auto;padding:20px 24px;position:relative;">
            <div style="background-image:radial-gradient(circle,rgba(255,255,255,0.025) 1px,transparent 1px);background-size:24px 24px;position:absolute;inset:0;pointer-events:none;z-index:0;"></div>

            @if(count($sections) === 0)
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;position:relative;z-index:1;">
                    <div style="width:80px;height:80px;border-radius:20px;background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(79,70,229,0.2));display:flex;align-items:center;justify-content:center;border:1px dashed rgba(124,58,237,0.4);margin-bottom:20px;">
                        <i class="fas fa-paint-brush" style="font-size:32px;color:#7c3aed;"></i>
                    </div>
                    <h3 style="font-family:'Outfit',sans-serif;color:#f1f5f9;font-weight:700;margin-bottom:10px;">Tu lienzo está vacío</h3>
                    <p style="color:#475569;font-size:14px;text-align:center;max-width:300px;">Agrega bloques desde el panel izquierdo para comenzar a diseñar tu página de inicio.</p>
                </div>
            @else
                {{-- Canvas rendering of sections as mini previews --}}
                <div style="position:relative;z-index:1;max-width:900px;margin:0 auto;">
                    @foreach($sections as $index => $sec)
                        @php
                            $typeColors = [
                                'hero' => '#7c3aed', 'features' => '#06b6d4', 'courses' => '#10b981',
                                'cta' => '#f59e0b', 'faq' => '#ec4899', 'rich_text' => '#8b5cf6',
                                'image_block' => '#0891b2', 'video_block' => '#dc2626',
                            ];
                            $tc = $typeColors[$sec['type']] ?? '#8b5cf6';
                            $isSelected = $selectedSectionId === $sec['id'];
                        @endphp

                        <div wire:click="selectSection('{{ $sec['id'] }}')"
                            style="border-radius:14px;margin-bottom:12px;cursor:pointer;transition:all 0.25s ease;overflow:hidden;position:relative;border:2px solid {{ $isSelected ? $tc : 'transparent' }};box-shadow:{{ $isSelected ? '0 0 0 3px rgba(124,58,237,0.2)' : 'none' }};">

                            {{-- Section type label overlay --}}
                            <div style="position:absolute;top:10px;left:10px;z-index:5;display:flex;align-items:center;gap:6px;">
                                <span style="font-size:9px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;background:{{ $tc }};color:white;padding:3px 10px;border-radius:20px;">{{ $sec['type'] }}</span>
                                @if($isSelected)
                                    <span style="font-size:9px;font-weight:700;letter-spacing:1px;color:#c4b5fd;background:rgba(124,58,237,0.4);padding:3px 10px;border-radius:20px;border:1px solid rgba(124,58,237,0.6);">
                                        <i class="fas fa-pen mr-1"></i>Editando
                                    </span>
                                @endif
                            </div>

                            {{-- Move controls --}}
                            <div style="position:absolute;top:8px;right:8px;z-index:5;display:flex;gap:4px;" onclick="event.stopPropagation()">
                                <button type="button" wire:click.stop="moveSection({{ $index }}, 'up')" style="width:24px;height:24px;border-radius:6px;background:rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.15);color:#94a3b8;font-size:9px;cursor:pointer;display:flex;align-items:center;justify-content:center;" title="Subir">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <button type="button" wire:click.stop="moveSection({{ $index }}, 'down')" style="width:24px;height:24px;border-radius:6px;background:rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.15);color:#94a3b8;font-size:9px;cursor:pointer;display:flex;align-items:center;justify-content:center;" title="Bajar">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <button type="button" wire:click.stop="deleteSection('{{ $sec['id'] }}')" style="width:24px;height:24px;border-radius:6px;background:rgba(220,38,38,0.6);border:1px solid rgba(239,68,68,0.5);color:white;font-size:9px;cursor:pointer;display:flex;align-items:center;justify-content:center;" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            {{-- Section preview rendering --}}
                            @if($sec['type'] === 'hero')
                                <div style="background:linear-gradient(135deg,#1a0a3e,#0f172a);padding:40px 30px;text-align:center;min-height:130px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;{{ !empty($sec['bg_image_url']) ? 'background-image:url('.$sec['bg_image_url'].');background-size:cover;background-position:center;' : '' }}">
                                    <div style="font-family:'{{ $sec['title_font'] ?? 'Outfit' }}',sans-serif;font-size:clamp(20px,3vw,32px);font-weight:800;color:white;text-shadow:0 2px 20px rgba(0,0,0,0.5);">{{ $sec['title'] ?? 'Título del Banner' }}</div>
                                    @if(!empty($sec['subtitle']))
                                        <div style="font-size:13px;color:rgba(255,255,255,0.7);max-width:500px;">{{ Str::limit($sec['subtitle'], 80) }}</div>
                                    @endif
                                    @if(!empty($sec['button_text']))
                                        <div style="background:linear-gradient(135deg,#7c3aed,#4f46e5);color:white;font-weight:700;font-size:12px;padding:8px 20px;border-radius:25px;margin-top:4px;display:inline-block;">{{ $sec['button_text'] }}</div>
                                    @endif
                                </div>

                            @elseif($sec['type'] === 'features')
                                <div style="background:#1e293b;padding:24px 20px;">
                                    <div style="font-size:15px;font-weight:700;color:#f1f5f9;text-align:center;margin-bottom:16px;">{{ $sec['title'] ?? 'Características' }}</div>
                                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;">
                                        @foreach(($sec['items'] ?? []) as $item)
                                            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);border-radius:10px;padding:12px;text-align:center;">
                                                <i class="{{ $item['icon'] ?? 'fas fa-star' }}" style="color:#8b5cf6;font-size:16px;margin-bottom:6px;display:block;"></i>
                                                <div style="font-size:11px;font-weight:600;color:#e2e8f0;">{{ $item['title'] ?? 'Item' }}</div>
                                                <div style="font-size:10px;color:#64748b;margin-top:3px;">{{ Str::limit($item['desc'] ?? '', 30) }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif($sec['type'] === 'courses')
                                <div style="background:#1e293b;padding:24px 20px;">
                                    <div style="font-size:15px;font-weight:700;color:#f1f5f9;text-align:center;margin-bottom:6px;">{{ $sec['title'] ?? 'Cursos Destacados' }}</div>
                                    @if(!empty($sec['subtitle']))<div style="font-size:12px;color:#64748b;text-align:center;margin-bottom:14px;">{{ $sec['subtitle'] }}</div>@endif
                                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                                        @for($c = 0; $c < min(($sec['limit'] ?? 3), 3); $c++)
                                            <div style="background:rgba(255,255,255,0.04);border-radius:10px;overflow:hidden;">
                                                <div style="height:60px;background:linear-gradient(135deg,#1a1040,#0f172a);"></div>
                                                <div style="padding:10px;">
                                                    <div style="height:8px;border-radius:4px;background:rgba(255,255,255,0.08);margin-bottom:4px;"></div>
                                                    <div style="height:6px;border-radius:4px;background:rgba(255,255,255,0.05);width:60%;"></div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                            @elseif($sec['type'] === 'cta')
                                <div style="background:linear-gradient(135deg,#1a0a3e,#0c1445);padding:30px 20px;text-align:center;{{ !empty($sec['bg_image_url']) ? 'background-image:url('.$sec['bg_image_url'].');background-size:cover;' : '' }}">
                                    <div style="font-family:'{{ $sec['title_font'] ?? 'Outfit' }}',sans-serif;font-size:18px;font-weight:800;color:white;">{{ $sec['title'] ?? 'Llamada a la Acción' }}</div>
                                    @if(!empty($sec['subtitle']))<div style="font-size:12px;color:rgba(255,255,255,0.7);margin:8px 0;">{{ Str::limit($sec['subtitle'], 80) }}</div>@endif
                                    @if(!empty($sec['button_text']))<div style="background:#7c3aed;color:white;font-size:12px;font-weight:700;padding:7px 18px;border-radius:25px;display:inline-block;margin-top:8px;">{{ $sec['button_text'] }}</div>@endif
                                </div>

                            @elseif($sec['type'] === 'faq')
                                <div style="background:#1e293b;padding:24px 20px;">
                                    <div style="font-size:15px;font-weight:700;color:#f1f5f9;margin-bottom:12px;">{{ $sec['title'] ?? 'Preguntas Frecuentes' }}</div>
                                    @foreach(($sec['items'] ?? []) as $faq)
                                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:8px;padding:10px 14px;margin-bottom:6px;">
                                            <div style="font-size:12px;font-weight:600;color:#c4b5fd;">{{ $faq['question'] ?? '?' }}</div>
                                            <div style="font-size:11px;color:#64748b;margin-top:4px;">{{ Str::limit($faq['answer'] ?? '', 50) }}</div>
                                        </div>
                                    @endforeach
                                </div>

                            @elseif($sec['type'] === 'rich_text')
                                <div style="background:#1e293b;padding:24px 30px;text-align:{{ $sec['alignment'] ?? 'left' }};">
                                    @if(!empty($sec['title']))
                                        <div style="font-family:'{{ $sec['title_font'] ?? 'Outfit' }}',sans-serif;font-size:18px;font-weight:700;color:#f1f5f9;margin-bottom:10px;">{{ $sec['title'] }}</div>
                                    @endif
                                    <div style="font-family:'{{ $sec['font_family'] ?? 'Inter' }}',sans-serif;font-size:13px;color:#94a3b8;line-height:1.7;">
                                        {!! Str::limit(strip_tags($sec['content'] ?? ''), 200) !!}
                                    </div>
                                </div>

                            @elseif($sec['type'] === 'image_block')
                                <div style="background:#1e293b;padding:24px;text-align:{{ $sec['alignment'] ?? 'center' }};">
                                    @if(!empty($sec['image_url']))
                                        <img src="{{ $sec['image_url'] }}" style="max-width:{{ $sec['width'] ?? 80 }}%;border-radius:{{ ($sec['style'] ?? '') === 'circle' ? '50%' : '12px' }};box-shadow:{{ in_array($sec['style'] ?? '', ['shadow','rounded']) ? '0 20px 60px rgba(0,0,0,0.5)' : 'none' }};" alt="{{ $sec['title'] ?? '' }}" />
                                        @if(!empty($sec['title']))<div style="font-size:11px;color:#64748b;margin-top:8px;">{{ $sec['title'] }}</div>@endif
                                    @else
                                        <div style="border:2px dashed rgba(255,255,255,0.1);border-radius:12px;padding:30px;color:#334155;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                            <i class="fas fa-image" style="font-size:24px;"></i>
                                            <span style="font-size:12px;">Sin imagen — Sube una imagen en el inspector</span>
                                        </div>
                                    @endif
                                </div>

                            @elseif($sec['type'] === 'video_block')
                                <div style="background:#1e293b;padding:24px;text-align:{{ $sec['alignment'] ?? 'center' }};">
                                    @if(!empty($sec['video_url']))
                                        @php
                                            $videoUrl = $sec['video_url'];
                                            $isYoutube = str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be');
                                            if($isYoutube) {
                                                preg_match('/(?:v=|\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $matches);
                                                $ytId = $matches[1] ?? '';
                                                $embedUrl = 'https://www.youtube.com/embed/' . $ytId;
                                            }
                                        @endphp
                                        @if($isYoutube && !empty($ytId))
                                            <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:12px;max-width:{{ $sec['width'] ?? 80 }}%;margin:0 auto;">
                                                <iframe src="{{ $embedUrl }}" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;border-radius:12px;" allowfullscreen></iframe>
                                            </div>
                                        @else
                                            <video controls style="max-width:{{ $sec['width'] ?? 80 }}%;border-radius:12px;">
                                                <source src="{{ $videoUrl }}">
                                            </video>
                                        @endif
                                    @else
                                        <div style="border:2px dashed rgba(255,255,255,0.1);border-radius:12px;padding:30px;color:#334155;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                            <i class="fas fa-play-circle" style="font-size:32px;"></i>
                                            <span style="font-size:12px;">Sin video — Agrega una URL o sube un video</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ============================== --}}
        {{-- RIGHT PANEL: Inspector         --}}
        {{-- ============================== --}}
        <div style="width:300px;flex-shrink:0;background:#0f172a;border-left:1px solid rgba(255,255,255,0.06);overflow-y:auto;">

            @if($selectedSectionId)
                {{-- Inspector header --}}
                <div style="padding:16px 16px 12px;border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(124,58,237,0.08);">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div style="font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#8b5cf6;margin-bottom:3px;">Inspector</div>
                            <div style="font-size:13px;font-weight:700;color:#f1f5f9;">{{ ucfirst(str_replace('_', ' ', $selectedSectionType)) }}</div>
                        </div>
                        <div style="display:flex;gap:4px;">
                            <span style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;background:rgba(124,58,237,0.25);color:#c4b5fd;border-radius:5px;padding:2px 8px;border:1px solid rgba(124,58,237,0.4);">{{ strtoupper($selectedSectionType) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Inspector form --}}
                <div style="padding:16px;">
                    <form wire:submit.prevent="updateSelectedSection">

                        @if($selectedSectionType === 'hero')
                            {{-- Hero inspector --}}
                            <div class="form-group">
                                <label>Título Principal</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title" placeholder="Tu titulo aquí...">
                            </div>
                            <div class="form-group">
                                <label>Tipografía del Título</label>
                                <select class="form-control" wire:model="selectedSectionData.title_font">
                                    <option value="Outfit">Outfit — Moderna</option>
                                    <option value="Inter">Inter — Sans Serif</option>
                                    <option value="Montserrat">Montserrat — Geométrica</option>
                                    <option value="Playfair Display">Playfair Display — Serif</option>
                                    <option value="Caveat">Caveat — Manuscrita</option>
                                    <option value="Cinzel">Cinzel — Cinematográfica</option>
                                    <option value="Roboto">Roboto — Técnica</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tamaño del Título</label>
                                <select class="form-control" wire:model="selectedSectionData.title_size">
                                    <option value="text-3xl">Pequeño</option>
                                    <option value="text-4xl">Mediano</option>
                                    <option value="text-5xl">Grande</option>
                                    <option value="text-6xl">Muy Grande</option>
                                    <option value="text-7xl">Gigante</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subtítulo</label>
                                <textarea class="form-control" rows="2" wire:model="selectedSectionData.subtitle"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Texto del Botón</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.button_text">
                            </div>
                            <div class="form-group">
                                <label>Enlace del Botón</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.button_url" placeholder="/catalog">
                            </div>
                            <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>
                            <div style="font-size:10px;font-weight:700;letter-spacing:1px;color:#4b5563;text-transform:uppercase;margin-bottom:12px;">Fondo</div>
                            <div class="form-group">
                                <label>Gradiente de fondo</label>
                                <select class="form-control" wire:model="selectedSectionData.bg_gradient">
                                    <option value="from-violet-950 via-slate-900 to-indigo-950">Dark Purple (Recomendado)</option>
                                    <option value="from-slate-950 via-slate-900 to-slate-950">Pure Dark Slate</option>
                                    <option value="from-zinc-950 via-zinc-900 to-indigo-950">Navy Night</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Imagen de fondo</label>
                                <input type="file" class="form-control" style="padding:6px;font-size:12px;" wire:model="uploadedImage" accept="image/*">
                                <div wire:loading wire:target="uploadedImage" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo...</div>
                                @if(!empty($selectedSectionData['bg_image_url']))
                                    <div style="margin-top:8px;position:relative;display:inline-block;">
                                        <img src="{{ $selectedSectionData['bg_image_url'] }}" style="max-height:70px;border-radius:8px;border:1px solid rgba(255,255,255,0.1);" />
                                        <button type="button" wire:click="$set('selectedSectionData.bg_image_url', '')" style="position:absolute;top:-6px;right:-6px;width:18px;height:18px;border-radius:50%;background:#ef4444;border:none;color:white;font-size:9px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>

                        @elseif($selectedSectionType === 'cta')
                            <div class="form-group">
                                <label>Título de la Sección</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title">
                            </div>
                            <div class="form-group">
                                <label>Tipografía</label>
                                <select class="form-control" wire:model="selectedSectionData.title_font">
                                    <option value="Outfit">Outfit — Moderna</option>
                                    <option value="Inter">Inter</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Playfair Display">Playfair Display</option>
                                    <option value="Cinzel">Cinzel</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subtítulo</label>
                                <textarea class="form-control" rows="2" wire:model="selectedSectionData.subtitle"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Texto del Botón</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.button_text">
                            </div>
                            <div class="form-group">
                                <label>Enlace del Botón</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.button_url">
                            </div>
                            <div style="height:1px;background:rgba(255,255,255,0.06);margin:16px 0;"></div>
                            <div class="form-group">
                                <label>Imagen de fondo</label>
                                <input type="file" class="form-control" style="padding:6px;font-size:12px;" wire:model="uploadedImage" accept="image/*">
                                <div wire:loading wire:target="uploadedImage" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo...</div>
                            </div>

                        @elseif($selectedSectionType === 'courses')
                            <div class="form-group">
                                <label>Título de la Sección</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title">
                            </div>
                            <div class="form-group">
                                <label>Subtítulo</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.subtitle">
                            </div>
                            <div class="form-group">
                                <label>Cantidad de Cursos a Mostrar</label>
                                <input type="number" class="form-control" wire:model="selectedSectionData.limit" min="1" max="12">
                            </div>

                        @elseif($selectedSectionType === 'features')
                            <div class="form-group">
                                <label>Título de la Sección</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title">
                            </div>
                            <div style="height:1px;background:rgba(255,255,255,0.06);margin:12px 0;"></div>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                <span style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.8px;">Items</span>
                                <button type="button" class="btn btn-sm" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.4);color:#34d399;border-radius:8px;font-size:11px;padding:4px 10px;" wire:click="addFeatureItem">
                                    <i class="fas fa-plus mr-1"></i> Añadir
                                </button>
                            </div>
                            @if (isset($selectedSectionData['items']))
                                @foreach($selectedSectionData['items'] as $itemIndex => $item)
                                    <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:10px;padding:12px;margin-bottom:8px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                            <span style="font-size:10px;font-weight:700;color:#8b5cf6;text-transform:uppercase;">Item {{ $itemIndex + 1 }}</span>
                                            <button type="button" wire:click="removeFeatureItem({{ $itemIndex }})" style="background:transparent;border:none;color:#374151;cursor:pointer;font-size:11px;padding:2px 6px;border-radius:4px;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#374151'">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="form-group" style="margin-bottom:8px;">
                                            <label style="font-size:10px !important;text-transform:none !important;letter-spacing:0 !important;">Icono FontAwesome</label>
                                            <input type="text" class="form-control" style="font-size:12px !important;padding:6px 10px !important;" wire:model="selectedSectionData.items.{{ $itemIndex }}.icon" placeholder="fas fa-star">
                                        </div>
                                        <div class="form-group" style="margin-bottom:8px;">
                                            <label style="font-size:10px !important;text-transform:none !important;letter-spacing:0 !important;">Título</label>
                                            <input type="text" class="form-control" style="font-size:12px !important;padding:6px 10px !important;" wire:model="selectedSectionData.items.{{ $itemIndex }}.title">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label style="font-size:10px !important;text-transform:none !important;letter-spacing:0 !important;">Descripción</label>
                                            <input type="text" class="form-control" style="font-size:12px !important;padding:6px 10px !important;" wire:model="selectedSectionData.items.{{ $itemIndex }}.desc">
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        @elseif($selectedSectionType === 'faq')
                            <div class="form-group">
                                <label>Título de la Sección</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title">
                            </div>
                            <div style="height:1px;background:rgba(255,255,255,0.06);margin:12px 0;"></div>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                <span style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.8px;">Preguntas</span>
                                <button type="button" class="btn btn-sm" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.4);color:#34d399;border-radius:8px;font-size:11px;padding:4px 10px;" wire:click="addFaqItem">
                                    <i class="fas fa-plus mr-1"></i> Añadir
                                </button>
                            </div>
                            @if (isset($selectedSectionData['items']))
                                @foreach($selectedSectionData['items'] as $itemIndex => $item)
                                    <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:10px;padding:12px;margin-bottom:8px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                            <span style="font-size:10px;font-weight:700;color:#ec4899;text-transform:uppercase;">FAQ {{ $itemIndex + 1 }}</span>
                                            <button type="button" wire:click="removeFaqItem({{ $itemIndex }})" style="background:transparent;border:none;color:#374151;cursor:pointer;font-size:11px;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#374151'">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="form-group" style="margin-bottom:8px;">
                                            <label style="font-size:10px !important;text-transform:none !important;letter-spacing:0 !important;">Pregunta</label>
                                            <input type="text" class="form-control" style="font-size:12px !important;padding:6px 10px !important;" wire:model="selectedSectionData.items.{{ $itemIndex }}.question">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label style="font-size:10px !important;text-transform:none !important;letter-spacing:0 !important;">Respuesta</label>
                                            <textarea class="form-control" style="font-size:12px !important;padding:6px 10px !important;" rows="2" wire:model="selectedSectionData.items.{{ $itemIndex }}.answer"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        @elseif($selectedSectionType === 'rich_text')
                            <div class="form-group">
                                <label>Título del Bloque</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title" placeholder="Título (opcional)">
                            </div>
                            <div class="form-group">
                                <label>Tipografía del Título</label>
                                <select class="form-control" wire:model="selectedSectionData.title_font">
                                    <option value="Outfit">Outfit — Moderna</option>
                                    <option value="Inter">Inter</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Playfair Display">Playfair Display</option>
                                    <option value="Caveat">Caveat</option>
                                    <option value="Cinzel">Cinzel</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipografía del Contenido</label>
                                <select class="form-control" wire:model="selectedSectionData.font_family">
                                    <option value="Inter">Inter</option>
                                    <option value="Outfit">Outfit</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Playfair Display">Playfair Display</option>
                                    <option value="Caveat">Caveat</option>
                                    <option value="Roboto">Roboto</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alineación del Texto</label>
                                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:4px;">
                                    @foreach(['left' => 'fa-align-left', 'center' => 'fa-align-center', 'right' => 'fa-align-right', 'justify' => 'fa-align-justify'] as $val => $icon)
                                        <button type="button" wire:click="$set('selectedSectionData.alignment', '{{ $val }}')"
                                            style="background:{{ ($selectedSectionData['alignment'] ?? 'left') === $val ? 'rgba(124,58,237,0.3)' : 'rgba(255,255,255,0.04)' }};border:1px solid {{ ($selectedSectionData['alignment'] ?? 'left') === $val ? 'rgba(124,58,237,0.7)' : 'rgba(255,255,255,0.07)' }};border-radius:8px;padding:8px;color:{{ ($selectedSectionData['alignment'] ?? 'left') === $val ? '#c4b5fd' : '#64748b' }};cursor:pointer;font-size:12px;">
                                            <i class="fas {{ $icon }}"></i>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Contenido del Bloque</label>
                                <div class="modern-canva-editor" wire:ignore>
                                    <textarea id="rich_text_builder" wire:model="selectedSectionData.content" style="visibility:hidden;height:0;width:0;"></textarea>
                                </div>
                            </div>

                        @elseif($selectedSectionType === 'image_block')
                            <div class="form-group">
                                <label>Leyenda de la Imagen</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.title" placeholder="Leyenda (opcional)">
                            </div>
                            <div class="form-group">
                                <label>Subir imagen</label>
                                <input type="file" class="form-control" style="padding:6px;font-size:12px;" wire:model="uploadedImage" accept="image/*">
                                <div wire:loading wire:target="uploadedImage" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo...</div>
                            </div>
                            <div class="form-group">
                                <label>O URL externa</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.image_url" placeholder="https://ejemplo.com/foto.jpg">
                            </div>
                            @if(!empty($selectedSectionData['image_url']))
                                <div style="margin-bottom:12px;text-align:center;background:rgba(255,255,255,0.03);border-radius:10px;padding:10px;border:1px solid rgba(255,255,255,0.07);">
                                    <img src="{{ $selectedSectionData['image_url'] }}" style="max-height:100px;border-radius:8px;" />
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Alineación</label>
                                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:4px;">
                                    @foreach(['left' => 'Izq.', 'center' => 'Centro', 'right' => 'Der.'] as $val => $lbl)
                                        <button type="button" wire:click="$set('selectedSectionData.alignment', '{{ $val }}')"
                                            style="background:{{ ($selectedSectionData['alignment'] ?? 'center') === $val ? 'rgba(124,58,237,0.3)' : 'rgba(255,255,255,0.04)' }};border:1px solid {{ ($selectedSectionData['alignment'] ?? 'center') === $val ? 'rgba(124,58,237,0.7)' : 'rgba(255,255,255,0.07)' }};border-radius:8px;padding:8px;color:{{ ($selectedSectionData['alignment'] ?? 'center') === $val ? '#c4b5fd' : '#64748b' }};cursor:pointer;font-size:11px;font-weight:600;">
                                            {{ $lbl }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ancho (%)</label>
                                <input type="range" class="form-control" wire:model="selectedSectionData.width" min="20" max="100" step="5" style="padding:4px;">
                                <div style="font-size:11px;color:#8b5cf6;text-align:right;margin-top:3px;">{{ $selectedSectionData['width'] ?? 80 }}%</div>
                            </div>
                            <div class="form-group">
                                <label>Estilo Visual</label>
                                <select class="form-control" wire:model="selectedSectionData.style">
                                    <option value="standard">Estándar</option>
                                    <option value="rounded">Bordes Redondeados</option>
                                    <option value="shadow">Con Sombra Elegante</option>
                                    <option value="circle">Circular</option>
                                </select>
                            </div>

                        @elseif($selectedSectionType === 'video_block')
                            <div class="form-group">
                                <label>Video Local (.mp4, .webm)</label>
                                <input type="file" class="form-control" style="padding:6px;font-size:12px;" wire:model="uploadedVideo" accept="video/mp4,video/quicktime,video/webm">
                                <div wire:loading wire:target="uploadedVideo" style="font-size:11px;color:#8b5cf6;margin-top:4px;"><i class="fas fa-spinner fa-spin"></i> Subiendo video...</div>
                            </div>
                            <div class="form-group">
                                <label>O URL (YouTube / Google Drive Embed)</label>
                                <input type="text" class="form-control" wire:model="selectedSectionData.video_url" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                            @if(!empty($selectedSectionData['video_url']))
                                <div style="margin-bottom:12px;background:rgba(255,255,255,0.03);border-radius:10px;padding:10px;border:1px solid rgba(255,255,255,0.07);font-size:11px;color:#64748b;word-break:break-all;">
                                    <i class="fas fa-link mr-1" style="color:#8b5cf6;"></i>{{ Str::limit($selectedSectionData['video_url'], 50) }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Alineación</label>
                                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:4px;">
                                    @foreach(['left' => 'Izq.', 'center' => 'Centro', 'right' => 'Der.'] as $val => $lbl)
                                        <button type="button" wire:click="$set('selectedSectionData.alignment', '{{ $val }}')"
                                            style="background:{{ ($selectedSectionData['alignment'] ?? 'center') === $val ? 'rgba(124,58,237,0.3)' : 'rgba(255,255,255,0.04)' }};border:1px solid {{ ($selectedSectionData['alignment'] ?? 'center') === $val ? 'rgba(124,58,237,0.7)' : 'rgba(255,255,255,0.07)' }};border-radius:8px;padding:8px;color:{{ ($selectedSectionData['alignment'] ?? 'center') === $val ? '#c4b5fd' : '#64748b' }};cursor:pointer;font-size:11px;font-weight:600;">
                                            {{ $lbl }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ancho del Reproductor (%)</label>
                                <input type="range" class="form-control" wire:model="selectedSectionData.width" min="30" max="100" step="5" style="padding:4px;">
                                <div style="font-size:11px;color:#8b5cf6;text-align:right;margin-top:3px;">{{ $selectedSectionData['width'] ?? 80 }}%</div>
                            </div>
                        @endif

                        {{-- Apply button --}}
                        <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.06);">
                            <button type="submit" class="btn btn-primary btn-block" style="font-size:13px;padding:10px;">
                                <i class="fas fa-check mr-2"></i>Aplicar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            @else
                {{-- No section selected --}}
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;padding:30px;text-align:center;">
                    <div style="width:60px;height:60px;border-radius:16px;background:rgba(124,58,237,0.1);border:1px dashed rgba(124,58,237,0.3);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                        <i class="fas fa-sliders-h" style="font-size:22px;color:#4b5563;"></i>
                    </div>
                    <div style="font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">Inspector vacío</div>
                    <p style="font-size:12px;color:#334155;line-height:1.6;">Haz clic en cualquier bloque del canvas central para ver y editar sus propiedades aquí.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('livewire:navigated', function () { initTinyMCE(); });
document.addEventListener('DOMContentLoaded', function() { setTimeout(initTinyMCE, 800); });
document.addEventListener('livewire:update', function () { setTimeout(initTinyMCE, 600); });

function initTinyMCE() {
    const area = document.getElementById('rich_text_builder');
    if (!area || typeof tinymce === 'undefined') return;

    const existing = tinymce.get('rich_text_builder');
    if (existing) {
        existing.remove();
    }

    tinymce.init({
        selector: '#rich_text_builder',
        height: 300,
        menubar: false,
        branding: false,
        skin: false,
        content_css: false,
        content_style: `
            body {
                background: #0f172a;
                color: #e2e8f0;
                font-family: 'Inter', sans-serif;
                font-size: 14px;
                margin: 12px;
                line-height: 1.7;
            }
            h1, h2, h3, h4 { color: #f1f5f9; font-family: 'Outfit', sans-serif; }
            a { color: #8b5cf6; }
            p { color: #94a3b8; }
        `,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
            'preview', 'anchor', 'searchreplace', 'visualblocks', 'code',
            'fullscreen', 'insertdatetime', 'media', 'table', 'wordcount'
        ],
        toolbar: [
            'undo redo | styles fontfamily fontsize |',
            'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify |',
            'bullist numlist | link image media | forecolor backcolor | code fullscreen'
        ].join(' '),
        font_family_formats: 'Inter=Inter,sans-serif; Outfit=Outfit,sans-serif; Montserrat=Montserrat,sans-serif; Playfair Display=Playfair Display,serif; Caveat=Caveat,cursive; Cinzel=Cinzel,serif; Roboto=Roboto,sans-serif',
        setup: function (editor) {
            editor.on('change blur', function () {
                const textarea = document.getElementById('rich_text_builder');
                if (textarea) {
                    textarea.value = editor.getContent();
                    @this.set('selectedSectionData.content', editor.getContent());
                }
            });
        }
    });
}
</script>
@endsection
