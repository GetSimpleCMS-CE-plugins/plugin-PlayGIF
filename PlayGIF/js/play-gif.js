// GIF Animation Controller
// Usage:
// - Add class "gif-hover" for mouseover play
// - Add class "gif-click" for click-to-play with button

(function() {
	// Store original GIF sources
	const gifData = new Map();

		// Add frame styles
		const style = document.createElement('style');
		style.textContent = `
			:root {
				--red: #FF4D6B;
				--blue: #47A7EC;
				--yellow: #FFCA4D;
				--green: #42DB9F;
				--black: #333;
			}
			img.frame1red {
				border:2px solid var(--red);
				border-radius: 10px;
				box-shadow:
					-50px -50px 0 -40px var(--red),
					50px 50px 0 -40px var(--red);
			}
			img.frame1blue {
				border:2px solid var(--blue);
				border-radius: 10px;
				box-shadow:
					-50px -50px 0 -40px var(--blue),
					50px 50px 0 -40px var(--blue);
			}
			img.frame1yellow {
				border:2px solid var(--yellow);
				border-radius: 10px;
				box-shadow:
					-50px -50px 0 -40px var(--yellow),
					50px 50px 0 -40px var(--yellow);
			}
			img.frame1green {
				border:2px solid var(--green);
				border-radius: 10px;
				box-shadow:
					-50px -50px 0 -40px var(--green),
					50px 50px 0 -40px var(--green);
			}
			img.frame1black {
				border:2px solid var(--black);
				border-radius: 10px;
				box-shadow:
					-50px -50px 0 -40px var(--black),
					50px 50px 0 -40px var(--black);
			}
			
			img.frame2red {
				--s: 10px;
				padding: var(--s);
				border: calc(2*var(--s)) solid #0000;
				outline: 2px solid var(--red);
				outline-offset: calc(-1*var(--s));
				background: conic-gradient(from 90deg at 2px 2px,#0000 25%,var(--red) 0);
			}
			img.frame2blue {
				--s: 10px;
				padding: var(--s);
				border: calc(2*var(--s)) solid #0000;
				outline: 2px solid var(--blue);
				outline-offset: calc(-1*var(--s));
				background: conic-gradient(from 90deg at 2px 2px,#0000 25%,var(--blue) 0);
			}
			img.frame2yellow {
				--s: 10px;
				padding: var(--s);
				border: calc(2*var(--s)) solid #0000;
				outline: 2px solid var(--yellow);
				outline-offset: calc(-1*var(--s));
				background: conic-gradient(from 90deg at 2px 2px,#0000 25%,var(--yellow) 0);
			}
			img.frame2green {
				--s: 10px;
				padding: var(--s);
				border: calc(2*var(--s)) solid #0000;
				outline: 2px solid var(--green);
				outline-offset: calc(-1*var(--s));
				background: conic-gradient(from 90deg at 2px 2px,#0000 25%,var(--green) 0);
			}
			img.frame2black {
				--s: 10px;
				padding: var(--s);
				border: calc(2*var(--s)) solid #0000;
				outline: 2px solid var(--black);
				outline-offset: calc(-1*var(--s));
				background: conic-gradient(from 90deg at 2px 2px,#0000 25%,var(--black) 0);
			}
		`;
		document.head.appendChild(style);

	// Create a static version of the GIF (first frame)
	function createStaticVersion(img) {
		return new Promise((resolve, reject) => {
			// Create a new image to ensure we get a clean load
			const tempImg = new Image();
			tempImg.crossOrigin = "Anonymous";

			tempImg.onload = function() {
				try {
					const canvas = document.createElement('canvas');
					canvas.width = tempImg.naturalWidth || tempImg.width;
					canvas.height = tempImg.naturalHeight || tempImg.height;

					if (canvas.width === 0 || canvas.height === 0) {
						reject(new Error('Invalid image dimensions'));
						return;
					}

					const ctx = canvas.getContext('2d');
					ctx.drawImage(tempImg, 0, 0);
					resolve(canvas.toDataURL('image/png'));
				} catch (e) {
					reject(e);
				}
			};

			tempImg.onerror = function() {
				reject(new Error('Failed to load image'));
			};

			tempImg.src = img.src;
		});
	}

	// Initialize a GIF with hover functionality
	function initHoverGif(img) {
		const originalSrc = img.src;

		createStaticVersion(img).then(staticSrc => {
			gifData.set(img, {
				original: originalSrc,
				static: staticSrc
			});
			img.src = staticSrc;
		}).catch(err => {
			console.warn('Could not create static version for hover GIF:', err);
			// Fallback: just use the original GIF
			gifData.set(img, {
				original: originalSrc,
				static: originalSrc
			});
		});

		img.addEventListener('mouseenter', function() {
			const data = gifData.get(img);
			if (data) {
				img.src = data.original;
			}
		});

		img.addEventListener('mouseleave', function() {
			const data = gifData.get(img);
			if (data) {
				img.src = data.static;
			}
		});
	}

	// Initialize a GIF with click-to-play functionality
	function initClickGif(img) {
		const originalSrc = img.src;
		let playing = false;

		// Create wrapper and play button
		const wrapper = document.createElement('div');
		wrapper.style.position = 'relative';
		wrapper.style.display = 'inline-block';
		wrapper.style.cursor = 'pointer';

		const playButton = document.createElement('div');
		playButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="35px" height="35px" viewBox="0 0 28 28"><rect width="28" height="28" fill="none"/><path fill="#FF2440" d="M10.138 3.382C8.304 2.31 6 3.632 6 5.756v16.489c0 2.123 2.304 3.445 4.138 2.374l14.697-8.59c1.552-.907 1.552-3.15 0-4.057z" stroke-width="1.5" stroke="#fff"/></svg>';
		playButton.style.position = 'absolute';
		playButton.style.top = '50%';
		playButton.style.left = '50%';
		playButton.style.transform = 'translate(-50%, -50%)';
		playButton.style.background = 'rgba(0, 0, 0, 0.7)';
		playButton.style.color = 'white';
		playButton.style.width = '60px';
		playButton.style.height = '60px';
		playButton.style.borderRadius = '50%';
		playButton.style.display = 'flex';
		playButton.style.alignItems = 'center';
		playButton.style.justifyContent = 'center';
		playButton.style.fontSize = '24px';
		playButton.style.pointerEvents = 'none';
		playButton.style.transition = 'opacity 0.3s, transform 0.2s';

		// Add hover effect to wrapper
		wrapper.addEventListener('mouseenter', function() {
			if (!playing) {
				playButton.style.transform = 'translate(-50%, -50%) scale(1.1)';
			}
		});

		wrapper.addEventListener('mouseleave', function() {
			playButton.style.transform = 'translate(-50%, -50%) scale(1)';
		});

		// Wrap the image
		img.parentNode.insertBefore(wrapper, img);
		wrapper.appendChild(img);
		wrapper.appendChild(playButton);

		// Create static version
		createStaticVersion(img).then(staticSrc => {
			gifData.set(img, {
				original: originalSrc,
				static: staticSrc
			});
			img.src = staticSrc;
		}).catch(err => {
			console.warn('Could not create static version for click GIF:', err);
			// Fallback: just use the original GIF
			gifData.set(img, {
				original: originalSrc,
				static: originalSrc
			});
		});

		wrapper.addEventListener('click', function() {
			const data = gifData.get(img);
			if (!data) return;

			playing = !playing;

			if (playing) {
				img.src = data.original;
				playButton.style.opacity = '0';
			} else {
				img.src = data.static;
				playButton.style.opacity = '1';
			}
		});
	}

	// Initialize all GIFs when DOM is ready
	function init() {
		// Find all images with gif-hover class
		document.querySelectorAll('img.gif-hover').forEach(img => {
			if (img.src.toLowerCase().endsWith('.gif')) {
				initHoverGif(img);
			}
		});

		// Find all GIFs inside links with gif-hover class
		document.querySelectorAll('a.gif-hover img').forEach(img => {
			if (img.src.toLowerCase().endsWith('.gif')) {
				const link = img.closest('a.gif-hover');
				initHoverGif(img);

				// Add listeners to the link
				link.addEventListener('mouseenter', function() {
					const data = gifData.get(img);
					if (data) {
						img.src = data.original;
					}
				});
				link.addEventListener('mouseleave', function() {
					const data = gifData.get(img);
					if (data) {
						img.src = data.static;
					}
				});
			}
		});

		// Find all images with gif-click class
		document.querySelectorAll('img.gif-click').forEach(img => {
			if (img.src.toLowerCase().endsWith('.gif')) {
				initClickGif(img);
			}
		});
	}

	// Run when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();