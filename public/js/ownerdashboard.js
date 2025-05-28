let profileDropdownList = document.querySelector(".profile-dropdown-list");
let btn = document.querySelector(".profile-dropdown-btn");

let classList = profileDropdownList.classList;

const toggle = () => classList.toggle("active");

window.addEventListener("click", function (e) {
    if (!btn.contains(e.target)) classList.remove("active");
});






$(document).ready(function () {
    // Pet tab switch
    $(".pet-tabs a").click(function (e) {
        e.preventDefault();
        const target = $(this).attr("href");

        $(".pet-tabs a").removeClass("active");
        $(this).addClass("active");

        $(".tab-pane").hide();
        $(target).show();

        // Reset sub-tabs to Pet Profile
        $(target).find(".nested-tab-link").removeClass("active");
        $(target).find(".nested-tab-pane").hide();

        $(target).find('.nested-tab-link[href^="#profile"]').addClass("active");
        $(target).find('.nested-tab-pane[id^="profile"]').show();
    });

    // Sub-tab switch inside pet
    $(".nested-tab-link").click(function (e) {
        e.preventDefault();
        const target = $(this).attr("href");
        const $container = $(this).closest(".tab-pane");

        $container.find(".nested-tab-link").removeClass("active");
        $(this).addClass("active");

        $container.find(".nested-tab-pane").hide();
        $container.find(target).show();
    });

    const firstPetPane = $(".tab-pane").first();
    firstPetPane.show();

    firstPetPane.find(".nested-tab-link").removeClass("active");
    firstPetPane.find(".nested-tab-pane").hide();

    firstPetPane.find('.nested-tab-link[href^="#profile"]').addClass("active");
    firstPetPane.find('.nested-tab-pane[id^="profile"]').show();

    // Function to change the record date and display relevant records
    window.changeRecordDate = function (type, petId, element) {
    const selectedDate = $(element).val();

    if (type === "diagnosis") {
        // Hide all diagnosis rows
        $(`[id^="diagnosis-body-${petId}-"]`).hide();
        // Show selected diagnosis
        $(`#diagnosis-body-${petId}-${selectedDate}`).show();

        // Hide all medication tables
        $(`[id^="medication-table-${petId}-"]`).hide();
        // Show selected medication
        $(`#medication-table-${petId}-${selectedDate}`).show();
    } else if (type === "vaccination") {
        // Hide all vaccination bodies
        $(`[id^="vaccination-body-${petId}-"]`).hide();
        // Show selected vaccination group
        $(`#vaccination-body-${petId}-${selectedDate}`).show();
    }
};

    // Function to toggle between appointment table and schedule form
    window.toggleScheduleForm = function(petId) {
        const tableContainer = document.getElementById(`appointment-table-container-${petId}`);
        const formContainer = document.getElementById(`schedule-appointment-form-${petId}`);
        const btn = document.getElementById(`schedule-appointment-btn-${petId}`);

        // Toggle visibility
        tableContainer.style.display = tableContainer.style.display === 'none' ? 'block' : 'none';
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
        
        // Change button text based on form visibility
        if (formContainer.style.display === 'block') {
            btn.textContent = 'Back to Appointments';
        } else {
            btn.textContent = 'Schedule Appointment';
        }
    };

});

document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.schedule-appointment-form');

        forms.forEach(form => {
            const petId = form.id.split('-').pop(); // get PetID from div ID
            const dateSelect = document.querySelector(`#appointment-date-${petId}`);
            const timeSelect = document.querySelector(`#appointment-time-${petId}`);

            if (!dateSelect || !timeSelect) return;

            dateSelect.addEventListener('change', function () {
                const selectedDate = this.value;
                timeSelect.innerHTML = '<option>Loading...</option>';

                fetch(`/available-times?date=${selectedDate}`)
                    .then(res => res.json())
                    .then(times => {
                        timeSelect.innerHTML = ''; // clear old times

                        if (times.length === 0) {
                            timeSelect.innerHTML = '<option value="">No available times</option>';
                            return;
                        }

                        times.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time;

                            const timeFormat = new Date(`1970-01-01T${time}:00`).toLocaleTimeString([], {
                                hour: 'numeric', minute: '2-digit'
                            });

                            option.textContent = timeFormat;
                            timeSelect.appendChild(option);
                        });
                    });
            });

            // Trigger once on load to refresh times for the default date
            dateSelect.dispatchEvent(new Event('change'));
        });
    });



