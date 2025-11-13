@extends('layouts.app')

@section('content')
    <style>
        #toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 50;
            padding: 0.85rem 1.2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            box-shadow: 0 20px 45px rgba(45, 27, 105, 0.15);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #toast.toast-visible {
            opacity: 1;
            pointer-events: auto;
        }
        .toast { display: inline-flex; align-items: center; gap: 0.75rem; }
        .toast-success { background: rgba(76, 175, 80, 0.15); color: #1B5E20; border: 1px solid rgba(76, 175, 80, 0.3); }
        .toast-error { background: rgba(244, 67, 54, 0.15); color: #B71C1C; border: 1px solid rgba(244, 67, 54, 0.3); }
        .toast-warning { background: rgba(255, 193, 7, 0.15); color: #8C6D1F; border: 1px solid rgba(255, 193, 7, 0.3); }
        .toast-info { background: rgba(79, 70, 229, 0.1); color: #312E81; border: 1px solid rgba(79, 70, 229, 0.2); }
    </style>
    <div class="flex flex-col gap-6">
    <div id="toast"></div>

        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 style="margin:0;font-size:2rem;color:#2D1B69;">Planifica tu visita a Park360</h1>
                <p style="margin:0;color:#6B5B8F;max-width:640px;">Selecciona la fecha, el tipo de entradas y los productos adicionales para construir tu paquete ideal antes de pasar al pago seguro con Stripe.</p>
            </div>
            <a href="{{ route('public.plans') }}" class="btn btn-secondary">Ver planes públicos</a>
        </div>

        <div class="grid" style="grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr); gap:2rem; align-items:flex-start;">
            <div class="flex flex-col gap-6">
                <section class="card">
                    <h2 style="margin-top:0;margin-bottom:1rem;color:#2D1B69;">1. Selecciona la fecha</h2>
                    <div class="flex flex-wrap gap-3 items-center">
                        <label for="visit-date" style="font-weight:600;color:#2D1B69;">Fecha de visita</label>
                        <input
                            type="date"
                            id="visit-date"
                            name="visit_date"
                            value="{{ $selectedDateValue ?? '' }}"
                            min="{{ now()->toDateString() }}"
                            style="flex:1;min-width:220px;padding:0.75rem 1rem;border-radius:0.75rem;border:1px solid #d1d5db;"
                        />
                    </div>
                    <p style="margin-top:0.75rem;color:#6B5B8F;font-size:0.9rem;">
                        El sistema activará automáticamente la fecha seleccionada si aún no existe para que puedas continuar con tu compra.
                    </p>
                </section>

                <section class="card">
                    <h2 style="margin-top:0;color:#2D1B69;margin-bottom:1rem;">2. Elige tus entradas</h2>
                    <div class="flex flex-col gap-3">
                        @foreach($ticketTypes as $ticket)
                            <article class="ticket-card" data-ticket-id="{{ $ticket->id }}" style="border:1px solid rgba(147,181,245,0.35);border-radius:1rem;padding:1.2rem;display:flex;flex-direction:column;gap:0.6rem;">
                                <div style="display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;">
                                    <div>
                                        <h3 style="margin:0;color:#2D1B69;">{{ $ticket->name }}</h3>
                                        <p style="margin:0;color:#6B5B8F;font-size:0.9rem;">{{ $ticket->description }}</p>
                                    </div>
                                    <span style="color:#93B5F5;font-weight:700;font-size:1.2rem;">${{ number_format($ticket->base_price, 0, ',', '.') }}</span>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.5rem;">
                                    <span style="color:#6B5B8F;font-size:0.9rem;">Cantidad</span>
                                    <div class="quantity-control" style="display:flex;align-items:center;gap:0.75rem;">
                                        <button type="button" class="btn-qty" data-action="decrement" aria-label="Reducir">−</button>
                                        <span class="qty" data-role="quantity">0</span>
                                        <button type="button" class="btn-qty" data-action="increment" aria-label="Incrementar">+</button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="card">
                    <h2 style="margin-top:0;color:#2D1B69;margin-bottom:1rem;">3. Añade productos opcionales</h2>
                    <div class="flex flex-col gap-3">
                        @foreach($addonProducts as $addon)
                            <article class="addon-card" data-addon-id="{{ $addon->id }}" style="border:1px dashed rgba(147,181,245,0.4);border-radius:1rem;padding:1.1rem;display:flex;flex-direction:column;gap:0.5rem;">
                                <div style="display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;">
                                    <div>
                                        <h3 style="margin:0;color:#2D1B69;font-size:1rem;">{{ $addon->name }}</h3>
                                        <p style="margin:0;color:#6B5B8F;font-size:0.85rem;">{{ $addon->description }}</p>
                                    </div>
                                    <span style="color:#AF93F5;font-weight:700;">${{ number_format($addon->price, 0, ',', '.') }}</span>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.35rem;">
                                    <span style="color:#6B5B8F;font-size:0.85rem;">Cantidad</span>
                                    <div class="quantity-control" style="display:flex;align-items:center;gap:0.6rem;">
                                        <button type="button" class="btn-qty" data-action="decrement" aria-label="Reducir">−</button>
                                        <span class="qty" data-role="quantity">0</span>
                                        <button type="button" class="btn-qty" data-action="increment" aria-label="Incrementar">+</button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside class="card" style="position:sticky;top:1rem;display:flex;flex-direction:column;gap:1.2rem;">
                <div>
                    <h2 style="margin:0;color:#2D1B69;">Resumen de compra</h2>
                    <p style="margin:0;color:#6B5B8F;font-size:0.9rem;">Revisa los detalles antes de continuar al pago.</p>
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;">Fecha seleccionada</span>
                    <p id="summary-date" style="margin:0.3rem 0 0;color:#2D1B69;"></p>
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;">Entradas</span>
                    <ul id="summary-tickets" style="list-style:none;padding:0;margin:0.5rem 0 0;display:flex;flex-direction:column;gap:0.4rem;color:#2D1B69;font-size:0.9rem;"></ul>
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;">Adicionales</span>
                    <ul id="summary-addons" style="list-style:none;padding:0;margin:0.5rem 0 0;display:flex;flex-direction:column;gap:0.4rem;color:#2D1B69;font-size:0.9rem;"></ul>
                </div>

                <div style="border-top:1px solid rgba(147,181,245,0.2);padding-top:1rem;display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#6B5B8F;font-weight:700;">Total estimado</span>
                    <strong id="summary-total" style="font-size:1.4rem;color:#2D1B69;">$0</strong>
                </div>

                <button id="go-checkout" class="btn" style="width:100%;">Proceder al checkout</button>
                <p style="margin:0;color:#9CA3AF;font-size:0.8rem;">Usa tarjetas de prueba de Stripe (4242 4242 4242 4242) para validar el flujo.</p>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const catalog = {
            visitDates: @json($visitDates),
            tickets: @json($ticketCatalog),
            addons: @json($addonCatalog),
        };

        const state = {
            visitDateId: @json($selectedDateId),
            visitDateValue: @json($selectedDateValue),
            visitDateLabel: @json($selectedDateLabel),
            tickets: {},
            addons: {},
        };

        function getTodayValue() {
            const now = new Date();
            const offset = now.getTimezoneOffset() * 60000;
            return new Date(now.getTime() - offset).toISOString().slice(0, 10);
        }

        function formatDateLabel(value) {
            if (!value) {
                return null;
            }

            try {
                const parsed = new Date(value);
                if (Number.isNaN(parsed.getTime())) {
                    return value;
                }

                const formatted = dateFormatter.format(parsed);
                return formatted.charAt(0).toUpperCase() + formatted.slice(1);
            } catch (error) {
                return value;
            }
        }

        function extractErrorMessage(payload, fallback) {
            if (!payload) {
                return fallback;
            }

            if (payload.message === 'The given data was invalid.' && payload.errors) {
                const firstError = Object.values(payload.errors)[0];
                if (Array.isArray(firstError) && firstError.length) {
                    return firstError[0];
                }
                return 'La información proporcionada no es válida.';
            }

            if (payload.message) {
                if (payload.message === 'The given data was invalid.') {
                    return 'La información proporcionada no es válida.';
                }

                return payload.message;
            }

            return fallback;
        }

        const formatter = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        const dateFormatter = new Intl.DateTimeFormat('es-CO', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });

        const toastEl = document.getElementById('toast');
        let toastTimeoutId = null;
        function showToast(message, type = 'info') {
            if (!toastEl) return;

            if (toastTimeoutId) {
                clearTimeout(toastTimeoutId);
                toastTimeoutId = null;
            }

            toastEl.textContent = message;
            toastEl.className = 'toast';
            toastEl.classList.add(`toast-${type}`);
            toastEl.classList.add('toast-visible');

            toastTimeoutId = setTimeout(() => {
                toastEl.classList.remove('toast-visible');
                toastTimeoutId = null;
            }, 3000);
        }

        function syncSummary() {
            const summaryDate = document.getElementById('summary-date');
            const ticketsList = document.getElementById('summary-tickets');
            const addonsList = document.getElementById('summary-addons');
            const totalEl = document.getElementById('summary-total');

            const label = state.visitDateLabel ?? formatDateLabel(state.visitDateValue);
            summaryDate.textContent = label ?? 'Selecciona una fecha';

            ticketsList.innerHTML = '';
            let total = 0;

            Object.entries(state.tickets).forEach(([id, quantity]) => {
                const ticket = catalog.tickets.find((item) => String(item.id) === String(id));
                if (!ticket || quantity <= 0) return;

                const li = document.createElement('li');
                li.textContent = `${ticket.name} × ${quantity} — ${formatter.format(ticket.price * quantity)}`;
                ticketsList.appendChild(li);
                total += ticket.price * quantity;
            });

            addonsList.innerHTML = '';
            Object.entries(state.addons).forEach(([id, quantity]) => {
                const addon = catalog.addons.find((item) => String(item.id) === String(id));
                if (!addon || quantity <= 0) return;

                const li = document.createElement('li');
                li.textContent = `${addon.name} × ${quantity} — ${formatter.format(addon.price * quantity)}`;
                addonsList.appendChild(li);
                total += addon.price * quantity;
            });

            if (!ticketsList.children.length) {
                const empty = document.createElement('li');
                empty.textContent = 'Sin entradas seleccionadas';
                empty.style.color = '#9CA3AF';
                ticketsList.appendChild(empty);
            }

            if (!addonsList.children.length) {
                const emptyAddon = document.createElement('li');
                emptyAddon.textContent = 'Sin adicionales';
                emptyAddon.style.color = '#9CA3AF';
                addonsList.appendChild(emptyAddon);
            }

            totalEl.textContent = formatter.format(total);
        }

        function attachQuantityHandlers(selector, targetState) {
            document.querySelectorAll(selector).forEach((card) => {
                const id = card.dataset.ticketId || card.dataset.addonId;
                const qtyEl = card.querySelector('[data-role="quantity"]');

                const update = (delta) => {
                    const current = Number.parseInt(targetState[id] ?? 0, 10);
                    const next = Math.max(0, current + delta);
                    targetState[id] = next;
                    qtyEl.textContent = String(next);
                    syncSummary();
                };

                card.querySelectorAll('.btn-qty').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const action = btn.dataset.action;
                        update(action === 'increment' ? 1 : -1);
                    });
                });
            });
        }

        function setVisitDateState(value) {
            if (!value) {
                state.visitDateId = null;
                state.visitDateValue = null;
                state.visitDateLabel = null;
                syncSummary();
                return;
            }

            const normalized = String(value);
            state.visitDateValue = normalized;

            const existing = catalog.visitDates.find((item) => item.value === normalized);

            if (existing) {
                state.visitDateId = existing.id;
                state.visitDateLabel = existing.label;
            } else {
                state.visitDateId = null;
                state.visitDateLabel = formatDateLabel(normalized);
            }

            syncSummary();
        }

        async function ensureVisitDate(dateValue, options = {}) {
            const { silent = false, createIfMissing = true } = options;
            const todayValue = getTodayValue();

            if (!dateValue) {
                if (!silent) {
                    showToast('Selecciona una fecha antes de continuar.', 'warning');
                }

                state.visitDateId = null;
                state.visitDateValue = null;
                state.visitDateLabel = null;
                syncSummary();

                return false;
            }

            const normalized = String(dateValue);

            if (normalized < todayValue) {
                if (!silent) {
                    showToast('La fecha debe ser hoy o posterior.', 'warning');
                }

                state.visitDateId = null;
                state.visitDateValue = null;
                state.visitDateLabel = null;
                syncSummary();

                return false;
            }

            const existing = catalog.visitDates.find((item) => item.value === normalized);

            if (existing) {
                state.visitDateId = existing.id;
                state.visitDateValue = existing.value;
                state.visitDateLabel = existing.label;
                syncSummary();

                return true;
            }

            if (!createIfMissing) {
                state.visitDateId = null;
                state.visitDateValue = normalized;
                state.visitDateLabel = formatDateLabel(normalized);
                syncSummary();

                return false;
            }

            const formData = new FormData();
            formData.append('visit_date', normalized);

            try {
                const response = await fetch(@json(route('payments.visit-dates.store')), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                const payload = await response.json().catch(() => null);

                if (!response.ok || !payload) {
                    const message = extractErrorMessage(payload, 'No se pudo crear la fecha.');
                    throw new Error(message);
                }

                catalog.visitDates.push(payload);
                catalog.visitDates.sort((a, b) => a.value.localeCompare(b.value));

                state.visitDateId = payload.id;
                state.visitDateValue = payload.value;
                state.visitDateLabel = payload.label;
                syncSummary();

                return true;
            } catch (error) {
                console.error(error);
                state.visitDateId = null;
                state.visitDateValue = normalized;
                state.visitDateLabel = formatDateLabel(normalized);
                syncSummary();

                if (!silent) {
                    showToast(error.message ?? 'Ocurrió un error al crear la fecha.', 'error');
                }

                return false;
            }
        }

        function handleVisitDateInput() {
            const input = document.getElementById('visit-date');
            if (!input) return;

            input.addEventListener('change', () => {
                const todayValue = getTodayValue();
                const value = input.value;

                if (value && value < todayValue) {
                    showToast('La fecha debe ser hoy o posterior.', 'warning');
                    input.value = todayValue;
                    setVisitDateState(todayValue);
                    return;
                }

                setVisitDateState(value || null);
            });

            if (input.value) {
                const todayValue = getTodayValue();
                if (input.value < todayValue) {
                    input.value = todayValue;
                    setVisitDateState(todayValue);
                } else {
                    setVisitDateState(input.value);
                }
            } else {
                setVisitDateState(null);
            }
        }

        async function goToCheckout() {
            const input = document.getElementById('visit-date');
            const targetValue = state.visitDateValue || (input ? input.value : null);

            if (!targetValue) {
                showToast('Selecciona una fecha antes de continuar.', 'warning');
                return;
            }

            const ready = await ensureVisitDate(targetValue, { silent: false, createIfMissing: true });

            if (!ready) {
                return;
            }

            const ticketsPayload = Object.entries(state.tickets)
                .filter(([, quantity]) => quantity > 0)
                .map(([id, quantity]) => ({ id, quantity }));

            if (!ticketsPayload.length) {
                showToast('Selecciona al menos una entrada para continuar.', 'warning');
                return;
            }

            const addonsPayload = Object.entries(state.addons)
                .filter(([, quantity]) => quantity > 0)
                .map(([id, quantity]) => ({ id, quantity }));

            const payload = {
                visit_date_id: state.visitDateId,
                tickets: ticketsPayload,
                addons: addonsPayload,
            };

            try {
                const response = await fetch(@json(route('checkout.session.store')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json().catch(() => null);

                if (!response.ok || !data) {
                    const message = extractErrorMessage(data, 'No se pudo iniciar el pago.');
                    throw new Error(message);
                }

                window.location.href = data.redirect_url;
            } catch (error) {
                console.error(error);
                showToast(error.message ?? 'Ocurrió un error al iniciar el checkout.', 'error');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            attachQuantityHandlers('.ticket-card', state.tickets);
            attachQuantityHandlers('.addon-card', state.addons);

            const dateInput = document.getElementById('visit-date');
            if (dateInput) {
                dateInput.min = getTodayValue();
            }

            handleVisitDateInput();
            syncSummary();

            const checkoutButton = document.getElementById('go-checkout');
            if (checkoutButton) {
                checkoutButton.addEventListener('click', goToCheckout);
            }

            @if(!empty($flashError))
                showToast(@json($flashError), 'error');
            @endif

            @if(!empty($flashSuccess))
                showToast(@json($flashSuccess), 'success');
            @endif
        });
    </script>
@endpush
