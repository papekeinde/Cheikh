<script>
/*  ═══════════════════════════════════════════════════════
    ANIMATIONS — All animations powered by GSAP + ScrollTrigger
    ═══════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {
    /* ── Preloader first ── */
    initPreloader();

    /* ── Lenis smooth scroll ── */
    initLenis();

    /* ── Custom cursor ── */
    initCustomCursor();

    /* ── Core UI ── */
    initNav();
    initSmoothAnchors();
    initHeroAnimations();
    initStoryScroll();
    initFieldFilters();
    initDarkMode();
    initAproposDistortion();

    /* ── GSAP scroll animations ── */
    initGSAPScrollMorph();
    initMouseDistortion();
    initMagneticButtons();
    initScrollSkew();
    initParallaxDepth();

    /* ── Feature animations ── */
    initTiltCards();
    initSVGDraw();
    initStackBars();
    initHoverEffects();
    initScrollIndicator();
});

/* ══════════════════════════════════════════════════════
   PRELOADER
   ══════════════════════════════════════════════════════ */
function initPreloader() {
    const preloader = document.getElementById('sitePreloader');
    if (!preloader) return;

    const done = () => {
        document.body.classList.remove('is-site-loading');
        gsap.to(preloader, {
            opacity: 0,
            scale: 0.95,
            duration: 0.5,
            ease: 'power3.in',
            onComplete: () => preloader.remove()
        });
    };

    gsap.fromTo('.site-preloader-ring',
        { scale: 1, opacity: 0.3 },
        {
            scale: 1.2,
            opacity: 0.8,
            duration: 0.8,
            ease: 'sine.inOut',
            yoyo: true,
            repeat: 3,
            onComplete: done
        }
    );

    setTimeout(() => {
        if (document.body.contains(preloader)) done();
    }, 3000);
}

/* ══════════════════════════════════════════════════════
   LENIS SMOOTH SCROLL
   ══════════════════════════════════════════════════════ */
function initLenis() {
    if (typeof Lenis === 'undefined') return;

    const lenis = new Lenis({ duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);

    window.__lenis = lenis;
}

/* ══════════════════════════════════════════════════════
   CUSTOM CURSOR
   ══════════════════════════════════════════════════════ */
function initCustomCursor() {
    const dot = document.getElementById('cursorDot');
    const ring = document.getElementById('cursorRing');
    if (!dot || !ring || window.innerWidth < 1024) return;

    gsap.set([dot, ring], { opacity: 1 });

    document.addEventListener('mousemove', (e) => {
        gsap.to(dot, { x: e.clientX, y: e.clientY, duration: 0.1, ease: 'power2.out' });
        gsap.to(ring, { x: e.clientX, y: e.clientY, duration: 0.25, ease: 'power2.out' });
    });

    document.querySelectorAll('a, button, [data-hover]').forEach(el => {
        el.addEventListener('mouseenter', () => {
            gsap.to(dot, { scale: 2, duration: 0.3 });
            gsap.to(ring, { scale: 1.5, opacity: 0.5, duration: 0.3 });
        });
        el.addEventListener('mouseleave', () => {
            gsap.to(dot, { scale: 1, duration: 0.3 });
            gsap.to(ring, { scale: 1, opacity: 1, duration: 0.3 });
        });
    });
}

/* ══════════════════════════════════════════════════════
   NAVIGATION
   ══════════════════════════════════════════════════════ */
function initNav() {
    const nav = document.querySelector('[data-nav]');
    const btn = document.querySelector('[data-menu-btn]');
    const menu = document.querySelector('[data-mobile-menu]');
    if (!nav) return;

    const onScroll = () => {
        nav.classList.toggle('is-scrolled', window.scrollY > 60);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    if (btn && menu) {
        btn.addEventListener('click', () => menu.classList.toggle('is-open'));
        menu.querySelectorAll('a').forEach(a =>
            a.addEventListener('click', () => menu.classList.remove('is-open'))
        );
    }
}

/* ══════════════════════════════════════════════════════
   SMOOTH ANCHORS
   ══════════════════════════════════════════════════════ */
function initSmoothAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const id = a.getAttribute('href');
            const target = id ? document.querySelector(id) : null;
            if (!target) return;
            e.preventDefault();
            if (window.__lenis) {
                window.__lenis.scrollTo(target, { offset: -80 });
            } else {
                const y = target.getBoundingClientRect().top + window.scrollY - 80;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        });
    });
}

/* ══════════════════════════════════════════════════════
   HERO ANIMATIONS
   ══════════════════════════════════════════════════════ */
