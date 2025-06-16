<div class="drawer">
    <h4>Menu</h4>
    <ul>
        <li class="drawer-link">
            <a href="#">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="drawer-link">
            <a href="{{ route('students.index') }}">
                <i class="fas fa-users" ></i> Alunos
            </a>
        </li>
        <li class="drawer-link">
            <a href="#">
                <i class="fas fa-futbol"></i> Partidas
            </a>
        </li>
        <li class="drawer-link">
            <a href="#">
                <i class="fas fa-cog"></i> Ajustes
            </a>
        </li>
        <li class="drawer-link">
            <form action="{{ route('logout') }}" method="POST" class="drawer-logout-form">
                @csrf
                <button type="submit" class="drawer-logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </form>
        </li>
    </ul>
</div>
