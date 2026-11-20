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
		const previousButton = carousel.querySelector('[data-carousel-w-previous]');
		const nextButton = carousel.querySelector('[data-carousel-w-next]');
		let activeIndex = Number(carousel.dataset.initialIndex) || 0;
		let scrollFrame = null;
		let scrollTimer = null;

		if (!track) {
			return;
		}

		const createClone = (index, cycle) => {
			const clone = cards[index].cloneNode(true);
			clone.classList.remove('is-active');
			clone.classList.add('is-clone');
			clone.dataset.carouselWClone = String(index);
			clone.dataset.carouselWCycle = String(cycle);
			clone.setAttribute('aria-hidden', 'true');
			clone.inert = true;
			return clone;
		};

		const beforeClones = document.createDocumentFragment();
		cards.forEach((card, index) => {
			beforeClones.appendChild(createClone(index, -1));
		});
		track.insertBefore(beforeClones, cards[0]);

		cards.forEach((card, index) => {
			track.appendChild(createClone(index, 1));
		});
		const slides = Array.from(track.children);
		const carouselKey = carousel.dataset.carouselKey?.trim().toLowerCase();
		const linkedNav = carouselKey
			? Array.from(document.querySelectorAll('[data-carousel-nav]'))
				.find((nav) => nav.dataset.carouselKey?.trim().toLowerCase() === carouselKey)
			: null;

		if (linkedNav) {
			linkedNav.replaceChildren(...cards.map((card, index) => {
				const dot = document.createElement('button');
				dot.type = 'button';
				dot.className = 'carousel-nav__dot';
				dot.dataset.carouselNavIndex = String(index);
				dot.setAttribute('aria-label', linkedNav.dataset.slideLabel.replace('%d', String(index + 1)));
				dot.setAttribute('aria-pressed', 'false');
				return dot;
			}));
			linkedNav.hidden = false;
			indicators.push(...Array.from(linkedNav.querySelectorAll('[data-carousel-nav-index]')));
			const internalIndicators = carousel.querySelector('.carousel-w__indicators');
			if (internalIndicators) {
				internalIndicators.hidden = true;
			}
		}

		const getCenteredSlide = () => {
			const viewportCenter = viewport.getBoundingClientRect().left + viewport.clientWidth / 2;
			return slides.reduce((closest, slide) => {
				const distance = Math.abs(slide.getBoundingClientRect().left + slide.clientWidth / 2 - viewportCenter);
				const closestDistance = Math.abs(closest.getBoundingClientRect().left + closest.clientWidth / 2 - viewportCenter);
				return distance < closestDistance ? slide : closest;
			}, slides[0]);
		};

		const scrollToSlide = (slide, behavior) => {
			const slideRect = slide.getBoundingClientRect();
			const viewportRect = viewport.getBoundingClientRect();
			const targetLeft = viewport.scrollLeft + slideRect.left + slideRect.width / 2 - viewportRect.left - viewport.clientWidth / 2;
			viewport.scrollTo({
				left: targetLeft,
				behavior,
			});
		};

		const setActive = (index, scroll = false, direction = 0, centeredSlide = null) => {
			activeIndex = (index + cards.length) % cards.length;
			let targetSlide = centeredSlide || cards[activeIndex];

			if (scroll && direction > 0 && activeIndex === 0) {
				targetSlide = slides.find((slide) => slide.dataset.carouselWClone === '0' && slide.dataset.carouselWCycle === '1');
			} else if (scroll && direction < 0 && activeIndex === cards.length - 1) {
				targetSlide = slides.find((slide) => slide.dataset.carouselWClone === String(cards.length - 1) && slide.dataset.carouselWCycle === '-1');
			}

			slides.forEach((slide) => {
				slide.classList.toggle('is-active', slide === targetSlide);
			});
			indicators.forEach((indicator) => {
				const indicatorIndex = Number(indicator.dataset.carouselWIndicator ?? indicator.dataset.carouselNavIndex);
				const isActive = indicatorIndex === activeIndex;
				indicator.classList.toggle('is-active', isActive);
				indicator.setAttribute('aria-pressed', String(isActive));
			});

			if (scroll) {
				const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
				scrollToSlide(targetSlide, behavior);
			}
		};

		indicators.forEach((indicator) => {
			const index = Number(indicator.dataset.carouselWIndicator ?? indicator.dataset.carouselNavIndex);
			indicator.addEventListener('click', () => setActive(index, true));
		});

		previousButton?.addEventListener('click', () => setActive(activeIndex - 1, true, -1));
		nextButton?.addEventListener('click', () => setActive(activeIndex + 1, true, 1));

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

				setActive(centeredIndex, false, 0, centeredSlide);
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
