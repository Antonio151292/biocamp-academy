<div class="max-w-6xl mx-auto px-4 py-12 animate-fade-in-up">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold font-heading text-white mb-4">Planes de Suscripción</h1>
        <p class="text-slate-400 font-light max-w-xl mx-auto">
            Accede a todo nuestro catálogo de cursos con una sola suscripción mensual o anual. Cancela cuando quieras.
        </p>
        <div class="w-16 h-1 bg-violet-500 mx-auto rounded-full mt-4"></div>
    </div>

    <!-- Active subscription status notice -->
    @if($activeSubscription)
        <div class="max-w-3xl mx-auto mb-12 glass-panel border border-emerald-500/30 p-6 rounded-2xl text-center">
            <h4 class="text-lg font-bold font-heading text-emerald-400 mb-2">
                <i class="fas fa-check-circle mr-2"></i> Tienes una Suscripción Activa
            </h4>
            <p class="text-sm text-slate-300 font-light mb-0">
                Plan activo: <strong class="text-white">Suscripción {{ ucfirst($activeSubscription->plan_type) }}</strong>.
                Expira/Renueva el: <strong class="text-white">{{ $activeSubscription->ends_at->format('d/m/Y') }}</strong>.
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto items-stretch">
        
        <!-- Monthly Plan Card -->
        <div class="glass-card rounded-3xl p-8 flex flex-col justify-between border border-slate-800 hover:border-slate-700 transition-all duration-300">
            <div>
                <div class="mb-6">
                    <h3 class="text-xl font-bold font-heading text-white">Suscripción Mensual</h3>
                    <p class="text-slate-400 text-xs mt-1 font-light">Acceso recurrente mes a mes.</p>
                </div>
                <div class="mb-8 flex items-baseline">
                    <span class="text-5xl font-extrabold font-heading text-white">$19</span>
                    <span class="text-slate-500 text-sm ml-2 font-light">/ mes</span>
                </div>
                
                <ul class="space-y-4 mb-8 text-sm font-light text-slate-300">
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Acceso a todos los cursos</li>
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Carga de lecciones en video locales/Drive</li>
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Archivos adjuntos descargables</li>
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Chat de comunidad y foro Q&A</li>
                </ul>
            </div>

            <div>
                @if($activeSubscription)
                    <button class="w-full py-3 px-4 rounded-xl text-sm font-bold bg-slate-900 border border-slate-800 text-slate-500 cursor-not-allowed" disabled>Ya estás suscrito</button>
                @else
                    <a href="/checkout/subscription/mensual" class="block w-full text-center py-3.5 px-4 rounded-xl text-sm font-bold text-slate-200 bg-slate-900 border border-slate-700 hover:border-slate-500 active:scale-95 transition-all duration-200">
                        Contratar Mensual
                    </a>
                @endif
            </div>
        </div>

        <!-- Annual Plan Card (Suggested) -->
        <div class="relative glass-card rounded-3xl p-8 flex flex-col justify-between border-2 border-violet-500 shadow-2xl shadow-violet-600/10 hover:shadow-violet-600/20 transition-all duration-300">
            <div class="absolute -top-3.5 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-violet-600 rounded-full text-white text-[10px] font-bold uppercase tracking-widest">
                Recomendado
            </div>

            <div>
                <div class="mb-6">
                    <h3 class="text-xl font-bold font-heading text-white">Suscripción Anual</h3>
                    <p class="text-slate-400 text-xs mt-1 font-light">Acceso anual con ahorro masivo.</p>
                </div>
                <div class="mb-8 flex items-baseline">
                    <span class="text-5xl font-extrabold font-heading text-white">$149</span>
                    <span class="text-slate-500 text-sm ml-2 font-light">/ año</span>
                </div>
                
                <ul class="space-y-4 mb-8 text-sm font-light text-slate-300">
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Acceso a todos los cursos</li>
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Carga de lecciones en video locales/Drive</li>
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Archivos adjuntos descargables</li>
                    <li class="flex items-center"><i class="fas fa-check text-violet-400 mr-3"></i> Chat de comunidad y foro Q&A</li>
                    <li class="flex items-center"><i class="fas fa-gift text-emerald-400 mr-3"></i> <strong class="text-emerald-400 font-semibold">Ahorra más del 35%</strong> respecto a mensual</li>
                </ul>
            </div>

            <div>
                @if($activeSubscription)
                    <button class="w-full py-3 px-4 rounded-xl text-sm font-bold bg-slate-900 border border-slate-800 text-slate-500 cursor-not-allowed" disabled>Ya estás suscrito</button>
                @else
                    <a href="/checkout/subscription/anual" class="block w-full text-center py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-violet-650 hover:bg-violet-600 shadow-lg shadow-violet-650/20 active:scale-95 transition-all duration-200">
                        Contratar Anual (Ahorro)
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>
