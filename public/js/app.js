document.addEventListener("DOMContentLoaded", () => {
    const navToggle = document.querySelector("[data-nav-toggle]");
    const nav = document.querySelector("[data-nav]");

    if (navToggle && nav) {
        navToggle.addEventListener("click", () => {
            const isOpen = nav.classList.toggle("is-open");
            navToggle.setAttribute("aria-expanded", String(isOpen));
        });

        nav.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                nav.classList.remove("is-open");
                navToggle.setAttribute("aria-expanded", "false");
            });
        });
    }

    const reservationDate = document.querySelector("[data-reservation-date]");

    if (reservationDate) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        reservationDate.min = tomorrow.toISOString().split("T")[0];
    }

    const reservationForm = document.querySelector("[data-reservation-form]");
    const roomSelect = document.querySelector("[data-room-select]");
    const timeSlotSelect = document.querySelector("#time_slot");
    const availabilityMessage = document.querySelector("[data-availability-message]");
    const previewTitle = document.querySelector("[data-room-title]");
    const previewMood = document.querySelector("[data-room-mood]");
    const previewCapacity = document.querySelector("[data-room-capacity]");
    const previewDetail = document.querySelector("[data-room-detail]");

    const updateRoomPreview = () => {
        if (!roomSelect || !previewTitle || !previewMood || !previewCapacity || !previewDetail) {
            return;
        }

        const option = roomSelect.selectedOptions[0];

        if (!option || !option.value) {
            previewTitle.textContent = "Choose a story room";
            previewMood.textContent = "Each space in Fable is styled around a different genre so your table feels like part of the game.";
            previewCapacity.textContent = "Capacity will appear here";
            previewDetail.textContent = "Select a room to preview the atmosphere and the best fit for your session.";
            return;
        }

        previewTitle.textContent = option.dataset.name || option.textContent.trim();
        previewMood.textContent = option.dataset.description || "This space is ready for your next session.";
        previewCapacity.textContent = option.dataset.capacity ? `Best for ${option.dataset.capacity} players` : "Capacity will appear here";
        previewDetail.textContent = "Choose a matching date and time to check availability.";
    };

    const updateAvailability = async () => {
        if (!reservationForm || !reservationDate || !timeSlotSelect || !roomSelect || !availabilityMessage) {
            return;
        }

        const url = reservationForm.dataset.availabilityUrl;
        const date = reservationDate.value;
        const timeSlot = timeSlotSelect.value;
        const room = roomSelect.value;

        if (!url || !date || !timeSlot || !room) {
            availabilityMessage.textContent = "Choose a date, time slot, and room to check availability.";
            availabilityMessage.classList.remove("is-success", "is-danger");
            return;
        }

        const params = new URLSearchParams({
            reservation_date: date,
            time_slot: timeSlot,
            table_room: room
        });

        availabilityMessage.textContent = "Checking availability...";
        availabilityMessage.classList.remove("is-success", "is-danger");

        try {
            const response = await fetch(`${url}?${params.toString()}`, {
                headers: { "Accept": "application/json" }
            });
            const data = await response.json();

            availabilityMessage.textContent = data.message || "Availability checked.";
            availabilityMessage.classList.toggle("is-success", Boolean(data.available));
            availabilityMessage.classList.toggle("is-danger", !data.available);
        } catch (error) {
            availabilityMessage.textContent = "Availability check is temporarily unavailable.";
            availabilityMessage.classList.add("is-danger");
        }
    };

    if (roomSelect) {
        roomSelect.addEventListener("change", () => {
            updateRoomPreview();
            updateAvailability();
        });
        updateRoomPreview();
    }

    if (reservationDate) {
        reservationDate.addEventListener("change", updateAvailability);
    }

    if (timeSlotSelect) {
        timeSlotSelect.addEventListener("change", updateAvailability);
    }

    updateAvailability();

    // Render Lucide icons. Lucide ships from CDN with a defer attr,
    // so it may finish parsing before or after this DOMContentLoaded
    // handler — handle both orderings.
    const renderIcons = () => {
        if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
        }
    };

    if (window.lucide) {
        renderIcons();
    } else {
        // Lucide hasn't loaded yet — try again after the next tick and on window load.
        window.addEventListener("load", renderIcons, { once: true });
    }

    // Submit-button loading state. Disables the primary button on form
    // submit so users don't double-submit and can see something happened.
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", () => {
            const btn = form.querySelector(
                'button[type="submit"]:not([data-no-loading])'
            );
            if (!btn || btn.disabled) return;

            // Stash original label so a future enhancement can restore it.
            btn.dataset.label = btn.textContent.trim();
            btn.setAttribute("aria-busy", "true");
            btn.textContent = "Working…";
            btn.disabled = true;
        });
    });
});