function initHeroAnimations() {
    /* Reveal buttons */
    gsap.fromTo('.pk-hero-left .reveal-item',
        { y: 40, opacity: 0 },
        { y: 0, opacity: 1, duration: 1, delay: 0.6, ease: 'expo.out' }
    );

    /* Reveal title lines */
    gsap.fromTo('.pk-hero-right .reveal-item',
        { y: 60, opacity: 0 },
        { y: 0, opacity: 1, duration: 1.2, stagger: 0.2, delay: 0.3, ease: 'expo.out' }
    );

    /* Dot grid */
    const dotGrid = document.getElementById('heroDotGrid');
    if (dotGrid) {
        for (let i = 0; i < 60; i++) {
            const span = document.createElement('span');
            dotGrid.appendChild(span);
        }
        gsap.fromTo('#heroDotGrid span',
            { scale: 0, opacity: 0 },
            { scale: 1, opacity: 0.15, duration: 0.6, stagger: { each: 0.03, from: 'center' }, ease: 'sine.out' }
        );
    }

    /* ── MORPH: Hero titre morph au scroll ── */
    gsap.to('.hero-title-bold', {
        scrollTrigger: {
            trigger: '.pk-hero',
            start: 'top top',
            end: 'bottom top',
            scrub: 1
        },
        scale: 0.85,
        opacity: 0.3,
        letterSpacing: '0.1em',
        ease: 'none'
    });

    gsap.to('.hero-title-light', {
        scrollTrigger: {
            trigger: '.pk-hero',
            start: 'top top',
            end: 'bottom top',
            scrub: 1
        },
        scale: 0.9,
        opacity: 0.2,
        letterSpacing: '0.3em',
        ease: 'none'
    });

    /* ── MORPH: Boutons disparaissent en fondu au scroll ── */
    gsap.to('.pk-hero-actions', {
        scrollTrigger: {
            trigger: '.pk-hero',
            start: '20% top',
            end: '60% top',
            scrub: 1
        },
        opacity: 0,
        y: -30,
        ease: 'none'
    });

    /* Match title widths */
    matchTitleWidths();
    window.addEventListener('resize', matchTitleWidths);
}

function matchTitleWidths() {
    const bold = document.querySelector('.hero-title-bold');
    const light = document.querySelector('.hero-title-light');
    if (!bold || !light) return;
    // On mobile (≤640px) let CSS clamp handle sizing
    if (window.innerWidth <= 640) {
        light.style.fontSize = '';
        return;
    }
    light.style.fontSize = '';
    const targetWidth = bold.scrollWidth;
    let lo = 10, hi = 200;
    for (let i = 0; i < 30; i++) {
        const mid = (lo + hi) / 2;
        light.style.fontSize = mid + 'px';
        if (light.scrollWidth < targetWidth) lo = mid;
        else hi = mid;
    }
    light.style.fontSize = lo + 'px';
}

/* ══════════════════════════════════════════════════════
   STORY SCROLL
   ══════════════════════════════════════════════════════ */
function initStoryScroll() {
    const story = document.querySelector('[data-story]');
    if (!story) return;

    const steps = Array.from(story.querySelectorAll('[data-step]'));
    const bars = Array.from(story.querySelectorAll('[data-bar]'));
    const circles = Array.from(story.querySelectorAll('.step-circle'));

    ScrollTrigger.create({
        trigger: story,
        start: 'top top',
        end: 'bottom bottom',
        onUpdate: (self) => {
            const progress = self.progress;
            const index = progress < 0.34 ? 0 : progress < 0.67 ? 1 : 2;

            steps.forEach((step, i) => step.classList.toggle('is-active', i === index));
            bars.forEach((bar, i) => {
                const width = i < index ? 100 : i === index ? ((progress - i * 0.33) / 0.33) * 100 : 0;
                bar.style.setProperty('--w', Math.max(0, Math.min(100, width)) + '%');
            });

            /* ── MORPH: Cercles SVG stroke-dashoffset au scroll ── */
            circles.forEach((circle, i) => {
                gsap.set(circle, { strokeDashoffset: i === index ? 0 : 176 });
            });
        }
    });
}

/* ══════════════════════════════════════════════════════
   FIELD FILTERS (projets)
   ══════════════════════════════════════════════════════ */
