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

const periodMoodSymbols = {
	happy: '🙂',
	neutral: '😐',
	sad: '🙁',
};

const periodActivityIcons = {
	strength: 'M3 12h4l3-7 4 14 3-7h4',
	cardio: 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z',
	hiit: 'M13 2 3 14h8l-1 8 11-12h-8l1-8z',
	yoga: 'M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z M12 2v2 M12 20v2 M4.93 4.93l1.42 1.42 M17.65 17.65l1.42 1.42 M2 12h2 M20 12h2 M4.93 19.07l1.42-1.42 M17.65 6.35l1.42-1.42',
};

const periodActivityLabels = {
	strength: 'Strength',
	cardio: 'Cardio',
	hiit: 'HIIT',
	yoga: 'Yoga',
};

function createPeriodActivityIcon(activity) {
	const svgNamespace = 'http://www.w3.org/2000/svg';
	const icon = document.createElementNS(svgNamespace, 'svg');
	const path = document.createElementNS(svgNamespace, 'path');
	icon.setAttribute('viewBox', '0 0 24 24');
	icon.setAttribute('aria-hidden', 'true');
	icon.classList.add('period-calendar__activity-icon');
	path.setAttribute('d', periodActivityIcons[activity]);
	icon.appendChild(path);
	return icon;
}

function isCalendarDateKey(value) {
	if (typeof value !== 'string' || !/^\d{4}-\d{2}-\d{2}$/.test(value)) {
		return false;
	}
	const [year, month, day] = value.split('-').map(Number);
	const date = new Date(year, month - 1, day);
	return date.getFullYear() === year && date.getMonth() === month - 1 && date.getDate() === day;
}

function readPeriodTrackingData(storageKey) {
	const storedData = window.localStorage.getItem(storageKey);
	if (!storedData) {
		return { periodDates: [], moods: {}, activities: {} };
	}

	const parsedData = JSON.parse(storedData);
	if (Array.isArray(parsedData)) {
		return { periodDates: parsedData.filter(isCalendarDateKey), moods: {}, activities: {} };
	}
	if (!parsedData || typeof parsedData !== 'object') {
		throw new TypeError('Stored period tracking data has an invalid format.');
	}

	const periodDates = Array.isArray(parsedData.periodDates)
		? parsedData.periodDates.filter(isCalendarDateKey)
		: [];
	const moods = parsedData.moods && typeof parsedData.moods === 'object' && !Array.isArray(parsedData.moods)
		? Object.fromEntries(Object.entries(parsedData.moods).filter(([date, mood]) => isCalendarDateKey(date) && Object.prototype.hasOwnProperty.call(periodMoodSymbols, mood)))
		: {};
	const activities = parsedData.activities && typeof parsedData.activities === 'object' && !Array.isArray(parsedData.activities)
		? Object.fromEntries(Object.entries(parsedData.activities)
			.filter(([date, values]) => isCalendarDateKey(date) && Array.isArray(values))
			.map(([date, values]) => [date, [...new Set(values.filter((activity) => Object.prototype.hasOwnProperty.call(periodActivityIcons, activity)))]]))
		: {};
	return { periodDates, moods, activities };
}

const periodTrackingDrafts = new Map();

function getPeriodTrackingDraft(storageKey, dateKey) {
	const draftKey = `${storageKey}:${dateKey}`;
	if (!periodTrackingDrafts.has(draftKey)) {
		const data = readPeriodTrackingData(storageKey);
		periodTrackingDrafts.set(draftKey, {
			mood: data.moods[dateKey] || null,
			activities: [...(data.activities[dateKey] || [])],
		});
	}
	return periodTrackingDrafts.get(draftKey);
}

function updatePeriodTrackingData(storageKey, update, source) {
	const currentData = readPeriodTrackingData(storageKey);
	const nextData = update(currentData);
	window.localStorage.setItem(storageKey, JSON.stringify(nextData));
	window.dispatchEvent(new CustomEvent('projecttheme:period-data-updated', {
		detail: { storageKey, source },
	}));
	return nextData;
}

