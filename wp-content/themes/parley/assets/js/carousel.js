(() => {
    const carousels = document.querySelectorAll("[data-carousel]");

    const initialise = (carousel) => {
        const track = carousel.querySelector("[data-carousel-track]");
        const slides = [...track.querySelectorAll("[data-carousel-slide]")];
        const dots = [...carousel.querySelectorAll("[data-carousel-dot]")];
        const previous = carousel.querySelector("[data-carousel-previous]");
        const next = carousel.querySelector("[data-carousel-next]");

        carousel.querySelectorAll("[hidden]").forEach((control) => {
            control.hidden = false;
        });

        const step = () => (slides.length > 1 ? slides[1].offsetLeft - slides[0].offsetLeft : track.clientWidth);
        const scrollByPages = (direction) => track.scrollBy({ left: direction * step(), behavior: "smooth" });

        dots.forEach((dot, index) => {
            dot.addEventListener("click", () => track.scrollTo({ left: slides[index].offsetLeft - track.offsetLeft, behavior: "smooth" }));
        });

        previous?.addEventListener("click", () => scrollByPages(-1));
        next?.addEventListener("click", () => scrollByPages(1));

        const updateControls = () => {
            const maxScroll = track.scrollWidth - track.clientWidth - 2;
            const activeIndex = Math.round(track.scrollLeft / (step() || 1));

            dots.forEach((dot, index) => dot.setAttribute("aria-current", String(index === activeIndex)));

            if (previous) previous.disabled = track.scrollLeft <= 2;
            if (next) next.disabled = track.scrollLeft >= maxScroll;
        };

        track.addEventListener("scroll", updateControls, { passive: true });
        window.addEventListener("resize", updateControls);
        updateControls();
    };

    carousels.forEach(initialise);
})();