function initFieldFilters() {
    const grid = document.querySelector('[data-fields-grid]');
    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll('[data-field]'));
    const buttons = Array.from(document.querySelectorAll('[data-filter]'));
    const city = document.querySelector('[data-filter-city]');

    let currentFilter = 'all';
    let currentCity = 'all';

    const apply = () => {
        const visible = [];
        cards.forEach(card => {
            const f = card.getAttribute('data-filter-value');
            const c = card.getAttribute('data-city');
            const show = (currentFilter === 'all' || f === currentFilter)
                      && (currentCity === 'all' || c === currentCity);
            card.style.display = show ? '' : 'none';
            if (show) visible.push(card);
        });

        /* ── MORPH: Boutons filtre morph back.out avec bounce ── */
        gsap.fromTo(visible,
            { y: 16, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.6, stagger: 0.06, ease: 'back.out(1.7)' }
        );
    };

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            currentFilter = btn.getAttribute('data-filter') || 'all';
            buttons.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');

            /* Bounce animation on active button */
            gsap.fromTo(btn, { scale: 0.9 }, { scale: 1, duration: 0.4, ease: 'back.out(2)' });
            apply();
        });
    });

    if (city) {
        city.addEventListener('change', e => {
            currentCity = e.target.value || 'all';
            apply();
        });
    }
}

/* ══════════════════════════════════════════════════════
   DARK MODE
   ══════════════════════════════════════════════════════ */
function initDarkMode() {
    const toggle = document.getElementById('darkModeToggle');
    if (!toggle) return;

    const saved = localStorage.getItem('darkMode');
    if (saved === 'true') document.body.classList.add('dark-mode');

    toggle.addEventListener('click', () => {
        const isDark = document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', isDark);
        gsap.fromTo(toggle, { rotate: 0, scale: 1 }, { rotate: 360, scale: 1.15, duration: 0.5, ease: 'expo.out',
            onComplete: () => gsap.set(toggle, { scale: 1, rotate: 0 })
        });
    });
}

/* ══════════════════════════════════════════════════════
   À PROPOS DISTORTION (bizar.ro style)
   ══════════════════════════════════════════════════════ */
