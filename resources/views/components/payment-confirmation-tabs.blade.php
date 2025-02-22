<div class="container row mt-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">
                    <a class="@if (Route::currentRouteName() === 'dashboard.payment_confirmations.pending.index') text-danger @endif" href="@if (Route::currentRouteName() === 'dashboard.payment_confirmations.pending.index') javascript:void() @else {{ route('dashboard.payment_confirmations.pending.index') }} @endif">
                        Pending</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">
                    <a class="@if (Route::currentRouteName() === 'dashboard.payment_confirmations.rejected.index') text-danger @endif" href="@if (Route::currentRouteName() === 'dashboard.payment_confirmations.rejected.index') javascript:void() @else {{ route('dashboard.payment_confirmations.rejected.index') }} @endif">Rejected</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">
                    <a class="@if (Route::currentRouteName() === 'dashboard.payment_confirmations.confirmed.index') text-danger @endif" href="@if (Route::currentRouteName() === 'dashboard.payment_confirmations.confirmed.index') javascript:void() @else {{ route('dashboard.payment_confirmations.confirmed.index') }} @endif">Confirmed</a>
                </div>
            </div>
        </div>
    </div>
</div>