function initializePeriodCalendars() {
	document.querySelectorAll('[data-period-calendar]').forEach((calendar) => {
		const monthLabel = calendar.querySelector('[data-calendar-month]');
		const daysContainer = calendar.querySelector('[data-calendar-days]');
		const status = calendar.querySelector('[data-calendar-status]');
		const previousButton = calendar.querySelector('[data-calendar-previous]');
		const nextButton = calendar.querySelector('[data-calendar-next]');
		const todayButton = calendar.querySelector('[data-calendar-today]');
		const storageKey = calendar.dataset.storageKey;

		if (!monthLabel || !daysContainer || !status || !storageKey) {
			return;
		}

		const locale = document.documentElement.lang || undefined;
		const monthFormatter = new Intl.DateTimeFormat(locale, { month: 'long', year: 'numeric' });
		const dateFormatter = new Intl.DateTimeFormat(locale, { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
		const today = new Date();
		let visibleMonth = new Date(today.getFullYear(), today.getMonth(), 1);
		let periodDates = new Set();
		let moods = {};
		let activities = {};
		const dateKey = (date) => [
			date.getFullYear(),
			String(date.getMonth() + 1).padStart(2, '0'),
			String(date.getDate()).padStart(2, '0'),
		].join('-');

		try {
			const savedData = readPeriodTrackingData(storageKey);
			periodDates = new Set(savedData.periodDates);
			moods = savedData.moods;
			activities = savedData.activities;
		} catch {
			status.textContent = calendar.dataset.loadError;
		}

		const saveDates = (message) => {
			try {
				updatePeriodTrackingData(storageKey, (data) => ({
					...data,
					periodDates: [...periodDates].sort(),
				}), calendar);
				status.textContent = message;
			} catch {
				status.textContent = calendar.dataset.saveError;
			}
		};

		const renderDays = () => {
			const year = visibleMonth.getFullYear();
			const month = visibleMonth.getMonth();
			const firstWeekday = (new Date(year, month, 1).getDay() + 6) % 7;
			const daysInMonth = new Date(year, month + 1, 0).getDate();
			const cellCount = Math.ceil((firstWeekday + daysInMonth) / 7) * 7;
			const todayKey = dateKey(today);

			monthLabel.textContent = monthFormatter.format(visibleMonth);
			daysContainer.replaceChildren();

			for (let index = 0; index < cellCount; index += 1) {
				const day = index - firstWeekday + 1;
				if (day < 1 || day > daysInMonth) {
					const blank = document.createElement('span');
					blank.className = 'period-calendar__blank';
					blank.setAttribute('aria-hidden', 'true');
					daysContainer.appendChild(blank);
					continue;
				}

				const date = new Date(year, month, day);
				const key = dateKey(date);
				const isPeriodDay = periodDates.has(key);
				const isToday = key === todayKey;
				const dayButton = document.createElement('button');
				dayButton.type = 'button';
				dayButton.className = 'period-calendar__day';
				const dayNumber = document.createElement('span');
				dayNumber.className = 'period-calendar__day-number';
				dayNumber.textContent = String(day);
				dayButton.appendChild(dayNumber);
				const mood = moods[key];
				const dayActivities = activities[key] || [];
				const labelParts = [dateFormatter.format(date)];
				if (isPeriodDay) {
					labelParts.push(calendar.dataset.periodLabel);
				}
				if (mood && periodMoodSymbols[mood]) {
					const moodMark = document.createElement('span');
					moodMark.className = 'period-calendar__mood';
					moodMark.setAttribute('aria-hidden', 'true');
					moodMark.textContent = periodMoodSymbols[mood];
					dayButton.appendChild(moodMark);
					labelParts.push(`${calendar.dataset.moodLabel}: ${calendar.dataset[`mood${mood[0].toUpperCase()}${mood.slice(1)}Label`]}`);
				}
				if (dayActivities.length > 0) {
					const activityMarks = document.createElement('span');
					activityMarks.className = 'period-calendar__activities';
					dayActivities.forEach((activity) => {
						activityMarks.appendChild(createPeriodActivityIcon(activity));
					});
					dayButton.appendChild(activityMarks);
					labelParts.push(`${calendar.dataset.activitiesLabel}: ${dayActivities.map((activity) => calendar.dataset[`activity${activity[0].toUpperCase()}${activity.slice(1)}Label`] || periodActivityLabels[activity]).join(', ')}`);
				}
				dayButton.setAttribute('aria-label', labelParts.filter(Boolean).join(', '));
				dayButton.setAttribute('aria-pressed', String(isPeriodDay));
				dayButton.classList.toggle('is-period', isPeriodDay);
				dayButton.classList.toggle('is-today', isToday);
				dayButton.addEventListener('click', () => {
					if (periodDates.has(key)) {
						periodDates.delete(key);
						dayButton.classList.remove('is-period');
						dayButton.setAttribute('aria-pressed', 'false');
						saveDates(calendar.dataset.removedMessage);
						return;
					}

					periodDates.add(key);
					dayButton.classList.add('is-period');
					dayButton.setAttribute('aria-pressed', 'true');
					saveDates(calendar.dataset.savedMessage);
				});
				daysContainer.appendChild(dayButton);
			}
		};

		previousButton?.addEventListener('click', () => {
			visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() - 1, 1);
			renderDays();
		});
		nextButton?.addEventListener('click', () => {
			visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 1);
			renderDays();
		});
		todayButton?.addEventListener('click', () => {
			visibleMonth = new Date(today.getFullYear(), today.getMonth(), 1);
			renderDays();
		});

		const refreshFromStorage = () => {
			try {
				const savedData = readPeriodTrackingData(storageKey);
				periodDates = new Set(savedData.periodDates);
				moods = savedData.moods;
				activities = savedData.activities;
				renderDays();
			} catch {
				status.textContent = calendar.dataset.loadError;
			}
		};
		window.addEventListener('projecttheme:period-data-updated', (event) => {
			if (event.detail?.storageKey === storageKey && event.detail.source !== calendar) {
				refreshFromStorage();
			}
		});
		window.addEventListener('storage', (event) => {
			if (event.key === storageKey) {
				refreshFromStorage();
			}
		});

		renderDays();
	});
}

