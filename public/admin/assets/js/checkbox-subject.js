document.addEventListener('DOMContentLoaded', function () {
    const registerSubjectCheckboxs = document.querySelectorAll('.register-subject-checkbox');
    const btnRegisterSubjectShow = document.getElementById('update-register-subject-btn');

    registerSubjectCheckboxs.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const anyChecked = Array.from(registerSubjectCheckboxs).some(checkbox => checkbox.checked);
            btnRegisterSubjectShow.style.display = anyChecked? 'block' : 'none';
        });
    });
    
    btnRegisterSubjectShow.addEventListener('click', function (){
        const bodyUpdateMultiSubject = document.getElementById('modal-body-register-multi-subjects');
        bodyUpdateMultiSubject.innerHTML = '';
        registerSubjectCheckboxs.forEach(checkbox => {
            if (checkbox.checked) {
                const subjectName = checkbox.getAttribute('data-name');
                const subjectId = checkbox.value;
                const subjectInfo = `
                    <p class="text-center">${ subjectId } - ${ subjectName }</p>
                    <input type="hidden" name="subject_ids[${subjectId}]" value="${subjectId}">
                `;
            
                bodyUpdateMultiSubject.insertAdjacentHTML('beforeend', subjectInfo);
            }
        });
    })
})