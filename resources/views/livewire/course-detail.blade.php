<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="row lg:flex lg:space-x-12">
        <!-- Course info & Syllabus -->
        <div class="lg:w-2/3 animate-fade-in-up">
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-white mb-6">{{ $course->title }}</h1>
            
            <div class="prose prose-invert max-w-none mb-10 text-slate-300 font-light leading-relaxed">
                <p>{{ $course->description }}</p>
            </div>

            <!-- Curriculum Syllabus -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold font-heading text-white mb-6">Plan de Estudios</h2>
                
                <div class="space-y-4">
                    @forelse($sections as $secIndex => $section)
                        <div class="glass-panel border border-slate-800 rounded-2xl overflow-hidden" x-data="{ open: true }">
                            <!-- Section Header -->
                            <button class="w-full flex justify-between items-center px-6 py-4 bg-slate-900/40 text-left font-semibold text-white focus:outline-none hover:bg-slate-800/20 transition-colors" @click="open = !open">
                                <span>{{ $section->title }}</span>
                                <i class="fas fa-chevron-down text-violet-400 text-sm transition-transform duration-300" :class="open ? 'transform rotate-180' : ''"></i>
                            </button>

                            <!-- Lessons List -->
                            <div class="border-t border-slate-900/50" x-show="open" x-collapse style="display: none;">
                                <ul class="divide-y divide-slate-800/40">
                                    @forelse($section->lessons as $lesson)
                                        <li class="px-6 py-4 flex justify-between items-center text-sm">
                                            <span class="flex items-center text-slate-300">
                                                <i class="far fa-play-circle mr-3 text-violet-400 text-base"></i>
                                                {{ $lesson->title }}
                                            </span>
                                            
                                            <div class="flex items-center">
                                                @if($hasAccess || $lesson->is_free)
                                                    @php
                                                        // Fallback slug path
                                                        $lessonLink = '/courses/' . $course->slug . '/lessons/' . $lesson->slug;
                                                    @endphp
                                                    <a href="{{ $lessonLink }}" class="inline-flex items-center text-violet-400 hover:text-violet-300 transition-colors font-semibold">
                                                        Ver clase <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                                    </a>
                                                @else
                                                    <span class="text-slate-500 text-xs bg-slate-950/40 border border-slate-850 px-2.5 py-1 rounded-full"><i class="fas fa-lock mr-1.5 text-slate-500"></i> Bloqueado</span>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <li class="px-6 py-4 text-center text-slate-500 text-xs">No hay clases en esta sección.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-500 text-sm border border-dashed border-slate-800 rounded-2xl">
                            Plan de estudios en preparación.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar pricing panel -->
        <div class="lg:w-1/3 mt-8 lg:mt-0 animate-fade-in-up" style="animation-delay: 0.15s">
            <div class="glass-card rounded-3xl overflow-hidden sticky top-24 border border-slate-800 shadow-2xl">
                <!-- Image Cover -->
                <div class="relative aspect-video w-full bg-slate-950 overflow-hidden border-b border-slate-800">
                    @if($course->getFirstMediaUrl('cover'))
                        <img src="{{ $course->getFirstMediaUrl('cover') }}" alt="{{ $course->title }}" class="w-full h-full object-cover" />
                    @else
                        <!-- Fallback Placeholder -->
                        <div class="w-full h-full bg-gradient-to-br from-violet-900 to-slate-900 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-violet-400 text-5xl"></i>
                        </div>
                    @endif
                </div>

                <div class="p-8">
                    @if($hasAccess)
                        <!-- Student has unlocked -->
                        <div class="text-center">
                            <span class="inline-flex items-center px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-xs font-semibold rounded-full text-emerald-400 mb-6">
                                <i class="fas fa-check-circle mr-1.5"></i> Curso Desbloqueado
                            </span>
                            @php
                                $firstLesson = $sections->first() ? $sections->first()->lessons->first() : null;
                                $firstLessonUrl = $firstLesson ? '/courses/' . $course->slug . '/lessons/' . $firstLesson->slug : '#';
                            @endphp
                            <a href="{{ $firstLessonUrl }}" class="inline-flex items-center justify-center w-full px-6 py-4 text-base font-bold rounded-xl text-white bg-gradient-to-r from-violet-600 to-indigo-650 hover:from-violet-500 hover:to-indigo-550 shadow-xl shadow-violet-600/20 active:scale-95 transition-all duration-300 animate-pulse-subtle">
                                <i class="fas fa-play mr-2 text-sm"></i> Ir a Clases
                            </a>
                        </div>
                    @else
                        <!-- Purchase details -->
                        <div class="mb-6">
                            <span class="text-xs text-slate-400 uppercase tracking-wider block mb-1">Precio del Curso</span>
                            <span class="text-4xl font-extrabold text-white font-heading">${{ number_format($course->price, 2) }}</span>
                        </div>

                        <div class="space-y-4">
                            @auth
                                <a href="/checkout/course/{{ $course->slug }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 border border-transparent text-sm font-bold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                                    <i class="fas fa-shopping-cart mr-2"></i> Adquirir Curso Permanente
                                </a>
                                <div class="text-center text-xs text-slate-500">ó obtén todos los cursos suscribiéndote</div>
                                <a href="/subscription" class="inline-flex items-center justify-center w-full px-6 py-3.5 border border-slate-700 hover:border-slate-500 text-sm font-bold rounded-xl text-slate-200 bg-slate-900/40 hover:bg-slate-800/40 active:scale-95 transition-all duration-200">
                                    <i class="fas fa-layer-group mr-2 text-violet-400"></i> Suscribirse Mensual / Anual
                                </a>
                            @else
                                <a href="/login?redirect=/courses/{{ $course->slug }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 border border-transparent text-sm font-bold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                                    Inicia Sesión para Comprar
                                </a>
                            @endauth
                        </div>
                    @endif

                    <div class="border-t border-slate-850/60 my-6 pt-6 text-slate-400 text-xs space-y-3 font-light">
                        <div class="flex items-center"><i class="far fa-clock text-violet-400 mr-2.5 w-4 text-center"></i> Acceso permanente ilimitado</div>
                        <div class="flex items-center"><i class="fas fa-file-download text-violet-400 mr-2.5 w-4 text-center"></i> Archivos descargables adjuntos</div>
                        <div class="flex items-center"><i class="far fa-comments text-violet-400 mr-2.5 w-4 text-center"></i> Comunidad y grupo de estudio</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
