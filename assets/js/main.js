import './menu.js';

function initializeWideCarousels() {
	document.querySelectorAll('[data-carousel-w]').forEach((carousel) => {
		const viewport = carousel.querySelector('.carousel-w__viewport');
		const cards = Array.from(carousel.querySelectorAll('.carousel-w__card'));
		const indicators = Array.from(carousel.querySelectorAll('[data-carousel-w-indicator]'));

		if (!viewport || cards.length < 2) {
			return;
		}

		const track = carousel.querySelector('.carousel-w__track');
		let activeIndex = Number(carousel.dataset.initialIndex) || 0;
		let scrollFrame = null;
		let scrollTimer = null;

		if (!track) {
			return;
		}

		const createClone = (index) => {
			const clone = cards[index].cloneNode(true);
			clone.classList.remove('is-active');
			clone.classList.add('is-clone');
			clone.dataset.carouselWClone = String(index);
			clone.setAttribute('aria-hidden', 'true');
			clone.inert = true;
			return clone;
		};

		track.insertBefore(createClone(cards.length - 1), cards[0]);
		track.appendChild(createClone(0));
		const slides = Array.from(track.children);

		const getCenteredSlide = () => {
			const viewportCenter = viewport.getBoundingClientRect().left + viewport.clientWidth / 2;
			return slides.reduce((closest, slide) => {
				const distance = Math.abs(slide.getBoundingClientRect().left + slide.clientWidth / 2 - viewportCenter);
				const closestDistance = Math.abs(closest.getBoundingClientRect().left + closest.clientWidth / 2 - viewportCenter);
				return distance < closestDistance ? slide : closest;
			}, slides[0]);
		};

		const scrollToSlide = (slide, behavior) => {
			const slideLeft = slide.getBoundingClientRect().left - viewport.getBoundingClientRect().left + viewport.scrollLeft;
			viewport.scrollTo({
				left: slideLeft - (viewport.clientWidth - slide.clientWidth) / 2,
				behavior,
			});
		};

		const setActive = (index, scroll = false, direction = 0) => {
			const previousIndex = activeIndex;
			activeIndex = (index + cards.length) % cards.length;

			cards.forEach((card, cardIndex) => {
				card.classList.toggle('is-active', cardIndex === activeIndex);
			});
			indicators.forEach((indicator, indicatorIndex) => {
				const isActive = indicatorIndex === activeIndex;
				indicator.classList.toggle('is-active', isActive);
				indicator.setAttribute('aria-pressed', String(isActive));
			});

			if (scroll) {
				const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
				let targetSlide = cards[activeIndex];

				if (direction > 0 && previousIndex === cards.length - 1 && activeIndex === 0) {
					targetSlide = slides[slides.length - 1];
				} else if (direction < 0 && previousIndex === 0 && activeIndex === cards.length - 1) {
					targetSlide = slides[0];
				}

				scrollToSlide(targetSlide, behavior);
			}
		};

		indicators.forEach((indicator, index) => {
			indicator.addEventListener('click', () => setActive(index, true));
		});

		viewport.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
				event.preventDefault();
				const direction = event.key === 'ArrowRight' ? 1 : -1;
				setActive(activeIndex + direction, true, direction);
			}
		});

		viewport.addEventListener('scroll', () => {
			if (scrollFrame !== null) {
				cancelAnimationFrame(scrollFrame);
			}
			window.clearTimeout(scrollTimer);

			scrollFrame = requestAnimationFrame(() => {
				const centeredSlide = getCenteredSlide();
				const centeredIndex = centeredSlide.dataset.carouselWClone !== undefined
					? Number(centeredSlide.dataset.carouselWClone)
					: cards.indexOf(centeredSlide);

				setActive(centeredIndex);
				scrollFrame = null;
			});

			scrollTimer = window.setTimeout(() => {
				const centeredSlide = getCenteredSlide();
				if (centeredSlide.dataset.carouselWClone !== undefined) {
					scrollToSlide(cards[Number(centeredSlide.dataset.carouselWClone)], 'auto');
				}
			}, 150);
		}, { passive: true });

		requestAnimationFrame(() => setActive(activeIndex, true));
	});
}

class General {
	constructor() {
		this.testVariable = 'script working';
		this.init();
	}

	init() {
		// for tests purposes only
		console.log(this.testVariable);
	}
}

document.addEventListener('DOMContentLoaded', () => {
	initializeWideCarousels();
	new General();
});
