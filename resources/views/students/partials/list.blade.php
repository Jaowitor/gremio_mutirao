<div class="students-list">
    @forelse($students as $student)
        <div class="student-card">
            <div class="student-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="student-info">
                <div class="student-name">{{ $student->user->name ?? '-' }}</div>
                <div class="student-details">
                    {{ $student->nationality }} | {{ $student->position }} | {{ $student->laterality }}
                </div>
            </div>
            <div class="student-status">
                {{ $student->active ? 'Ativo' : 'Inativo' }}
                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-warning" style="background-color: #f39c12;">Ver</a>            
            </div>
        </div>
    @empty
        <div style="text-align:center; color:#888; margin-top:32px;">
            Nenhum aluno encontrado.
        </div>
    @endforelse
</div>