<x-student-layout>
    <!-- Dynamic Google Fonts Load for Page Builder -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=Cinzel:wght@700&family=Montserrat:wght@400;700&family=Playfair+Display:ital,wght@0,700;1,700&family=Roboto:wght@400;700&display=swap');
    </style>

    <div class="space-y-20 pb-20">
        @forelse($sections as $index => $sec)
            
            <!-- HERO SECTION -->
            @if($sec['type'] === 'hero')
                <section class="relative overflow-hidden py-24 sm:py-32 border-b border-slate-900 {{ !empty($sec['bg_image_url']) ? 'bg-cover bg-center' : 'bg-gradient-to-br ' . ($sec['bg_gradient'] ?? 'from-violet-950 via-slate-900 to-indigo-950') }}"
                    @if(!empty($sec['bg_image_url'])) style="background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.9)), url('{{ $sec['bg_image_url'] }}');" @endif>
                    
                    <!-- Ambient Glow Effects (only show if no custom bg image) -->
                    @if(empty($sec['bg_image_url']))
                        <div class="absolute top-0 left-1/4 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl animate-pulse-subtle"></div>
                        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl animate-pulse-subtle" style="animation-delay: 1.5s;"></div>
                    @endif

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        <div class="text-center max-w-3xl mx-auto animate-fade-in-up">
                            <h1 class="font-extrabold tracking-tight text-white mb-6 {{ $sec['title_size'] ?? 'text-4xl sm:text-6xl' }}"
                                style="font-family: '{{ $sec['title_font'] ?? 'Outfit' }}', sans-serif; color: {{ $sec['title_color'] ?? '#ffffff' }};">
                                {{ $sec['title'] ?? 'Aprende sin límites' }}
                            </h1>
                            <p class="text-lg sm:text-xl text-slate-200 mb-8 leading-relaxed font-light">
                                {{ $sec['subtitle'] ?? 'Cursos de alta calidad con soporte de tutores y comunidad en vivo.' }}
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="{{ $sec['button_url'] ?? '/catalog' }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                                    {{ $sec['button_text'] ?? 'Explorar Cursos' }} <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

            <!-- FEATURES SECTION -->
            @elseif($sec['type'] === 'features')
                <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl sm:text-4xl font-bold font-heading text-white mb-4">
                            {{ $sec['title'] ?? 'Nuestros Beneficios' }}
                        </h2>
                        <div class="w-16 h-1 bg-violet-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if(isset($sec['items']))
                            @foreach($sec['items'] as $itemIndex => $item)
                                <div class="glass-card p-6 rounded-2xl animate-fade-in-up" style="animation-delay: {{ $itemIndex * 0.1 }}s">
                                    <div class="w-12 h-12 rounded-xl bg-violet-950/45 border border-violet-500/20 flex items-center justify-center text-violet-400 text-xl mb-6 shadow-inner">
                                        <i class="{{ $item['icon'] ?? 'fas fa-star' }}"></i>
                                    </div>
                                    <h3 class="text-xl font-bold font-heading text-white mb-3">
                                        {{ $item['title'] ?? 'Título del beneficio' }}
                                    </h3>
                                    <p class="text-slate-400 text-sm leading-relaxed">
                                        {{ $item['desc'] ?? 'Descripción corta explicando este beneficio o característica de la plataforma.' }}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>

            <!-- COURSES SECTION -->
            @elseif($sec['type'] === 'courses')
                <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl sm:text-4xl font-bold font-heading text-white mb-3">
                            {{ $sec['title'] ?? 'Cursos Destacados' }}
                        </h2>
                        <p class="text-slate-400 font-light max-w-2xl mx-auto">
                            {{ $sec['subtitle'] ?? 'Comienza a aprender hoy con nuestros programas académicos premium.' }}
                        </p>
                        <div class="w-16 h-1 bg-violet-500 mx-auto rounded-full mt-4"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($publishedCourses->take($sec['limit'] ?? 6) as $courseIndex => $course)
                            <div class="glass-card rounded-2xl overflow-hidden flex flex-col h-full animate-fade-in-up" style="animation-delay: {{ $courseIndex * 0.1 }}s">
                                <!-- Cover image -->
                                <div class="relative aspect-video w-full bg-slate-950 overflow-hidden">
                                    @if($course->getFirstMediaUrl('cover'))
                                        <img src="{{ $course->getFirstMediaUrl('cover') }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                                    @else
                                        <!-- Placeholder gradient -->
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-900 to-slate-900 flex items-center justify-center">
                                            <i class="fas fa-graduation-cap text-indigo-400 text-4xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3 px-3 py-1 bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-full">
                                        <span class="text-sm font-semibold text-violet-400">
                                            {{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'Acceso Completo' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card details -->
                                <div class="p-6 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold font-heading text-white mb-2 line-clamp-1 hover:text-violet-400 transition-colors">
                                            <a href="/courses/{{ $course->slug }}">{{ $course->title }}</a>
                                        </h3>
                                        <p class="text-slate-400 text-xs line-clamp-3 mb-6 font-light">
                                            {{ $course->description ?? 'Sin descripción disponible para este curso.' }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between border-t border-slate-800/60 pt-4 mt-auto">
                                        <span class="text-xs text-slate-500"><i class="fas fa-book-open mr-1"></i> {{ $course->sections->count() }} Secciones</span>
                                        <a href="/courses/{{ $course->slug }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold rounded-lg text-white bg-violet-600 hover:bg-violet-500 active:scale-95 transition-all duration-200">
                                            Ver Detalles <i class="fas fa-chevron-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 text-slate-500 font-light">
                                <i class="fas fa-info-circle text-2xl mb-2"></i>
                                <p>No hay cursos disponibles en este momento.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

            <!-- CALL TO ACTION (CTA) -->
            @elseif($sec['type'] === 'cta')
                <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="relative rounded-3xl overflow-hidden p-8 sm:p-16 text-center shadow-2xl {{ !empty($sec['bg_image_url']) ? 'bg-cover bg-center' : 'glass-panel border border-slate-800' }}"
                        @if(!empty($sec['bg_image_url'])) style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ $sec['bg_image_url'] }}');" @endif>
                        
                        <!-- Background overlay gradients (only if no custom image background) -->
                        @if(empty($sec['bg_image_url']))
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-650/10 to-indigo-650/10 pointer-events-none"></div>
                        @endif
                        
                        <div class="relative z-10 max-w-2xl mx-auto animate-fade-in-up">
                            <h2 class="text-3xl sm:text-5xl font-extrabold text-white mb-6" style="font-family: '{{ $sec['title_font'] ?? 'Outfit' }}', sans-serif;">
                                {{ $sec['title'] ?? 'Comienza hoy mismo' }}
                            </h2>
                            <p class="text-base sm:text-lg text-slate-200 mb-8 leading-relaxed font-light">
                                {{ $sec['subtitle'] ?? 'Únete a miles de profesionales que ya están mejorando sus habilidades biológicas en nuestra plataforma.' }}
                            </p>
                            <a href="{{ $sec['button_url'] ?? '/register' }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                                {{ $sec['button_text'] ?? 'Comenzar Ahora' }} <i class="fas fa-rocket ml-2"></i>
                            </a>
                        </div>
                    </div>
                </section>

            <!-- FAQ SECTION -->
            @elseif($sec['type'] === 'faq')
                <section class="max-w-3xl mx-auto px-4 py-12">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl sm:text-4xl font-bold font-heading text-white mb-4">
                            {{ $sec['title'] ?? 'Preguntas Frecuentes' }}
                        </h2>
                        <div class="w-16 h-1 bg-violet-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="space-y-4">
                        @if(isset($sec['items']))
                            @foreach($sec['items'] as $faqIndex => $item)
                                <div class="glass-panel border border-slate-800/80 rounded-2xl overflow-hidden" x-data="{ open: false }">
                                    <button class="w-full flex justify-between items-center px-6 py-4 text-left font-semibold text-white focus:outline-none hover:bg-slate-800/20 transition-colors" @click="open = !open">
                                        <span>{{ $item['question'] ?? 'Pregunta de prueba' }}</span>
                                        <i class="fas fa-chevron-down text-violet-400 text-sm transition-transform duration-300" :class="open ? 'transform rotate-180' : ''"></i>
                                    </button>
                                    <div class="px-6 pb-4 pt-1 text-slate-400 text-sm leading-relaxed border-t border-slate-900/50" x-show="open" x-collapse style="display: none;">
                                        {{ $item['answer'] ?? 'Respuesta a la pregunta correspondiente.' }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>

            <!-- RICH TEXT SECTION -->
            @elseif($sec['type'] === 'rich_text')
                <section class="max-w-4xl mx-auto px-4 py-12 animate-fade-in-up" style="font-family: '{{ $sec['font_family'] ?? 'Inter' }}', sans-serif;">
                    @if(!empty($sec['title']))
                        <div class="text-center mb-6">
                            <h2 class="text-3xl sm:text-4xl font-bold" style="font-family: '{{ $sec['title_font'] ?? 'Outfit' }}', sans-serif; color: {{ $sec['title_color'] ?? '#ffffff' }};">
                                {{ $sec['title'] }}
                            </h2>
                        </div>
                    @endif
                    <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed text-base" style="color: {{ $sec['text_color'] ?? '#cbd5e1' }}; text-align: {{ $sec['alignment'] ?? 'center' }};">
                        {!! $sec['content'] ?? '' !!}
                    </div>
                </section>

            <!-- IMAGE BLOCK SECTION -->
            @elseif($sec['type'] === 'image_block')
                <section class="max-w-7xl mx-auto px-4 py-6 flex justify-{{ $sec['alignment'] === 'left' ? 'start' : ($sec['alignment'] === 'right' ? 'end' : 'center') }} animate-fade-in-up">
                    <div style="width: {{ $sec['width'] ?? '80' }}%; max-width: 100%;">
                        @if(!empty($sec['image_url']))
                            <img src="{{ $sec['image_url'] }}" alt="{{ $sec['title'] ?? '' }}" class="mx-auto max-h-[550px] object-cover {{ $sec['style'] === 'rounded' ? 'rounded-2xl' : ($sec['style'] === 'circle' ? 'rounded-full' : ($sec['style'] === 'shadow' ? 'shadow-2xl rounded-2xl border border-slate-800' : '')) }}" />
                        @else
                            <div class="w-full aspect-[21/9] bg-slate-950 border border-dashed border-slate-800 rounded-2xl flex items-center justify-center text-slate-500">
                                <i class="far fa-image text-3xl mr-2"></i> Sin imagen seleccionada
                            </div>
                        @endif
                        @if(!empty($sec['title']))
                            <p class="text-center text-xs text-slate-500 mt-2 font-light">{{ $sec['title'] }}</p>
                        @endif
                    </div>
                </section>

            <!-- VIDEO BLOCK SECTION -->
            @elseif($sec['type'] === 'video_block')
                <section class="max-w-7xl mx-auto px-4 py-6 flex justify-{{ $sec['alignment'] === 'left' ? 'start' : ($sec['alignment'] === 'right' ? 'end' : 'center') }} animate-fade-in-up">
                    <div class="aspect-video" style="width: {{ $sec['width'] ?? '80' }}%; max-width: 100%;">
                        @if(!empty($sec['video_url']))
                            @php
                                $embedUrl = $sec['video_url'];
                                if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                                    $parts = parse_url($embedUrl);
                                    parse_str($parts['query'], $query);
                                    if (isset($query['v'])) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $query['v'];
                                    }
                                } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                    $videoId = substr(parse_url($embedUrl, PHP_URL_PATH), 1);
                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                }
                            @endphp
                            @if(str_contains($embedUrl, 'embed') || str_contains($embedUrl, 'preview') || str_contains($embedUrl, 'player.vimeo.com'))
                                <iframe class="w-full h-full rounded-2xl border border-slate-800 shadow-2xl" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            @else
                                <!-- Local MP4 video or raw media url -->
                                <video class="w-full h-full rounded-2xl border border-slate-800 shadow-2xl" controls>
                                    <source src="{{ $embedUrl }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de video.
                                </video>
                            @endif
                        @else
                            <div class="w-full aspect-video bg-slate-950 border border-dashed border-slate-800 rounded-2xl flex items-center justify-center text-slate-500">
                                <i class="fas fa-video text-3xl mr-2"></i> Sin video configurado
                            </div>
                        @endif
                    </div>
                </section>

            @endif

        @empty
            <!-- Fallback Welcome banner if no builder page config is present in db -->
            <section class="relative overflow-hidden bg-gradient-to-br from-violet-950 via-slate-900 to-indigo-950 py-32 border-b border-slate-900">
                <div class="max-w-7xl mx-auto px-4 text-center animate-fade-in-up">
                    <h1 class="text-5xl font-extrabold tracking-tight text-white mb-6 font-heading">
                        Biocamp Academy
                    </h1>
                    <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto font-light">
                        Bienvenido a la plataforma. Inicia sesión en tu cuenta para acceder a tus cursos y planes de suscripción.
                    </p>
                    <a href="/login" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                        Acceder a la plataforma
                    </a>
                </div>
            </section>
        @endforelse
    </div>
</x-student-layout>
