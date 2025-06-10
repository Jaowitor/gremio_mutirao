<div class="breadcrumbs-container">
    <div class="breadcrumbs">
        @php
            $rotaAtual = Route::currentRouteName();
            // dd($rotaAtual);
            $breadcrumbs = $breadcrumbs_list ?? [];
            $grupoRota = explode('.', $rotaAtual)[0];
            $exibirBreadcrumb = true;
        @endphp

        @foreach ($breadcrumbs as $breadcrumb)
        
            @php
                switch ($grupoRota) {
                    case 'students':
                        if ($rotaAtual == 'students.index') {
                            $exibirBreadcrumb = $breadcrumb['name'] == 'Inicio';
                        } 
                        elseif ($rotaAtual == 'students.create' ) {
                            $exibirBreadcrumb = $breadcrumb['name'] != 'Editar Ficha' && $breadcrumb['name'] != 'Criar Aluno';
                        } elseif ($rotaAtual == 'students.edit') {
                            $exibirBreadcrumb = $breadcrumb['name'] != 'Editar Ficha' && $breadcrumb['name'] != 'Criar Aluno'; 
                        } elseif ($rotaAtual == 'students.show') {
                            $exibirBreadcrumb = $breadcrumb['name'] != 'Editar Ficha' && $breadcrumb['name'] != 'Criar Aluno' ;
                        }
                        
                        break;

                    default:
                        $exibirBreadcrumb = true;
                        break;
                }
            @endphp

            @if ($exibirBreadcrumb)
                <a href="{{ $breadcrumb['url'] }}" class="breadcrumb-link">
                    {{ $breadcrumb['name'] }}
                </a>
                @if (!$loop->last)
                    <span class="breadcrumb-divider">/</span> <!-- Separador visual -->
                @endif
            @endif
        @endforeach
    </div>
</div>