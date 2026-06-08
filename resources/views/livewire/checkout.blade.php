<div class="max-w-6xl mx-auto px-4 py-12 animate-fade-in-up">
    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-white mb-2">Finalizar Compra</h1>
        <p class="text-slate-400 font-light text-sm">Selecciona tu método de pago preferido para activar tu acceso.</p>
        <div class="w-12 h-1 bg-violet-500 mx-auto rounded-full mt-4"></div>
    </div>

    @if (session()->has('gateway_error'))
        <div class="max-w-4xl mx-auto mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs flex items-center">
            <i class="fas fa-exclamation-triangle mr-2.5 text-base"></i>
            <div>
                <strong>Aviso:</strong> {{ session('gateway_error') }}
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 max-w-4xl mx-auto">
        <!-- Left panel: Payment options -->
        <div class="lg:w-2/3 flex flex-col space-y-6">
            <div class="glass-panel p-6 rounded-3xl border border-slate-800">
                <h3 class="text-lg font-bold font-heading text-white mb-6"><i class="fas fa-wallet mr-2 text-violet-400"></i> Método de Pago</h3>
                
                <div class="space-y-3">
                    <!-- MercadoPago Option -->
                    <label class="flex items-center justify-between p-4 rounded-2xl border cursor-pointer transition-all duration-200 {{ $paymentMethod === 'mercadopago' ? 'bg-violet-950/20 border-violet-500 text-white' : 'bg-slate-900/40 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                        <div class="flex items-center">
                            <input type="radio" name="payment_method" value="mercadopago" class="sr-only" wire:model.live="paymentMethod">
                            <div class="w-5 h-5 rounded-full border border-slate-700 mr-3 flex items-center justify-center {{ $paymentMethod === 'mercadopago' ? 'border-violet-500' : '' }}">
                                @if($paymentMethod === 'mercadopago')
                                    <div class="w-2.5 h-2.5 rounded-full bg-violet-500"></div>
                                @endif
                            </div>
                            <span class="text-sm font-semibold"><i class="fab fa-cc-visa mr-2 text-base text-sky-400"></i> MercadoPago (Tarjetas / Efectivo)</span>
                        </div>
                        <span class="text-xs text-slate-500">Latinoamérica</span>
                    </label>

                    <!-- PayPal Option -->
                    <label class="flex items-center justify-between p-4 rounded-2xl border cursor-pointer transition-all duration-200 {{ $paymentMethod === 'paypal' ? 'bg-violet-950/20 border-violet-500 text-white' : 'bg-slate-900/40 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                        <div class="flex items-center">
                            <input type="radio" name="payment_method" value="paypal" class="sr-only" wire:model.live="paymentMethod">
                            <div class="w-5 h-5 rounded-full border border-slate-700 mr-3 flex items-center justify-center {{ $paymentMethod === 'paypal' ? 'border-violet-500' : '' }}">
                                @if($paymentMethod === 'paypal')
                                    <div class="w-2.5 h-2.5 rounded-full bg-violet-500"></div>
                                @endif
                            </div>
                            <span class="text-sm font-semibold"><i class="fab fa-paypal mr-2 text-base text-blue-400"></i> PayPal (Internacional)</span>
                        </div>
                        <span class="text-xs text-slate-500">Internacional</span>
                    </label>

                    <!-- Bank Transfer Option -->
                    <label class="flex items-center justify-between p-4 rounded-2xl border cursor-pointer transition-all duration-200 {{ $paymentMethod === 'transferencia' ? 'bg-violet-950/20 border-violet-500 text-white' : 'bg-slate-900/40 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                        <div class="flex items-center">
                            <input type="radio" name="payment_method" value="transferencia" class="sr-only" wire:model.live="paymentMethod">
                            <div class="w-5 h-5 rounded-full border border-slate-700 mr-3 flex items-center justify-center {{ $paymentMethod === 'transferencia' ? 'border-violet-500' : '' }}">
                                @if($paymentMethod === 'transferencia')
                                    <div class="w-2.5 h-2.5 rounded-full bg-violet-500"></div>
                                @endif
                            </div>
                            <span class="text-sm font-semibold"><i class="fas fa-university mr-2 text-base text-emerald-400"></i> Transferencia o Depósito Bancario</span>
                        </div>
                        <span class="text-xs text-slate-500">Confirmación Manual</span>
                    </label>
                </div>
            </div>

            <!-- Payment details fields based on method selection -->
            @if($paymentMethod === 'transferencia')
                <!-- Transfer Upload block -->
                <div class="glass-panel p-6 rounded-3xl border border-slate-800">
                    <h4 class="text-sm font-bold font-heading text-white mb-3">Instrucciones de Pago</h4>
                    <div class="bg-slate-900/60 p-4 rounded-2xl text-xs text-slate-300 font-light leading-relaxed mb-6 border border-slate-850">
                        {!! nl2br(e($bankInstructions)) !!}
                    </div>

                    <form wire:submit.prevent="processTransfer" class="space-y-4">
                        <div class="form-group">
                            <label class="text-xs text-slate-400 mb-2 block">Sube una foto o PDF del Comprobante</label>
                            <input type="file" class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-violet-600 file:text-white hover:file:bg-violet-500 file:cursor-pointer" wire:model="receiptFile">
                            @error('receiptFile') <span class="text-rose-400 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                                <i class="fas fa-check mr-2"></i> Registrar Comprobante
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Gateways checkouts -->
                <div class="glass-panel p-6 rounded-3xl border border-slate-800 flex flex-col space-y-4">
                    @php
                        $isConfigured = $paymentMethod === 'paypal' ? $paypalConfigured : $mercadopagoConfigured;
                    @endphp

                    @if(!$isConfigured)
                        <div class="p-3 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl text-xs font-light">
                            <i class="fas fa-info-circle mr-1"></i> Credenciales de pruebas activas. Puedes realizar una simulación directa para habilitar tu acceso.
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3">
                        @if($isConfigured)
                            <button wire:click="processGatewayPayment" class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-violet-600 hover:bg-violet-500 active:scale-95 transition-all duration-200">
                                Pagar con {{ $paymentMethod === 'paypal' ? 'PayPal' : 'MercadoPago' }}
                            </button>
                        @endif

                        <!-- Simulation mode for developer testing -->
                        <button type="button" wire:click="simulateSuccess" class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-emerald-500/30 text-sm font-bold rounded-xl text-emerald-400 bg-emerald-950/20 hover:bg-emerald-950/40 active:scale-95 transition-all duration-200">
                            <i class="fas fa-flask mr-2"></i> Simular Pago Exitoso (Pruebas)
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right panel: Order summary -->
        <div class="lg:w-1/3">
            <div class="glass-card p-6 rounded-3xl border border-slate-800 sticky top-24 shadow-2xl">
                <h3 class="text-base font-bold font-heading text-white mb-6 border-b border-slate-850 pb-3">Resumen del Pedido</h3>
                
                <div class="space-y-4 text-xs font-light text-slate-400 mb-6">
                    <div class="flex justify-between" style="display: flex; justify-content: space-between">
                        <span>Concepto:</span>
                        <strong class="text-slate-200">{{ $planName }}</strong>
                    </div>
                    <div class="flex justify-between" style="display: flex; justify-content: space-between">
                        <span>Método:</span>
                        <strong class="text-slate-200 uppercase">{{ $paymentMethod }}</strong>
                    </div>
                    <div class="flex justify-between" style="display: flex; justify-content: space-between">
                        <span>Moneda:</span>
                        <strong class="text-slate-200">MXN / USD</strong>
                    </div>
                </div>

                <div class="border-t border-slate-850 pt-4 flex justify-between items-center mb-6" style="display: flex; justify-content: space-between; align-items: center">
                    <span class="text-sm text-white font-medium">Total a Pagar:</span>
                    <span class="text-2xl font-extrabold text-violet-400 font-heading">${{ number_format($amount, 2) }}</span>
                </div>

                <div class="text-[10px] text-slate-500 text-center font-light leading-relaxed">
                    Al finalizar el pago, aceptas los términos de servicio y políticas de privacidad de Biocamp Academy.
                </div>
            </div>
        </div>
    </div>
</div>
