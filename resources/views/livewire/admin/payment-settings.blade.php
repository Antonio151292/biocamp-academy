<div class="pt-3">
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Environment Switch Widget -->
    <div class="card card-outline {{ $payment_mode === 'live' ? 'card-success' : 'card-warning' }} mb-4">
        <div class="card-body d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center">
            <div>
                <h4 class="mb-1">Entorno de Pagos Activo</h4>
                <p class="text-muted mb-0">
                    Determina si las compras se procesan en modo de simulación (Sandbox) o dinero real (Productivo).
                </p>
            </div>
            <div class="text-right">
                <span class="badge {{ $payment_mode === 'live' ? 'badge-success' : 'badge-warning' }} p-2 mr-3" style="font-size: 15px">
                    <i class="fas {{ $payment_mode === 'live' ? 'fa-check-circle' : 'fa-flask' }}"></i> 
                    {{ $payment_mode === 'live' ? 'PRODUCTIVO (En Vivo)' : 'SANDBOX (Pruebas)' }}
                </span>
                <button type="button" class="btn {{ $payment_mode === 'live' ? 'btn-warning' : 'btn-success' }}" wire:click="togglePaymentMode">
                    <i class="fas fa-sync-alt"></i> Cambiar a {{ $payment_mode === 'live' ? 'Sandbox' : 'Productivo' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Credentials Editor Form -->
    <form wire:submit.prevent="saveSettings">
        <div class="row">
            <!-- PayPal Settings -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fab fa-paypal mr-1"></i> Credenciales de PayPal</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="text-warning">Configuración de Pruebas (Sandbox)</h5>
                        <div class="form-group">
                            <label>Client ID Sandbox</label>
                            <input type="text" class="form-control" wire:model="paypal_sandbox_client_id">
                        </div>
                        <div class="form-group">
                            <label>Client Secret Sandbox</label>
                            <input type="password" class="form-control" wire:model="paypal_sandbox_secret">
                        </div>

                        <hr>

                        <h5 class="text-success">Configuración de Producción (Live)</h5>
                        <div class="form-group">
                            <label>Client ID Live</label>
                            <input type="text" class="form-control" wire:model="paypal_live_client_id">
                        </div>
                        <div class="form-group">
                            <label>Client Secret Live</label>
                            <input type="password" class="form-control" wire:model="paypal_live_secret">
                        </div>
                    </div>
                </div>
            </div>

            <!-- MercadoPago Settings -->
            <div class="col-md-6">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-credit-card mr-1"></i> Credenciales de MercadoPago</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="text-warning">Configuración de Pruebas (Sandbox)</h5>
                        <div class="form-group">
                            <label>Public Key Sandbox</label>
                            <input type="text" class="form-control" wire:model="mercadopago_sandbox_public_key">
                        </div>
                        <div class="form-group">
                            <label>Access Token Sandbox</label>
                            <input type="password" class="form-control" wire:model="mercadopago_sandbox_access_token">
                        </div>

                        <hr>

                        <h5 class="text-success">Configuración de Producción (Live)</h5>
                        <div class="form-group">
                            <label>Public Key Live</label>
                            <input type="text" class="form-control" wire:model="mercadopago_live_public_key">
                        </div>
                        <div class="form-group">
                            <label>Access Token Live</label>
                            <input type="password" class="form-control" wire:model="mercadopago_live_access_token">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Transfer details -->
        <div class="card card-outline card-secondary mb-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-university mr-1"></i> Datos e Instrucciones de Transferencia Bancaria</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="bank_transfer_instructions">Instrucciones para el Estudiante</label>
                    <textarea id="bank_transfer_instructions" rows="5" class="form-control" placeholder="Escribe los datos de la cuenta bancaria donde los estudiantes deben depositar (Banco, Titular, Número de cuenta, Clabe interbancaria) e indicaciones adicionales como enviar el comprobante." wire:model="bank_transfer_instructions"></textarea>
                </div>
            </div>
        </div>

        <!-- Submit Settings -->
        <div class="row pb-5">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    <i class="fas fa-save mr-1"></i> Guardar Todos los Ajustes
                </button>
            </div>
        </div>
    </form>
</div>
