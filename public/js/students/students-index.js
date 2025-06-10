document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.getElementById('search-input');

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const searchQuery = searchInput.value;
        fetchStudents(1, searchQuery);
    });

    function fetchStudents(page = 1, search = '') {
        const url = new URL('/students', window.location.origin);
        url.searchParams.append('page', page);
        url.searchParams.append('q', search);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.json())
            .then(data => {
                renderStudents(data.data);
                renderPagination(data.pagination);
                window.history.pushState({}, '', url);

                M.AutoInit(); // Reinitialize Materialize components
            });
    }

    function renderStudents(students) {
        const listContainer = document.querySelector('.students-list');
        listContainer.innerHTML = '';

        if (students.length === 0) {
            listContainer.innerHTML = '<p>Nenhum aluno encontrado.</p>';
            return;
        }

        students.forEach(student => {
            const div = document.createElement('div');
            div.classList.add('student-card');
            div.innerHTML = `
                <div class="student-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="student-info">
                    <div class="student-name">${student.user.name}</div>
                    <div class="student-details">${student.nationality} | ${student.position ?? '-'}</div>
                </div>
                <div>${student.active ? 'Ativo' : 'Inativo'}</div>
            `;

            listContainer.appendChild(div);
        });

        // Atualiza apenas os elementos necessários do Materialize
        M.FormSelect.init(document.querySelectorAll('select')); 
        M.updateTextFields();
    } 

    function renderPagination(pagination) {
        const paginationContainer = document.querySelector('.pagination');
        paginationContainer.innerHTML = '';

        if (pagination.last_page > 1) {
            for (let i = 1; i <= pagination.last_page; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.classList.add('page-btn');
                if (i === pagination.current_page) btn.disabled = true;
                
                btn.addEventListener('click', () => {
                    fetchStudents(i, document.getElementById('search-input').value);
                });

                paginationContainer.appendChild(btn);
            }
        }

        M.AutoInit();
    } 
});