function initAproposDistortion() {
    const blocks = document.querySelectorAll('[data-bizar-block]');
    if (!blocks.length) return;

    blocks.forEach((block) => {
        const texts = block.querySelectorAll('[data-bizar-text]');

        gsap.fromTo(texts,
            { x: -60, opacity: 0, skewX: 6 },
            {
                x: 0,
                opacity: 1,
                skewX: 0,
                duration: 1,
                stagger: 0.12,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: block,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });

    /* Mouse RGB glitch effect */
    const section = document.querySelector('[data-bizar]');
    if (!section) return;

    section.addEventListener('mousemove', (e) => {
        const rect = section.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        const y = ((e.clientY - rect.top) / rect.height - 0.5) * 2;

        section.querySelectorAll('[data-bizar-text]').forEach(t => {
            t.style.textShadow =
                `${x * 3}px ${y * 2}px 0 rgba(255,0,0,.3), ` +
                `${-x * 3}px ${-y * 2}px 0 rgba(0,255,0,.3), ` +
                `${x * 2}px ${-y * 3}px 0 rgba(0,0,255,.3)`;
        });
    });

    section.addEventListener('mouseleave', () => {
        section.querySelectorAll('[data-bizar-text]').forEach(t => {
            gsap.to(t, { textShadow: '0 0 0 transparent', duration: 0.4 });
        });
    });
}

/* ══════════════════════════════════════════════════════
   GSAP SCROLL MORPH — Main scroll-triggered animations
   ══════════════════════════════════════════════════════ */
function initGSAPScrollMorph() {
    gsap.registerPlugin(ScrollTrigger);

    /* ── Titres de section : révélation par clip-path (droite à gauche) ── */
    document.querySelectorAll('.pk-section-head h2').forEach(h2 => {
        gsap.fromTo(h2,
            { clipPath: 'inset(0 100% 0 0)', opacity: 0 },
            {
                clipPath: 'inset(0 0% 0 0)',
                opacity: 1,
                duration: 1.2,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: h2,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });

    /* ── Kickers : glissent depuis la gauche avec skewX ── */
    document.querySelectorAll('.pk-kicker').forEach(k => {
        gsap.fromTo(k,
            { x: -40, skewX: 8, opacity: 0 },
            {
                x: 0,
                skewX: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: k,
                    start: 'top 88%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });

    /* ── Cards expertises : morph 3D (rotateX + scale) au scroll ── */
    document.querySelectorAll('.pk-sport-card').forEach((card, i) => {
        gsap.fromTo(card,
            { rotateX: 15, scale: 0.9, opacity: 0, transformPerspective: 800 },
            {
                rotateX: 0,
                scale: 1,
                opacity: 1,
                duration: 1,
                delay: i * 0.15,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });

    /* ── Cards projets : morph staggeré avec rotateY + scale ── */
    document.querySelectorAll('.pk-field-card').forEach((card, i) => {
        gsap.fromTo(card,
            { rotateY: 12, scale: 0.88, opacity: 0, transformPerspective: 600 },
            {
                rotateY: 0,
                scale: 1,
                opacity: 1,
                duration: 1,
                delay: i * 0.1,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });

    /* ── Formulaire contact : morph clip-path du bas ── */
    const form = document.querySelector('.pk-booking-form');
    if (form) {
        gsap.fromTo(form,
            { clipPath: 'inset(100% 0 0 0)', opacity: 0 },
            {
                clipPath: 'inset(0% 0 0 0)',
                opacity: 1,
                duration: 1.2,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: form,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    }

    /* ── Articles sidebar : cascade avec skewX ── */
    document.querySelectorAll('.pk-booking-side article').forEach((art, i) => {
        gsap.fromTo(art,
            { x: 60, skewX: -6, opacity: 0 },
            {
                x: 0,
                skewX: 0,
                opacity: 1,
                duration: 0.8,
                delay: i * 0.12,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: art,
                    start: 'top 88%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });

    /* ── Footer : colonnes révélées en stagger ── */
    const footerCols = document.querySelectorAll('.pk-footer-grid > div');
    if (footerCols.length) {
        gsap.fromTo(footerCols,
            { y: 40, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: '.pk-footer-grid',
                    start: 'top 88%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    }

    /* ── Lignes décoratives (gsap-morph-line) : s'étendent au scroll ── */
    document.querySelectorAll('.gsap-morph-line').forEach(line => {
        gsap.to(line, {
            width: '100%',
            duration: 1.5,
            ease: 'expo.out',
            scrollTrigger: {
                trigger: line,
                start: 'top 90%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    /* ── Reveal items generics ── */
    document.querySelectorAll('.reveal-item').forEach(item => {
        if (item.closest('.pk-hero')) return;
        gsap.fromTo(item,
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'expo.out',
                scrollTrigger: {
                    trigger: item,
                    start: 'top 88%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    });
}

/* ══════════════════════════════════════════════════════
   MOUSE DISTORTION (Canvas)
   ══════════════════════════════════════════════════════ */
function initMouseDistortion() {
    const canvas = document.getElementById('mouseDistortionCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let mouse = { x: 0, y: 0 };
    let points = [];

    const resize = () => {
        canvas.width = canvas.parentElement.offsetWidth;
        canvas.height = canvas.parentElement.offsetHeight;
        initPoints();
    };

    function initPoints() {
        points = [];
        const spacing = 40;
        for (let x = 0; x < canvas.width; x += spacing) {
            for (let y = 0; y < canvas.height; y += spacing) {
                points.push({ ox: x, oy: y, x, y });
            }
        }
    }

    canvas.parentElement.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'rgba(17,17,17,0.04)';

        points.forEach(p => {
            const dx = mouse.x - p.ox;
            const dy = mouse.y - p.oy;
            const dist = Math.sqrt(dx * dx + dy * dy);
            const force = Math.max(0, 120 - dist) / 120;

            p.x += (p.ox + dx * force * 0.3 - p.x) * 0.1;
            p.y += (p.oy + dy * force * 0.3 - p.y) * 0.1;

            const size = 2 + force * 4;
            ctx.beginPath();
            ctx.arc(p.x, p.y, size, 0, Math.PI * 2);
            ctx.fill();
        });

        requestAnimationFrame(draw);
    }

    resize();
    window.addEventListener('resize', resize);
    draw();
}

/* ══════════════════════════════════════════════════════
   MAGNETIC BUTTONS
   ══════════════════════════════════════════════════════ */
function initMagneticButtons() {
    document.querySelectorAll('[data-hover]').forEach(btn => {
        if (btn.hasAttribute('data-tilt')) return;

        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(btn, { x: x * 0.2, y: y * 0.2, duration: 0.3, ease: 'power2.out' });
        });

        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.5)' });
        });
    });
}

/* ══════════════════════════════════════════════════════
   SCROLL SKEW
   ══════════════════════════════════════════════════════ */
function initScrollSkew() {
    let lastScroll = 0;
    let velocity = 0;
    const sections = document.querySelectorAll('section');

    const onScroll = () => {
        velocity = window.scrollY - lastScroll;
        lastScroll = window.scrollY;
        const skew = Math.max(-3, Math.min(3, velocity * 0.04));
        sections.forEach(s => {
            gsap.to(s, { skewY: skew, duration: 0.3, ease: 'power2.out' });
        });
    };

    window.addEventListener('scroll', onScroll, { passive: true });

    setInterval(() => {
        if (Math.abs(velocity) > 0.1) {
            velocity *= 0.9;
        } else {
            sections.forEach(s => gsap.to(s, { skewY: 0, duration: 0.6, ease: 'power2.out' }));
        }
    }, 100);
}

/* ══════════════════════════════════════════════════════
   PARALLAX DEPTH
   ══════════════════════════════════════════════════════ */
function initParallaxDepth() {
    document.querySelectorAll('.hero-dot-grid, .pk-footer-top').forEach(el => {
        gsap.to(el, {
            y: -60,
            ease: 'none',
            scrollTrigger: {
                trigger: el.closest('section') || el.parentElement,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1
            }
        });
    });
}

/* ══════════════════════════════════════════════════════
   TILT CARDS
   ══════════════════════════════════════════════════════ */
function initTiltCards() {
    document.querySelectorAll('[data-tilt]').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            gsap.to(card, {
                rotateY: x * 12,
                rotateX: -y * 12,
                transformPerspective: 600,
                duration: 0.4,
                ease: 'power2.out'
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, { rotateY: 0, rotateX: 0, duration: 0.6, ease: 'elastic.out(1, 0.6)' });
        });
    });
}

/* ══════════════════════════════════════════════════════
   SVG DRAW — stroke-dashoffset animé au scroll
   ══════════════════════════════════════════════════════ */
function initSVGDraw() {
    document.querySelectorAll('.svg-draw-path').forEach(path => {
        const length = path.getTotalLength ? path.getTotalLength() : 200;
        gsap.set(path, { strokeDasharray: length, strokeDashoffset: length });

        gsap.to(path, {
            strokeDashoffset: 0,
            duration: 1.5,
            ease: 'expo.out',
            scrollTrigger: {
                trigger: path.closest('.pk-stack-card') || path.closest('svg'),
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            }
        });
    });
}

/* ══════════════════════════════════════════════════════
   STACK BARS — progress bars animées au scroll
   ══════════════════════════════════════════════════════ */
function initStackBars() {
    document.querySelectorAll('.pk-stack-bar').forEach(bar => {
        const progress = bar.getAttribute('data-progress') || 0;

        gsap.to(bar, {
            width: progress + '%',
            duration: 1.2,
            ease: 'expo.out',
            scrollTrigger: {
                trigger: bar.closest('.pk-stack-card'),
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            }
        });
    });
}

/* ══════════════════════════════════════════════════════
   HOVER EFFECTS
   ══════════════════════════════════════════════════════ */
function initHoverEffects() {
    document.querySelectorAll('.pk-field-card, .pk-sport-card, .pk-booking-side article').forEach(card => {
        if (card.hasAttribute('data-tilt')) return;

        card.addEventListener('mouseenter', () => {
            gsap.to(card, { y: -4, duration: 0.3, ease: 'power2.out' });
        });
        card.addEventListener('mouseleave', () => {
            gsap.to(card, { y: 0, duration: 0.4, ease: 'power2.out' });
        });
    });
}

/* ══════════════════════════════════════════════════════
   SCROLL INDICATOR
   ══════════════════════════════════════════════════════ */
function initScrollIndicator() {
    const indicator = document.getElementById('heroScrollIndicator');
    if (!indicator) return;

    gsap.to(indicator, {
        opacity: 0,
        y: -20,
        scrollTrigger: {
            trigger: '.pk-hero',
            start: '15% top',
            end: '40% top',
            scrub: 1
        }
    });
}

/* ══════════════════════════════════════════════════════
   TEXT SPLIT SCRAMBLE
   ══════════════════════════════════════════════════════ */
function textSplitScramble() {
    document.querySelectorAll('[data-scramble]').forEach(el => {
        const original = el.getAttribute('data-scramble') || el.textContent;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%';

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                observer.unobserve(el);

                let iteration = 0;
                const interval = setInterval(() => {
                    el.textContent = original
                        .split('')
                        .map((char, i) => {
                            if (i < iteration) return original[i];
                            return chars[Math.floor(Math.random() * chars.length)];
                        })
                        .join('');
                    iteration += 1 / 3;
                    if (iteration >= original.length) {
                        el.textContent = original;
                        clearInterval(interval);
                    }
                }, 30);
            });
        }, { threshold: 0.3 });

        observer.observe(el);
    });
}
</script>

