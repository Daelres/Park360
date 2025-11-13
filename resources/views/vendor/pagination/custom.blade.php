@if ($paginator->hasPages())
    <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="color: #E0E0E0; padding: 0.6rem 1.2rem; border-radius: 0.5rem; background: #F5F5F5; cursor: not-allowed;">
                <i class="fas fa-chevron-left"></i> Anterior
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="color: white; background: oklch(0.55 0.25 280); padding: 0.6rem 1.2rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='oklch(0.50 0.25 280)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='oklch(0.55 0.25 280)'; this.style.transform='translateY(0)';">
                <i class="fas fa-chevron-left"></i> Anterior
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="color: #718096; padding: 0.6rem 0.8rem;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="background: oklch(0.55 0.25 280); color: white; padding: 0.6rem 0.8rem; border-radius: 0.5rem; font-weight: 700; min-width: 2.5rem; text-align: center;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="color: oklch(0.55 0.25 280); padding: 0.6rem 0.8rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; background: transparent; border: 2px solid oklch(0.55 0.25 280); transition: all 0.3s ease; min-width: 2.5rem; text-align: center; display: inline-block;" onmouseover="this.style.background='oklch(0.55 0.25 280)'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.color='oklch(0.55 0.25 280)';">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="color: white; background: oklch(0.55 0.25 280); padding: 0.6rem 1.2rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='oklch(0.50 0.25 280)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='oklch(0.55 0.25 280)'; this.style.transform='translateY(0)';">
                Siguiente <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span style="color: #E0E0E0; padding: 0.6rem 1.2rem; border-radius: 0.5rem; background: #F5F5F5; cursor: not-allowed;">
                Siguiente <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </div>
@endif

