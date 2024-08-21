
$(document).ready(function() {
    const studentSubjects = window.studentSubjects;
    const subjects = window.subjects.data;

    const scoreUpdateBodyTable = $('#scores-table-body');
    const btnCreateNewRow = $('#create-row-update-score');
    const btnSubmitUpdate = $('#btn-submit-update-score');

    // get selected values
    function getSelectedValues() {
        const selectedValues = [];
        $('select').each(function() {
            if ($(this).val()) {
                selectedValues.push($(this).val());
            }
        });

        if (selectedValues.length > 0) {
            btnSubmitUpdate.show();
        } else {
            btnSubmitUpdate.hide();
        }

        return selectedValues;
    }

    // Update options in selected form
    // function updateOptions() {
    //     const selectedValues = getSelectedValues();
        
    //     $('select').each(function() {
    //         const select = $(this);
    //         let options = '<option value="">Select Subject</option>';

    //         subjects.forEach(subject => {
    //             if (!selectedValues.includes(subject.id.toString()) || select.val() === subject.id.toString()) {
    //                 const registeredSubject = studentSubjects.find(stuSubject => stuSubject.id == subject.id);
    //                 const score = registeredSubject ? registeredSubject.pivot.score : '';
    //                 options += `<option value="${subject.id}" data-score="${score !== null ? score : ''}" ${select.val() === subject.id.toString() ? 'selected' : ''}>${subject.name}</option>`;
    //             }
    //         });

    //         select.html(options);
    //     });

    //     $('select').each(function() {
    //         const select = $(this);
    //         const selectedSubjectId = select.val();
    //         const inputElement = select.closest('tr').find('input');
        
    //         if (!selectedSubjectId) {
    //             inputElement.val('');
    //         } else {
    //             const registeredSubject = studentSubjects.find(subject => subject.id == selectedSubjectId);
    //             inputElement.attr('name', `scores[${selectedSubjectId}]`);
    //             if (registeredSubject && registeredSubject.pivot) {
    //                 const score = registeredSubject.pivot.score !== undefined ? registeredSubject.pivot.score : '';
    //                 inputElement.val(score);
    //             } else {
    //                 inputElement.val(''); 
    //             }
    //         }
    //     });
        
    //     toggleCreateBtn();
    // }

    function updateOptions() {
        const selectedValues = getSelectedValues();
    
        $('select').each(function() {
            const select = $(this);
            const selectedSubjectId = select.val();
            let options = '<option value="">Select Subject</option>';
    
            subjects.forEach(subject => {
                const isSelected = selectedSubjectId === subject.id.toString();
                const isAvailable = !selectedValues.includes(subject.id.toString()) || isSelected;
                if (isAvailable) {
                    const registeredSubject = studentSubjects.find(stuSubject => stuSubject.id == subject.id);
                    const score = registeredSubject ? registeredSubject.pivot.score : '';
                    options += `<option value="${subject.id}" data-score="${score !== null ? score : ''}" ${isSelected ? 'selected' : ''}>${subject.name}</option>`;
                }
            });
    
            select.html(options);
    
            const inputElement = select.closest('tr').find('input');
            if (!selectedSubjectId) {
                inputElement.val('');
            } else {
                const registeredSubject = studentSubjects.find(subject => subject.id == selectedSubjectId);
                const score = registeredSubject && registeredSubject.pivot ? registeredSubject.pivot.score : '';
                inputElement.attr('name', `scores[${selectedSubjectId}]`).val(score);
            }
        });
    
        toggleCreateBtn();
    }
    
    // create new row update
    function createNewRow() {
        const selectedValues = getSelectedValues();
        const newRow = $('<tr></tr>');
        let options = '<option value="">Select Subject</option>';

        subjects.forEach(subject => {
            if (!selectedValues.includes(subject.id.toString())) {
                const registeredSubject = studentSubjects.find(stuSubject => stuSubject.id == subject.id);
                const score = registeredSubject ? registeredSubject.pivot.score : '';
                options += `<option value="${subject.id}" data-score="${score || ''}">${subject.name}</option>`;
            }
        });

        newRow.html(`
            <td>
                <div class="form-group">
                    <select class="custom-select subject-select">
                        ${options}
                    </select>
                    <span class="text-danger" style="display:none;"></span>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Score">
                    <span class="text-danger" style="display:none;"></span>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-remove">
                    <i class="fas fa-minus"></i>
                </button>
            </td>
        `);

        const selectElement = newRow.find('select');
        const inputElement = newRow.find('input');
        const removeButton = newRow.find('.btn-remove');

        selectElement.on('change', function() {
            const selectedSubjectId = selectElement.val();
            const selectedOption = selectElement.find('option:selected');
            const score = selectedOption.data('score');
            
            inputElement.attr('name', `scores[${selectedSubjectId}]`);
            inputElement.val(score || '');
            // updateOptions();
        });

        removeButton.on('click', function() {
            newRow.remove();
            updateOptions();
            toggleCreateBtn();
        });

        scoreUpdateBodyTable.append(newRow);
    }

    // change option in row
    scoreUpdateBodyTable.on('change', '.subject-select', function() {
        updateOptions();
        toggleCreateBtn();
    });

    // delete row select
    scoreUpdateBodyTable.on('click', '.btn-remove', function() {
        $(this).closest('tr').remove();
        updateOptions();
        toggleCreateBtn();
    });

    // toggle btn create
    function toggleCreateBtn() {
        const selectedValues = getSelectedValues();
        if (selectedValues.length === subjects.length) {
            btnCreateNewRow.hide();
        } else {
            btnCreateNewRow.show();
        }
    }

    // validate select form
    function validateForm() {
        let isValid = true;
        $('select').each(function() {
            const select = $(this);
            const feedbackElement = select.next('span.text-danger');
            if (select.val() === '') {
                isValid = false;
                select.addClass('is-invalid');
                feedbackElement.text('Please select a subject.');
                feedbackElement.show();
            } else {
                select.removeClass('is-invalid');
                feedbackElement.hide();
            }
        });
        return isValid;
    }

    btnSubmitUpdate.on('click', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    // Create new row
    btnCreateNewRow.on('click', function() {
        createNewRow();
    });

    // init 
    updateOptions();
});