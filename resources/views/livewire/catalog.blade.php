<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="text-center mb-12 animate-fade-in-up">
        <h1 class="text-4xl font-extrabold font-heading text-white mb-4">Catálogo de Cursos</h1>
        <p class="text-slate-400 font-light max-w-xl mx-auto">
            Explora nuestro catálogo de clases interactivas de biología, biotecnología y ciencias afines.
        </p>
        <div class="w-16 h-1 bg-violet-500 mx-auto rounded-full mt-4"></div>
    </div>

    <!-- Search & Filters -->
    <div class="mb-10 max-w-xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="relative gradient-border-glow rounded-xl overflow-hidden shadow-2xl">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" class="block w-full pl-10 pr-4 py-3 bg-slate-900/80 border border-slate-800 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-violet-500 focus:border-violet-500 rounded-xl" placeholder="Buscar curso por nombre..." wire:model.live="search">
        </div>
    </div>

    <!-- Subscription Notification Banner -->
    @if($hasActiveSubscription)
        <div class="mb-10 glass-panel border border-violet-500/30 rounded-2xl p-6 text-center animate-fade-in-up" style="animation-delay: 0.15s">
            <h4 class="text-lg font-bold font-heading text-violet-400 mb-2"><i class="fas fa-check-double mr-2 animate-bounce"></i> ¡Suscripción Activa!</h4>
            <p class="text-sm text-slate-300 font-light mb-0">Tienes acceso a todo el contenido de la plataforma. Todos los cursos han sido desbloqueados para ti.</p>
        </div>
    @endif

    <!-- Catalog Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($courses as $index => $course)
            <div class="glass-card rounded-2xl overflow-hidden flex flex-col h-full animate-fade-in-up" style="animation-delay: {{ $index * 0.05 }}s">
                <!-- Cover Image -->
                <div class="relative aspect-video w-full bg-slate-950 overflow-hidden">
                    @if($course->getFirstMediaUrl('cover'))
                        <img src="{{ $course->getFirstMediaUrl('cover') }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                    @else
                        <!-- Placeholder -->
                        <div class="w-full h-full bg-gradient-to-br from-violet-950 to-slate-950 flex items-center justify-center">
                            <i class="fas fa-dna text-violet-500 text-4xl animate-pulse-subtle"></i>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 px-3 py-1 bg-slate-900/85 border border-slate-800 rounded-full">
                        <span class="text-sm font-semibold text-violet-400">
                            {{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'Gratuito' }}
                        </span>
                    </div>
                </div>

                <!-- Course content details -->
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold font-heading text-white mb-2 line-clamp-1 hover:text-violet-400 transition-colors">
                            <a href="/courses/{{ $course->slug }}">{{ $course->title }}</a>
                        </h3>
                        <p class="text-slate-400 text-xs line-clamp-3 mb-6 font-light">
                            {{ $course->description ?? 'Este curso no tiene una descripción disponible todavía.' }}
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
            <div class="col-span-full text-center py-20 text-slate-500 border border-dashed border-slate-800 rounded-2xl">
                <i class="fas fa-search fa-3x mb-3"></i>
                <p class="text-lg font-light">No encontramos ningún curso que coincida con tu búsqueda.</p>
            </div>
        @endforelse
    </div>
</div>
