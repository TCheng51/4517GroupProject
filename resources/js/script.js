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

    const roomSelect = document.querySelector("[data-room-select]");
    const previewTitle = document.querySelector("[data-room-title]");
    const previewMood = document.querySelector("[data-room-mood]");
    const previewCapacity = document.querySelector("[data-room-capacity]");
    const previewDetail = document.querySelector("[data-room-detail]");

    const roomThemes = {
        "fantasy-hearth": {
            title: "Fantasy Hearth",
            mood: "Oak shelves, lantern light, and a fireside table for classic adventures.",
            capacity: "Best for 4 players",
            detail: "Ideal for trading games, co-op quests, and first campaigns that deserve a warm welcome."
        },
        "mythic-garden": {
            title: "Mythic Garden",
            mood: "A softer corner for families, social play, and whimsical storytelling.",
            capacity: "Best for 4 players",
            detail: "Choose this for approachable titles and lighter sessions with plenty of table conversation."
        },
        "iron-archive": {
            title: "Iron Archive",
            mood: "Brass details, map drawers, and a tactical atmosphere for strategy-heavy nights.",
            capacity: "Best for 4 players",
            detail: "Strong match for euros, deck builders, and longer games where focus matters."
        },
        "starlight-orbit": {
            title: "Starlight Orbit",
            mood: "A sci-fi room with sleek lines and low amber light for future-facing adventures.",
            capacity: "Best for 6 players",
            detail: "Perfect for space epics, hidden-role sessions, and larger groups who want their own zone."
        },
        "clockwork-vault": {
            title: "Clockwork Vault",
            mood: "Steampunk textures, private service, and room to spread out campaign boxes.",
            capacity: "Best for 6 players",
            detail: "Great for long-form scenarios, RPG one-shots, and games with lots of components."
        },
        "storykeeper-suite": {
            title: "Storykeeper Suite",
            mood: "Our most private room for celebrations, flagship sessions, and premium hosting.",
            capacity: "Best for 8 players",
            detail: "Reserve this suite when the game night itself is the event."
        }
    };

    const updateRoomPreview = () => {
        if (!roomSelect || !previewTitle || !previewMood || !previewCapacity || !previewDetail) {
            return;
        }

        const theme = roomThemes[roomSelect.value];

        if (!theme) {
            previewTitle.textContent = "Choose a story room";
            previewMood.textContent = "Each space in Fabel is styled around a different genre so your table feels like part of the game.";
            previewCapacity.textContent = "Capacity will appear here";
            previewDetail.textContent = "Select a room to preview the atmosphere and the best fit for your session.";
            return;
        }

        previewTitle.textContent = theme.title;
        previewMood.textContent = theme.mood;
        previewCapacity.textContent = theme.capacity;
        previewDetail.textContent = theme.detail;
    };

    if (roomSelect) {
        roomSelect.addEventListener("change", updateRoomPreview);
        updateRoomPreview();
    }
});