function initializeMoodTrackers() {
	document.querySelectorAll('[data-mood-tracker]').forEach((tracker) => {
		const storageKey = tracker.dataset.storageKey;
		const status = tracker.querySelector('[data-period-entry-status]');
		const saveButton = tracker.querySelector('[data-period-entry-save]');
		const deleteButton = tracker.querySelector('[data-period-entry-delete]');
		const moodOptions = Array.from(tracker.querySelectorAll('[data-mood-choice]'));

		if (!storageKey || !status || !saveButton || !deleteButton || moodOptions.length === 0) {
			return;
		}

		const now = new Date();
		const todayKey = [
			now.getFullYear(),
			String(now.getMonth() + 1).padStart(2, '0'),
			String(now.getDate()).padStart(2, '0'),
		].join('-');
		let draft;
		try {
			draft = getPeriodTrackingDraft(storageKey, todayKey);
		} catch {
			status.textContent = tracker.dataset.loadError;
			draft = { mood: null, activities: [] };
		}

		const setSelectedMood = (mood) => {
			draft.mood = mood;
			moodOptions.forEach((option) => {
				const isSelected = option.dataset.moodChoice === draft.mood;
				option.classList.toggle('is-selected', isSelected);
				option.setAttribute('aria-pressed', String(isSelected));
			});
		};
		setSelectedMood(draft.mood);

		moodOptions.forEach((option) => {
			option.addEventListener('click', () => {
				setSelectedMood(option.dataset.moodChoice);
				status.textContent = tracker.dataset.selectedMessage;
			});
		});

		saveButton.addEventListener('click', () => {
			if ((!draft.mood || !Object.prototype.hasOwnProperty.call(periodMoodSymbols, draft.mood)) && draft.activities.length === 0) {
				status.textContent = tracker.dataset.chooseEntryMessage;
				return;
			}

			try {
				updatePeriodTrackingData(storageKey, (data) => {
					const moods = { ...data.moods };
					const activities = { ...data.activities };
					if (draft.mood && Object.prototype.hasOwnProperty.call(periodMoodSymbols, draft.mood)) {
						moods[todayKey] = draft.mood;
					} else {
						delete moods[todayKey];
					}
					if (draft.activities.length > 0) {
						activities[todayKey] = [...draft.activities];
					} else {
						delete activities[todayKey];
					}
					return { ...data, moods, activities };
				}, tracker);
				status.textContent = tracker.dataset.savedMessage;
			} catch {
				status.textContent = tracker.dataset.saveError;
			}
		});

		deleteButton.addEventListener('click', () => {
			setSelectedMood(null);
			draft.activities = [];
			document.querySelectorAll('[data-activity-tracker] [data-activity-choice]').forEach((option) => {
				option.classList.remove('is-selected');
				option.setAttribute('aria-pressed', 'false');
			});
			try {
				updatePeriodTrackingData(storageKey, (data) => {
					const moods = { ...data.moods };
					const activities = { ...data.activities };
					delete moods[todayKey];
					delete activities[todayKey];
					return { ...data, moods, activities };
				}, tracker);
				status.textContent = tracker.dataset.deletedMessage;
			} catch {
				status.textContent = tracker.dataset.saveError;
			}
		});

		const refreshFromStorage = () => {
			try {
				const data = readPeriodTrackingData(storageKey);
				draft.mood = data.moods[todayKey] || null;
				draft.activities = [...(data.activities[todayKey] || [])];
				setSelectedMood(draft.mood);
				document.querySelectorAll('[data-activity-tracker] [data-activity-choice]').forEach((option) => {
					const isSelected = draft.activities.includes(option.dataset.activityChoice);
					option.classList.toggle('is-selected', isSelected);
					option.setAttribute('aria-pressed', String(isSelected));
				});
			} catch {
				status.textContent = tracker.dataset.loadError;
			}
		};
		window.addEventListener('projecttheme:period-data-updated', (event) => {
			if (event.detail?.storageKey === storageKey && event.detail.source !== tracker) {
				refreshFromStorage();
			}
		});
		window.addEventListener('storage', (event) => {
			if (event.key === storageKey) {
				refreshFromStorage();
			}
		});
	});
}

