// document.addEventListener("DOMContentLoaded", function() {
//     const bodyRowScore = document.getElementById("scores-table-body");
//     const btnCreateRowScore = document.getElementById("create-row-update-score");
//     // console.log(bodyRowScore, btnCreateRowScore);

//     function getSelectedValues() {
//         const selectedValue = [];
//         const selects = document.querySelectorAll("select");
//         selects.forEach(select => {
//             if (select.value) {
//                 selectedValue.push(select.value);
//             }
//         })

//         return selectedValue;
//     }

//     btnCreateRowScore.addEventListener("click", () => {
//         const selectedValues = getSelectedValues();
//         const newRow = document.createElement("tr");
//         newRow.innerHTML = `
//             <td> 
//                 <div class="form-group">
//                     <select class="custom-select">
//                         @foreach ($student->subjects as $subject)
//                             <option value="{{ $subject->id }}">{{ $subject->name }}</option>
//                         @endforeach
//                     </select>
//                 </div>    
//             </td>
//             <td> 
//                 <div class="form-group">
//                     <input type="number" class="form-control" placeholder="Score">
//                 </div>    
//             </td>
//             <td>
//                 <button class="btn btn-danger">
//                     <i class="fas fa-minus"></i>
//                 </button>
//             </td>
//         `;
//         const newSelects = document.querySelector("select");
//         newSelects.querySelectorAll("option").forEach(option => {
//             if (selectedValues.includes(option.value)) {
//                 option.disabled = true;
//             }
//         })
//         bodyRowScore.appendChild(newRow);
//     })


//     console.log(getSelectedValues());
// })