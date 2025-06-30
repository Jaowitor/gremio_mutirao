<div class="drawer">
    <h5>Gremio mutirão</h5>
    <div class="drawer-divider"></div>
    <div>
    <ul class="drawer-list list-unstyled">
        <li class="drawer-link">
            <a href="{{ route('dashboard') }}">
                <i class="fas fa-home" style="margin-left: 15px;"></i> Início
            </a>
        </li>
        <li class="drawer-link">
            <a href="{{ route('students.index') }}">
                <i class="fas fa-users" style="margin-left: 15px;"></i> Alunos
            </a>
        </li>
        <li class="drawer-link">
            <a href="{{ route('training.index') }}">
                <i class="fas fa-futbol" style="margin-left: 15px;"></i> Treinos
            </a>
        </li>

        <li class="drawer-link">
            <a href="{{ route('category.index') }}">
                <i class="fas fa-clipboard" style="margin-left: 15px;"></i> Turmas
            </a>
        </li>

        <li class="drawer-link">
            <a href="#">
                <i class="fas fa-cog" style="margin-left: 15px;"></i> Ajustes
            </a>
        </li>
        <li class="drawer-link">
            <form action="{{ route('logout') }}" method="POST" class="drawer-logout-form">
                @csrf
                <button type="submit" class="drawer-logout-btn visible">
                    <i class="fas fa-sign-out-alt" style="margin-left: 15px;"></i> Sair
                </button>
            </form>
        </li>
    </ul>
</div>
</div>
