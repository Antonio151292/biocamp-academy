<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center space-x-2 text-sm text-slate-400">
        <a href="/my-courses" class="hover:text-slate-200 transition-colors">Mis Cursos</a>
        <span>/</span>
        <a href="/courses/{{ $course->slug }}" class="hover:text-slate-200 transition-colors">{{ $course->title }}</a>
        <span>/</span>
        <span class="text-violet-400 font-semibold">{{ $lesson->title }}</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Side: Player, Controls, Tabs -->
        <div class="lg:w-2/3 flex flex-col space-y-6">
            
            <!-- Video Player -->
            <div class="relative w-full aspect-video rounded-3xl overflow-hidden bg-black border border-slate-800 shadow-2xl">
                @if($lesson->video_provider === 'drive' && $lesson->video_url)
                    <!-- Google Drive embedded video player -->
                    <iframe src="{{ $lesson->video_url }}" class="absolute inset-0 w-full h-full border-0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                @elseif($lesson->video_provider === 'local' && $lesson->getFirstMediaUrl('video'))
                    <!-- Local HTML5 video player -->
                    <video src="{{ $lesson->getFirstMediaUrl('video') }}" class="w-full h-full object-cover" controls></video>
                @else
                    <!-- Fallback / No video uploaded -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500">
                        <i class="fas fa-video-slash text-5xl mb-4 text-slate-600 animate-pulse-subtle"></i>
                        <p class="text-sm font-light">Esta clase no cuenta con un video disponible en este momento.</p>
                    </div>
                @endif
            </div>

            <!-- Video controls / progress tracker -->
            <div class="flex items-center justify-between glass-panel px-6 py-4 rounded-2xl border border-slate-800">
                <div>
                    <h2 class="text-lg font-bold font-heading text-white">{{ $lesson->title }}</h2>
                    <span class="text-xs text-slate-500">Sección: {{ $lesson->section->title }}</span>
                </div>
                <div>
                    <button wire:click="toggleCompleted" class="inline-flex items-center px-4 py-2 border rounded-xl text-xs font-bold transition-all duration-200 {{ $isCompleted ? 'bg-emerald-500/10 border-emerald-500/40 text-emerald-400 hover:bg-emerald-500/20' : 'bg-slate-900 border-slate-750 text-slate-300 hover:border-slate-600' }}">
                        @if($isCompleted)
                            <i class="fas fa-check-circle mr-1.5 text-sm"></i> ¡Clase Completada!
                        @else
                            <i class="far fa-circle mr-1.5 text-sm"></i> Marcar como Completada
                        @endif
                    </button>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="glass-panel border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="border-b border-slate-850 bg-slate-900/40 flex">
                    <button class="px-6 py-4 text-sm font-semibold border-b-2 focus:outline-none transition-all duration-200 {{ $activeTab === 'resources' ? 'border-violet-500 text-violet-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}" wire:click="$set('activeTab', 'resources')">
                        <i class="far fa-file-alt mr-1.5"></i> Recursos y Texto
                    </button>
                    <button class="px-6 py-4 text-sm font-semibold border-b-2 focus:outline-none transition-all duration-200 {{ $activeTab === 'chat' ? 'border-violet-500 text-violet-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}" wire:click="$set('activeTab', 'chat')">
                        <i class="far fa-comments mr-1.5"></i> Chat del Grupo
                    </button>
                    <button class="px-6 py-4 text-sm font-semibold border-b-2 focus:outline-none transition-all duration-200 {{ $activeTab === 'forum' ? 'border-violet-500 text-violet-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}" wire:click="$set('activeTab', 'forum')">
                        <i class="fas fa-question-circle mr-1.5"></i> Foro de Preguntas
                    </button>
                </div>

                <!-- Tabs Content -->
                <div class="p-6">
                    
                    <!-- TAB: RESOURCES -->
                    @if($activeTab === 'resources')
                        <div class="space-y-6">
                            @if($lesson->content)
                                <div class="prose prose-invert max-w-none text-slate-300 font-light text-sm leading-relaxed">
                                    {!! nl2br(e($lesson->content)) !!}
                                </div>
                            @else
                                <p class="text-slate-500 text-sm font-light italic">Esta lección no incluye notas de texto.</p>
                            @endif

                            <div class="border-t border-slate-850/60 pt-6">
                                <h4 class="text-sm font-semibold text-white mb-4"><i class="fas fa-download mr-1.5 text-violet-400"></i> Archivos Descargables</h4>
                                <ul class="space-y-2">
                                    @forelse($lesson->getMedia('downloads') as $media)
                                        <li class="flex items-center justify-between p-3 rounded-xl bg-slate-900/60 border border-slate-850 hover:border-slate-750 transition-colors">
                                            <span class="text-xs text-slate-300 font-medium">
                                                <i class="far fa-file mr-2 text-violet-400"></i> {{ $media->name }}
                                            </span>
                                            <a href="{{ $media->getUrl() }}" download class="inline-flex items-center px-3 py-1 bg-violet-600 hover:bg-violet-500 text-[10px] font-bold rounded-lg text-white transition-colors duration-200">
                                                Descargar ({{ number_format($media->size/1024/1024, 2) }} MB)
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-center py-4 text-slate-500 text-xs font-light">No hay recursos adjuntos para esta clase.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                    <!-- TAB: CHAT -->
                    @elseif($activeTab === 'chat')
                        <div class="flex flex-col h-[400px]">
                            <!-- Chat message stream -->
                            <div class="flex-grow overflow-y-auto space-y-4 pr-2 mb-4">
                                @forelse($chatMessages as $msg)
                                    <div class="flex items-start space-x-3">
                                        <img src="{{ $msg->user->profile_photo_url }}" alt="{{ $msg->user->name }}" class="w-8 h-8 rounded-full object-cover border border-violet-500/20" />
                                        <div class="flex-grow bg-slate-900/80 border border-slate-850 rounded-2xl px-4 py-2 text-sm">
                                            <div class="flex items-center justify-between mb-1" style="display: flex; justify-content: space-between">
                                                <span class="font-semibold text-violet-300 text-xs">{{ $msg->user->name }}</span>
                                                <span class="text-[10px] text-slate-500">{{ $msg->created_at->format('H:i') }}</span>
                                            </div>
                                            <p class="text-slate-300 text-xs leading-relaxed font-light">{{ $msg->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-20 text-slate-550 text-xs font-light">
                                        <i class="far fa-comments text-2xl mb-2 text-slate-600"></i>
                                        <p>Envía el primer mensaje al grupo para interactuar con tus compañeros.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Chat input Form -->
                            <form wire:submit.prevent="sendMessage" class="flex items-center space-x-2 mt-auto">
                                <input type="text" class="flex-grow bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-violet-500" placeholder="Escribe un mensaje en el grupo..." wire:model="chatMessage">
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-violet-600 hover:bg-violet-500 text-xs font-bold rounded-xl text-white active:scale-95 transition-all duration-200">
                                    Enviar
                                </button>
                            </form>
                        </div>

                    <!-- TAB: FORUM -->
                    @elseif($activeTab === 'forum')
                        <div>
                            @if(session()->has('forum_message'))
                                <div class="alert alert-success text-xs mb-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400">{{ session('forum_message') }}</div>
                            @endif

                            @if($selectedQuestionId && $activeQuestion)
                                <!-- QUESTION DETAIL VIEW -->
                                <div class="space-y-4">
                                    <button class="text-xs text-violet-400 hover:text-violet-300 font-semibold mb-2 flex items-center" wire:click="closeQuestion">
                                        <i class="fas fa-arrow-left mr-1.5"></i> Volver a preguntas
                                    </button>

                                    <!-- Author question bubble -->
                                    <div class="glass-panel border border-slate-800 rounded-2xl p-5">
                                        <div class="flex items-center space-x-3 mb-3">
                                            <img src="{{ $activeQuestion->user->profile_photo_url }}" alt="{{ $activeQuestion->user->name }}" class="w-8 h-8 rounded-full object-cover border border-violet-500/20" />
                                            <div>
                                                <span class="text-xs font-semibold text-violet-300">{{ $activeQuestion->user->name }}</span>
                                                <span class="text-[10px] text-slate-500 block">Publicado el {{ $activeQuestion->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <h3 class="text-base font-bold text-white mb-2">{{ $activeQuestion->title }}</h3>
                                        <p class="text-slate-300 text-xs font-light leading-relaxed">{{ $activeQuestion->content }}</p>
                                    </div>

                                    <!-- Answers lists -->
                                    <div class="space-y-3 pl-4 border-l-2 border-slate-850">
                                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Respuestas ({{ $activeQuestion->answers->count() }})</h4>
                                        @forelse($activeQuestion->answers as $ans)
                                            <div class="glass-panel border border-slate-800/80 rounded-2xl p-4">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <img src="{{ $ans->user->profile_photo_url }}" alt="{{ $ans->user->name }}" class="w-6 h-6 rounded-full object-cover" />
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-xs font-semibold text-violet-300">{{ $ans->user->name }}</span>
                                                        <span class="text-[9px] text-slate-500">{{ $ans->created_at->format('d/m H:i') }}</span>
                                                    </div>
                                                </div>
                                                <p class="text-slate-300 text-xs font-light leading-relaxed">{{ $ans->content }}</p>
                                            </div>
                                        @empty
                                            <p class="text-slate-550 text-xs font-light italic py-2">Nadie ha respondido a esta pregunta todavía.</p>
                                        @endforelse
                                    </div>

                                    <!-- Answer reply form -->
                                    <form wire:submit.prevent="createAnswer" class="mt-4">
                                        <div class="form-group mb-2">
                                            <textarea class="w-full bg-slate-950 border border-slate-850 rounded-xl p-3 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-violet-500" rows="3" placeholder="Escribe tu respuesta..." wire:model="newAnswerContent"></textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-violet-600 hover:bg-violet-500 text-xs font-bold rounded-xl text-white active:scale-95 transition-all duration-200">
                                                Responder Pregunta
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @elseif($showCreateQuestion)
                                <!-- CREATE QUESTION FORM -->
                                <form wire:submit.prevent="createQuestion" class="space-y-4">
                                    <div class="form-group">
                                        <label class="text-xs text-slate-400 mb-1 block">Título de la Pregunta</label>
                                        <input type="text" class="w-full bg-slate-950 border border-slate-850 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-violet-500" placeholder="¿Cuál es tu duda?" wire:model="forumTitle">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-xs text-slate-400 mb-1 block">Detalles o Contexto</label>
                                        <textarea class="w-full bg-slate-950 border border-slate-850 rounded-xl p-3 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-violet-500" rows="4" placeholder="Explica detalladamente..." wire:model="forumContent"></textarea>
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" class="btn text-xs text-slate-400 hover:text-slate-350 px-3 py-2" wire:click="$set('showCreateQuestion', false)">Cancelar</button>
                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-violet-600 hover:bg-violet-500 text-xs font-bold rounded-xl text-white active:scale-95 transition-all duration-200">
                                            Publicar Pregunta
                                        </button>
                                    </div>
                                </form>
                            @else
                                <!-- QUESTIONS LIST VIEW -->
                                <div class="space-y-4">
                                    <div class="text-right">
                                        <button class="btn btn-sm inline-flex items-center px-3 py-1.5 bg-violet-650/20 border border-violet-500/30 text-xs font-semibold rounded-lg text-violet-400 hover:bg-violet-650/35 hover:text-violet-300 transition-colors" wire:click="openCreateQuestionForm">
                                            + Nueva Pregunta
                                        </button>
                                    </div>

                                    <div class="divide-y divide-slate-850">
                                        @forelse($forumQuestions as $q)
                                            <div class="py-4 cursor-pointer hover:bg-slate-900/20 px-2 rounded-xl transition-colors" wire:click="selectQuestion({{ $q->id }})">
                                                <div class="flex items-center justify-between mb-1" style="display: flex; justify-content: space-between">
                                                    <h4 class="text-sm font-bold text-white hover:text-violet-400 transition-colors">{{ $q->title }}</h4>
                                                    <span class="badge badge-indigo text-[10px] bg-violet-950/40 border border-violet-500/20 text-violet-400 py-1 px-2.5 rounded-full"><i class="far fa-comment-dots mr-1"></i> {{ $q->answers_count }} respuestas</span>
                                                </div>
                                                <div class="flex items-center text-[10px] text-slate-500 space-x-2">
                                                    <span>Por {{ $q->user->name }}</span>
                                                    <span>•</span>
                                                    <span>{{ $q->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-20 text-slate-550 text-xs font-light">
                                                <i class="fas fa-question text-2xl mb-2 text-slate-650"></i>
                                                <p>No hay preguntas todavía. Crea una para iniciar una discusión.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                        </div>

                    @endif

                </div>
            </div>
        </div>

        <!-- Right Side: Syllabus Index navigation -->
        <div class="lg:w-1/3 flex flex-col">
            <div class="glass-card border border-slate-800 rounded-3xl sticky top-24 overflow-hidden shadow-2xl">
                <div class="bg-slate-900/40 border-b border-slate-850 px-6 py-4">
                    <h3 class="text-base font-bold font-heading text-white"><i class="fas fa-list-ol mr-2 text-violet-400"></i> Indice de Contenidos</h3>
                </div>
                
                <div class="divide-y divide-slate-850/60 overflow-y-auto max-h-[500px]">
                    @foreach($sections as $secIndex => $sec)
                        <div class="p-4" x-data="{ expanded: {{ $sec->id === $lesson->section_id ? 'true' : 'false' }} }">
                            <!-- Section Title header toggle -->
                            <button class="w-full flex items-center justify-between text-left font-bold text-xs text-slate-300 focus:outline-none mb-2" @click="expanded = !expanded">
                                <span class="pr-2 line-clamp-1">{{ $sec->title }}</span>
                                <i class="fas fa-chevron-down text-slate-500 text-[10px] transition-transform duration-300" :class="expanded ? 'transform rotate-180' : ''"></i>
                            </button>

                            <!-- Lessons lists -->
                            <ul class="space-y-1.5 mt-2 pl-1.5 border-l border-slate-800" x-show="expanded" x-collapse style="display: none;">
                                @foreach($sec->lessons as $les)
                                    @php
                                        $isCompletedLesson = in_array($les->id, $completedLessons);
                                        $isActiveLesson = $les->id === $lesson->id;
                                        $lesUrl = '/courses/' . $course->slug . '/lessons/' . $les->slug;
                                    @endphp
                                    <li class="rounded-xl transition-all duration-200">
                                        <a href="{{ $lesUrl }}" class="flex items-center justify-between p-2.5 text-xs rounded-xl {{ $isActiveLesson ? 'bg-violet-950/30 border border-violet-500/35 text-violet-300 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/30' }}">
                                            <span class="flex items-center mr-2 truncate">
                                                <span class="mr-2">
                                                    @if($isCompletedLesson)
                                                        <i class="fas fa-check-circle text-emerald-400"></i>
                                                    @else
                                                        <i class="far fa-circle text-slate-600"></i>
                                                    @endif
                                                </span>
                                                <span class="truncate">{{ $les->title }}</span>
                                            </span>
                                            @if($les->is_free && !$isActiveLesson)
                                                <span class="badge badge-success text-[8px] bg-emerald-950/50 border border-emerald-500/20 text-emerald-400 py-0.5 px-1.5 rounded-full">Gratis</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
