
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
            <div class="text-center p-5 bg-light rounded">
                <p class="text-muted mb-0">Nenhum aluno encontrado.</p>
            </div>
    @endforelse
</div>