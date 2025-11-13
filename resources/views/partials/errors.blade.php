@if ($errors->any())
    <div class="flash-message" style="background: #fee2e2; color: #991b1b; border-color: #fecaca;">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
