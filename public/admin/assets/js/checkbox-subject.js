$(document).ready(function () {
    const registerSubjectCheckboxs = $('.register-subject-checkbox');
    const btnRegisterSubjectShow = $('#update-register-subject-btn');
    const checkAll = $('#check-all-register-subject');

    if(registerSubjectCheckboxs.length == 0) {
        checkAll.hide();
    }

    checkAll.on('change', function () {
        const isChecked = checkAll.prop('checked');
        registerSubjectCheckboxs.prop('checked', isChecked);
        btnRegisterSubjectShow.toggle(isChecked);
    });

    registerSubjectCheckboxs.on('change', function () {
        const anyChecked = registerSubjectCheckboxs.is(':checked');
        btnRegisterSubjectShow.toggle(anyChecked);
        checkAll.prop('checked', registerSubjectCheckboxs.length === registerSubjectCheckboxs.filter(':checked').length);
    });

    btnRegisterSubjectShow.on('click', function () {
        const bodyUpdateMultiSubject = $('#modal-body-register-multi-subjects');
        bodyUpdateMultiSubject.empty();
        registerSubjectCheckboxs.filter(':checked').each(function () {
            const subjectName = $(this).data('name');
            const subjectId = $(this).val();
            const subjectInfo = `
                <p class="text-center">${subjectId} - ${subjectName}</p>
                <input type="hidden" name="subject_ids[${subjectId}]" value="${subjectId}">
            `;
            bodyUpdateMultiSubject.append(subjectInfo);
        });
    });
});