function initializeActivityTrackers() {
	document.querySelectorAll('[data-activity-tracker]').forEach((tracker) => {
		const storageKey = tracker.dataset.storageKey;
		const status = tracker.querySelector('[data-activity-status]');
		const activityOptions = Array.from(tracker.querySelectorAll('[data-activity-choice]'));

		if (!storageKey || !status || activityOptions.length === 0) {
			return;
		}

		const now = new Date();
		const todayKey = [
			now.getFullYear(),
			String(now.getMonth() + 1).padStart(2, '0'),
			String(now.getDate()).padStart(2, '0'),
		].join('-');
		let draft;
		try {
			draft = getPeriodTrackingDraft(storageKey, todayKey);
		} catch {
			status.textContent = tracker.dataset.loadError;
			draft = { mood: null, activities: [] };
		}
		const setSelectedActivities = (activities) => {
			draft.activities = [...new Set(activities)].filter((activity) => Object.prototype.hasOwnProperty.call(periodActivityIcons, activity));
			activityOptions.forEach((option) => {
				const isSelected = draft.activities.includes(option.dataset.activityChoice);
				option.classList.toggle('is-selected', isSelected);
				option.setAttribute('aria-pressed', String(isSelected));
			});
		};

		setSelectedActivities(draft.activities);

		activityOptions.forEach((option) => {
			option.addEventListener('click', () => {
				const activity = option.dataset.activityChoice;
				if (draft.activities.includes(activity)) {
					setSelectedActivities(draft.activities.filter((value) => value !== activity));
				} else {
					setSelectedActivities([...draft.activities, activity]);
				}
				status.textContent = tracker.dataset.selectedMessage;
			});
		});

		const refreshFromStorage = () => {
			try {
				const data = readPeriodTrackingData(storageKey);
				draft.mood = data.moods[todayKey] || null;
				setSelectedActivities(data.activities[todayKey] || []);
			} catch {
				status.textContent = tracker.dataset.loadError;
			}
		};
		window.addEventListener('projecttheme:period-data-updated', (event) => {
			if (event.detail?.storageKey === storageKey && event.detail.source !== tracker) {
				refreshFromStorage();
			}
		});
		window.addEventListener('storage', (event) => {
			if (event.key === storageKey) {
				refreshFromStorage();
			}
		});
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
	initializePeriodCalendars();
	initializeMoodTrackers();
	initializeActivityTrackers();
	new General();
});
