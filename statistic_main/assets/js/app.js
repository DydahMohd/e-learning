/**
 * EAC Statistics e-Learning — Main Application
 */

let courses = [];
let activeCourse = null;
let enrolledMap = {};
let postAuthAction = null;
let courseSearchTerm = '';

const courseTranslations = {
    'Food and Nutrition Security': {
        sw: {title:'Usalama wa Chakula na Lishe', description:'Mbinu za kitakwimu kwa uchambuzi wa kilimo na usalama wa chakula katika nchi washirika wa EAC.', category:'Kilimo'},
        fr: {title:'Sécurité alimentaire et nutritionnelle', description:"Méthodes statistiques pour l'analyse de l'agriculture et de la sécurité alimentaire dans les pays partenaires de l'EAC.", category:'Agriculture'}
    },
    'Financial Sector Indicators': {
        sw: {title:'Viashiria vya Sekta ya Fedha', description:'Viashiria muhimu vya kufuatilia uthabiti na maendeleo ya sekta ya fedha katika eneo la EAC.', category:'Fedha'},
        fr: {title:'Indicateurs du secteur financier', description:"Indicateurs essentiels pour suivre la stabilité et le développement du secteur financier dans la région de l'EAC.", category:'Finance'}
    },
    'Government Finance Statistics': {
        sw: {title:'Takwimu za Fedha za Serikali', description:'Ukusanyaji na uchambuzi wa mapato, matumizi na mizania ya fedha za serikali.', category:'Fedha za Umma'},
        fr: {title:'Statistiques des finances publiques', description:'Compilation et analyse des recettes, dépenses et soldes budgétaires publics.', category:'Finances publiques'}
    },
    'Public Sector Debt Statistics': {
        sw: {title:'Takwimu za Deni la Sekta ya Umma', description:'Viwango na mbinu za kupima na kuripoti deni la sekta ya umma.', category:'Fedha za Umma'},
        fr: {title:'Statistiques de la dette du secteur public', description:'Normes et pratiques pour mesurer et déclarer la dette du secteur public.', category:'Finances publiques'}
    },
    'Monetary and Financial Statistics': {
        sw: {title:'Takwimu za Fedha na Fedha Taslimu', description:'Mfumo wa jumla ya fedha, mikopo na takwimu za masoko ya fedha.', category:'Fedha'},
        fr: {title:'Statistiques monétaires et financières', description:'Cadre pour les agrégats monétaires, le crédit et les statistiques des marchés financiers.', category:'Finance'}
    },
    'Poverty Statistics': {
        sw: {title:'Takwimu za Umaskini', description:'Mbinu za kupima umaskini, kuchambua ukosefu wa usawa na viashiria vya kijamii.', category:'Takwimu za Jamii'},
        fr: {title:'Statistiques de la pauvreté', description:"Méthodes de mesure de la pauvreté, d'analyse des inégalités et des indicateurs sociaux.", category:'Statistiques sociales'}
    },
    'External Sector Statistics': {
        sw: {title:'Takwimu za Sekta ya Nje', description:'Mizania ya malipo, nafasi ya uwekezaji wa kimataifa na takwimu za biashara.', category:'Biashara ya Kimataifa'},
        fr: {title:'Statistiques du secteur extérieur', description:'Balance des paiements, position des investissements internationaux et statistiques commerciales.', category:'Commerce international'}
    },
    'EAC Statistics Fundamentals': {
        sw: {title:'Misingi ya Takwimu za EAC', description:'Utangulizi wa dhana za takwimu, uchambuzi wa data na matumizi ya takwimu katika Jumuiya ya Afrika Mashariki.', category:'Takwimu'},
        fr: {title:"Fondamentaux des statistiques de l'EAC", description:"Introduction aux concepts statistiques, à l'analyse des données et à l'utilisation des statistiques dans la Communauté d'Afrique de l'Est.", category:'Statistiques'}
    }
};
const localizeCourse = course => {
    const lang=localStorage.getItem('language') || 'en';
    const translated=courseTranslations[course.title]?.[lang];
    return translated ? {...course, ...translated} : course;
};


async function loadCourses() {

    try {

        const result =
            await api.getAllCourses();

        courses =
            Array.isArray(result)
                ? result
                : Array.isArray(result.courses)
                    ? result.courses
                    : [];


        /*
         * Load enrolled courses only
         * when the user is authenticated.
         */

        enrolledMap = {};

        if (api.isAuthenticated()) {

            const enrolled =
                await api.getEnrolledCourses();

            const enrolledCourses =
                Array.isArray(enrolled)
                    ? enrolled
                    : Array.isArray(enrolled.courses)
                        ? enrolled.courses
                        : [];


            enrolledCourses.forEach(course => {

                enrolledMap[course.id] =
                    course;

            });

        }


        renderCourseGrid();
        renderSidebar();


        /*
         * Re-open a course requested
         * from the dashboard.
         */

        const openId =
            localStorage.getItem('openCourseId') ||
            new URLSearchParams(window.location.search).get('openCourse');


        if (openId && !document.getElementById('loginModal')?.classList.contains('show')) {

            localStorage.removeItem(
                'openCourseId'
            );

            window.history.replaceState({}, document.title, 'index.php');


            const courseId =
                Number(openId);


            if (!Number.isNaN(courseId)) {

                openCourse(courseId);

            }

        }

    } catch (error) {

        console.error(
            'Course loading error:',
            error
        );


        showToast(
            'Could not load courses. Please check the server.',
            'error'
        );

    }

}


/* =========================================================
   COURSE GRID
========================================================= */

function sortCoursesForDisplay(list) {
    return [...list].sort((a, b) =>
        String(a.title || '').localeCompare(String(b.title || ''), 'en', { sensitivity: 'base' })
    );
}

function renderCourseGrid() {

    const grid =
        document.getElementById(
            'courseGrid'
        );


    if (!grid) return;


    const visibleCourses = sortCoursesForDisplay(courses).filter(course => {
        if (!courseSearchTerm) return true;
        const localized = localizeCourse(course);
        const haystack = `${course.title||''} ${course.description||''} ${course.category||''} ${localized.title||''} ${localized.description||''} ${localized.category||''}`.toLowerCase();
        return haystack.includes(courseSearchTerm.toLowerCase());
    });

    if (!visibleCourses.length) {
        
        grid.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h3>No courses available</h3>
                <p>There are currently no courses available.</p>
            </div>
        `;
        
        return;

    }


    grid.innerHTML =
        visibleCourses.map(course => {
            const displayCourse = localizeCourse(course);

            const enrolled =
                enrolledMap[course.id];


            const progress =
                enrolled
                    ? Number(enrolled.progress || 0)
                    : 0;


            return `
                <article class="course-card">

                    <div class="course-card-header">

                        <h3 class="course-card-title">${escapeHtml(displayCourse.title || 'Untitled Course')}</h3>
</div>


                    <div class="course-card-body">
                        



                        <p>
                            ${escapeHtml(
                                displayCourse.description ||
                                'No description available.'
                            )}
                        </p>


                        <div class="course-meta">
                            
                            <span>
                                <i class="fas fa-clock"></i>
                                ${escapeHtml(
                                    localizeDuration(course.duration) ||
                                    'Self-paced'
                                )}
                            </span>

                            <span>
                                <i class="fas fa-folder"></i>
                                ${escapeHtml(
                                    displayCourse.category ||
                                    'Statistics'
                                )}
                            </span>

                        </div>


                        ${
                            enrolled
                                ? `
                                    <div class="course-progress-mini">
                                        
                                        <div class="progress-bar-inline">
                                            <div style="width:${progress}%"></div>
                                        </div>
                                        
                                        <span>
                                            ${progress}%
                                        </span>

                                    </div>
                                `
                                : ''
                        }


                        <div class="course-card-actions" style="margin-top: 1rem;">
                            
                            <button
                                class="btn btn-primary btn-sm"
                                onclick="openCourse(${Number(course.id)})"
                            >
                                <i class="fas fa-book-open"></i>
                                ${
                                    enrolled
                                        ? eacT('Continue Learning')
                                        : eacT('View Course')
                                }
                            </button>

                            
                            ${
                                enrolled
                                    ? `
                                        <button
                                            class="btn btn-outline btn-sm"
                                            disabled
                                        >
                                            <i class="fas fa-check"></i>
                                            ${eacT('Enrolled')}
                                        </button>
                                    `
                                    : `
                                        <button
                                            class="btn btn-gold btn-sm"
                                            onclick="enrollInCourse(${Number(course.id)})"
                                        >
                                            <i class="fas fa-user-plus"></i>
                                            ${eacT('Enroll')}
                                        </button>
                                    `
                            }

                        </div>

                    </div>

                </article>
            `;
            
        }).join('');

}

function filterCourses(value) {
    courseSearchTerm = String(value || '').trim();
    renderCourseGrid();
}


/* =========================================================
   SIDEBAR
========================================================= */

function renderSidebar() {

    const nav =
        document.getElementById(
            'sidebarNav'
        );


    if (!nav) return;


    if (!courses.length) {
        
        nav.innerHTML = `
            <p class="sidebar-empty">
                No courses available.
            </p>
        `;

        return;

    }


    nav.innerHTML =
        sortCoursesForDisplay(courses).map(course => {

            return `
                <button 
                    class="course-nav-item"
                    data-id="${Number(course.id)}"
                    onclick="openCourse(${Number(course.id)})"
                >

                    <span>
                        ${escapeHtml(
                            localizeCourse(course).title ||
                            'Untitled Course'
                        )}
                    </span>

                </button>
            `;
            
        }).join('');

}

function localizeDifficulty(value) {
    const lang=localStorage.getItem('language') || 'en';
    const map={Beginner:{sw:'Mwanzo',fr:'Débutant'},Intermediate:{sw:'Kati',fr:'Intermédiaire'},Advanced:{sw:'Juu',fr:'Avancé'}};
    return map[value]?.[lang] || value;
}
function localizeDuration(value) {
    const lang=localStorage.getItem('language') || 'en';
    if(!value) return value;
    return lang==='sw' ? String(value).replace(/weeks?/i,'wiki') : lang==='fr' ? String(value).replace(/weeks?/i,'semaines') : value;
}

function translateEmbeddedCourse(frame) {
    const lang = localStorage.getItem('language') || 'en';
    if (!frame?.contentDocument) return;
    const doc = frame.contentDocument;
    if (doc.documentElement) doc.documentElement.lang = lang;

    const base = {
        'Welcome':'Karibu','Overview':'Muhtasari','Introduction':'Utangulizi','Learning Objectives':'Malengo ya Kujifunza',
        'Course Modules':'Moduli za Kozi','Module':'Moduli','Assessment':'Tathmini','Resources':'Rasilimali','Download':'Pakua',
        'Next':'Inayofuata','Previous':'Iliyotangulia','Back':'Rudi','Start':'Anza','Continue':'Endelea','Complete':'Kamilisha',
        'Mark as complete':'Weka kuwa imekamilika','Quiz':'Jaribio','Submit':'Wasilisha','Results':'Matokeo','Read more':'Soma zaidi',
        'Key points':'Mambo Muhimu','Summary':'Muhtasari','References':'Marejeo','Course Catalogue':'Orodha ya Kozi',
        'Home':'Nyumbani','Modules':'Moduli','Certificate':'Cheti','Create learner account':'Fungua akaunti ya mwanafunzi',
        'Start the course →':'Anza kozi →','Course discussion':'Mjadala wa kozi'
    };
    const fr = {
        'Welcome':'Bienvenue','Overview':'Aperçu','Introduction':'Introduction','Learning Objectives':'Objectifs d’apprentissage',
        'Course Modules':'Modules du cours','Module':'Module','Assessment':'Évaluation','Resources':'Ressources','Download':'Télécharger',
        'Next':'Suivant','Previous':'Précédent','Back':'Retour','Start':'Commencer','Continue':'Continuer','Complete':'Terminer',
        'Mark as complete':'Marquer comme terminé','Quiz':'Quiz','Submit':'Soumettre','Results':'Résultats','Read more':'Lire la suite',
        'Key points':'Points clés','Summary':'Résumé','References':'Références','Course Catalogue':'Catalogue des cours',
        'Home':'Accueil','Modules':'Modules','Certificate':'Certificat','Create learner account':'Créer un compte apprenant',
        'Start the course →':'Commencer le cours →','Course discussion':'Discussion du cours'
    };
    const map = lang === 'fr' ? fr : lang === 'sw' ? base : {};
    const lookup = value => {
        const clean = String(value ?? '').trim();
        if (!clean) return value;
        if (map[clean]) return map[clean];
        if (window.eacTranslateValue) return window.eacTranslateValue(clean, lang);
        return value;
    };

    const apply = () => {
        if (!doc.body) return;
        doc.querySelectorAll('[title],[aria-label]').forEach(el => {
            if (el.hasAttribute('title')) el.setAttribute('title', lookup(el.getAttribute('title')));
            if (el.hasAttribute('aria-label')) el.setAttribute('aria-label', lookup(el.getAttribute('aria-label')));
        });
        const walker = doc.createTreeWalker(doc.body, NodeFilter.SHOW_TEXT);
        const nodes=[]; let n;
        while(n=walker.nextNode()) if(!n.parentElement?.closest('script,style,noscript')) nodes.push(n);
        nodes.forEach(node => {
            const value=node.nodeValue; const clean=value.trim(); if(!clean) return;
            const translated=lookup(clean);
            if(translated!==clean) node.nodeValue=value.replace(clean,translated);
        });
    };
    apply();

    if (!frame.__eacLanguageObserver && doc.body) {
        frame.__eacLanguageObserver = new MutationObserver(() => {
            clearTimeout(frame.__eacLanguageTimer);
            frame.__eacLanguageTimer = setTimeout(apply, 25);
        });
        frame.__eacLanguageObserver.observe(doc.body, {childList:true, subtree:true});
    }
}



/* =========================================================
   SHARED HEADER COURSE NAVIGATION
========================================================= */
function setCourseHeaderContext(enabled) {
    document.querySelectorAll('.course-context-item').forEach(item => {
        item.disabled = !enabled;
        item.setAttribute('aria-disabled', enabled ? 'false' : 'true');
    });
}

function closeCourseNavDropdown() {
    const dropdown = document.getElementById('courseNavDropdown');
    const toggle = document.getElementById('courseNavToggle');
    dropdown?.classList.remove('open');
    toggle?.setAttribute('aria-expanded', 'false');
}

function showCourseCatalogue() {
    document.body.classList.remove('course-view-active');
    const frame = document.getElementById('contentFrame');
    if (frame) {
        frame.setAttribute('src', 'about:blank');
        frame.style.height = '';
        frame.__eacContentHeight = 0;
    }
    document.getElementById('contentFrameWrap')?.classList.add('hidden');
    document.getElementById('contentToolbar')?.classList.add('hidden');
    document.getElementById('welcomePanel')?.classList.remove('hidden');
    activeCourse = null;
    window.activeCourse = null;
    window.__activeCourseId = null;
    updateMarkAllModulesReadButton();
    setCourseHeaderContext(false);
    document.querySelectorAll('.course-nav-item').forEach(item => item.classList.remove('active'));
    closeCourseNavDropdown();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function navigateActiveCourse(target) {
    const frame = document.getElementById('contentFrame');
    if (!activeCourse || !frame?.contentWindow) {
        showToast('Open a course first.', 'info');
        return;
    }

    try {
        const runtimeReady = typeof frame.contentWindow.showScreen === 'function';
        if (!runtimeReady) {
            // A fast click can happen before course.js has finished loading. Keep
            // the requested destination and execute it from the iframe onload.
            frame.__eacPendingNavigation = target;
            showToast('Course is loading. Opening it now…', 'info');
            closeCourseNavDropdown();
            return;
        }
        if (target === 'modules') {
            frame.contentWindow.showScreen('hub');
        } else if (target === 'assessment') {
            frame.contentWindow.showScreen('assessment');
        } else if (target === 'resources') {
            frame.contentWindow.showScreen('hub');
            window.setTimeout(() => {
                frame.contentDocument?.querySelector('.resources')?.scrollIntoView({behavior:'smooth', block:'start'});
                resizeEmbeddedCourse(frame);
            }, 80);
        }
        window.setTimeout(() => resizeEmbeddedCourse(frame), 120);
        scrollEmbeddedCourseToTop(frame);
    } catch (error) {
        console.warn('Course header navigation:', error);
    }
    closeCourseNavDropdown();
}

function updateMarkAllModulesReadButton() {
    const button = document.getElementById('markAllModulesReadBtn');
    if (!button) return;

    const frame = document.getElementById('contentFrame');
    let runtimeReady = false;
    try {
        runtimeReady = typeof frame?.contentWindow?.eacMarkAllModulesAsRead === 'function';
    } catch (error) {
        runtimeReady = false;
    }

    const visible = !!activeCourse && api.isAuthenticated();
    button.classList.toggle('hidden', !visible);
    button.disabled = !visible || !runtimeReady;
    button.title = runtimeReady
        ? 'Mark all modules as read and open the final assessment'
        : 'Course is loading…';
}

function updateCurrentModuleReadButton() {
    const button = document.getElementById('markCurrentModuleReadBtn');
    if (!button) return;
    const frame = document.getElementById('contentFrame');
    let runtimeReady = false;
    let completed = false;
    try {
        runtimeReady = typeof frame?.contentWindow?.eacMarkCurrentModuleAsRead === 'function'
            && !!frame.contentWindow.eacCurrentModuleId?.();
        completed = runtimeReady && !!frame.contentWindow.eacCurrentModuleIsRead?.();
    } catch (error) {
        runtimeReady = false;
    }
    const visible = !!activeCourse && runtimeReady;
    button.classList.toggle('hidden', !visible);
    button.disabled = !visible || completed;
    button.innerHTML = completed
        ? '<i class="fas fa-check" aria-hidden="true"></i> Read'
        : '<i class="fas fa-check" aria-hidden="true"></i> Mark as read';
}

function markCurrentModuleReadFromToolbar() {
    const frame = document.getElementById('contentFrame');
    try {
        if (typeof frame?.contentWindow?.eacMarkCurrentModuleAsRead !== 'function') {
            showToast('Open a module first.', 'info');
            return;
        }
        frame.contentWindow.eacMarkCurrentModuleAsRead();
        updateCurrentModuleReadButton();
        resizeEmbeddedCourse(frame);
        showToast('Module marked as read.', 'success');
    } catch (error) {
        showToast(error?.message || 'Could not mark this module as read.', 'error');
    }
}

async function markAllModulesReadFromToolbar() {
    if (!activeCourse) {
        showToast('Open a course first.', 'info');
        return;
    }
    if (!api.isAuthenticated()) {
        showToast('Please sign in before marking modules as read.', 'info');
        return;
    }

    const frame = document.getElementById('contentFrame');
    let markAll;
    try {
        markAll = frame?.contentWindow?.eacMarkAllModulesAsRead;
    } catch (error) {
        markAll = null;
    }
    if (typeof markAll !== 'function') {
        showToast('Course is still loading. Please try again in a moment.', 'info');
        return;
    }

    const button = document.getElementById('markAllModulesReadBtn');
    const originalLabel = button?.innerHTML || '';
    if (button) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Marking modules…';
    }

    try {
        await markAll();
        resizeEmbeddedCourse(frame);
        scrollEmbeddedCourseToTop(frame);
        showToast('All modules are marked as read. Final assessment is ready.', 'success');
    } catch (error) {
        showToast(error?.message || 'Could not mark the modules as read. Please try again.', 'error');
    } finally {
        if (button) button.innerHTML = originalLabel;
        updateMarkAllModulesReadButton();
    }
}

function initialiseCourseHeaderNavigation() {
    const dropdown = document.getElementById('courseNavDropdown');
    const toggle = document.getElementById('courseNavToggle');
    const home = document.getElementById('platformHomeLink');
    const currentModuleRead = document.getElementById('markCurrentModuleReadBtn');
    if (currentModuleRead && !currentModuleRead.dataset.bound) {
        currentModuleRead.dataset.bound = '1';
        currentModuleRead.addEventListener('click', markCurrentModuleReadFromToolbar);
    }
    const markAllRead = document.getElementById('markAllModulesReadBtn');
    if (markAllRead && !markAllRead.dataset.bound) {
        markAllRead.dataset.bound = '1';
        markAllRead.addEventListener('click', markAllModulesReadFromToolbar);
    }
    if (dropdown && toggle && !toggle.dataset.bound) {
        toggle.dataset.bound = '1';
        toggle.addEventListener('click', event => {
            event.preventDefault();
            const open = dropdown.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', event => {
            if (!dropdown.contains(event.target)) closeCourseNavDropdown();
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') closeCourseNavDropdown();
        });
    }
    if (home && !home.dataset.bound) {
        home.dataset.bound = '1';
        home.addEventListener('click', event => {
            if (!document.body.classList.contains('course-view-active')) return;
            event.preventDefault();
            showCourseCatalogue();
        });
    }
    document.querySelectorAll('[data-course-action]').forEach(item => {
        if (item.dataset.bound) return;
        item.dataset.bound = '1';
        item.addEventListener('click', event => {
            const action = item.dataset.courseAction;
            if (action === 'catalogue') {
                if (document.body.classList.contains('course-view-active')) {
                    event.preventDefault();
                    showCourseCatalogue();
                }
                return;
            }
            event.preventDefault();
            if (!item.disabled) navigateActiveCourse(action);
        });
    });
    setCourseHeaderContext(!!activeCourse);
}

/* =========================================================
   OPEN COURSE
========================================================= */

const MIN_EMBEDDED_COURSE_HEIGHT = 640;
const MAX_EMBEDDED_COURSE_HEIGHT = 150000;

function setEmbeddedCourseHeight(frame, rawHeight) {
    if (!frame) return;

    const requestedHeight = Math.ceil(Number(rawHeight));
    if (!Number.isFinite(requestedHeight)) return;

    const height = Math.min(
        Math.max(requestedHeight, MIN_EMBEDDED_COURSE_HEIGHT),
        MAX_EMBEDDED_COURSE_HEIGHT
    );

    if (frame.__eacContentHeight === height) return;

    frame.__eacContentHeight = height;
    frame.style.height = `${height}px`;
}

function resizeEmbeddedCourse(frame) {
    try {
        const documentInFrame = frame?.contentDocument;
        if (!documentInFrame) return;

        const root = documentInFrame.documentElement;
        const body = documentInFrame.body;
        const height = Math.max(
            root?.scrollHeight || 0,
            root?.offsetHeight || 0,
            body?.scrollHeight || 0,
            body?.offsetHeight || 0
        );

        setEmbeddedCourseHeight(frame, height);
    } catch (error) {
        // The course frame is same-origin in production. Ignore a transient load.
    }
}

function scrollEmbeddedCourseToTop(frame) {
    if (!frame) return;

    const headerHeight = document.querySelector('.site-header')?.getBoundingClientRect().height || 0;
    const frameTop = window.scrollY + frame.getBoundingClientRect().top;

    window.scrollTo({
        top: Math.max(0, Math.round(frameTop - headerHeight)),
        behavior: 'smooth'
    });
}

function openCourse(courseId) {

    const id = Number(courseId);

    // Course lessons are public. Authentication is required only for the
    // final assessment, server-backed progress and certificate issuance.

    const course =
        courses.find(
            item =>
                Number(item.id) === id
        );


    if (!course) {
        
        showToast(
            'Course not found.',
            'error'
        );

        return;

    }


    activeCourse =
        course;
    window.__activeCourseId = id;
    window.activeCourse = course;
    updateMarkAllModulesReadButton();
    // Context actions are enabled only after the embedded course runtime exists.
    setCourseHeaderContext(false);

    document.body.classList.add('course-view-active');

    document
        .getElementById('welcomePanel')
        ?.classList.add('hidden');


    document
        .getElementById('contentToolbar')
        ?.classList.remove('hidden');


    document
        .getElementById('contentFrameWrap')
        ?.classList.remove('hidden');


    const title =
        document.getElementById(
            'activeCourseTitle'
        );


    if (title) {
        
    title.textContent =
        localizeCourse(course).title || 'Course';

    }


    const frame =
        document.getElementById(
            'contentFrame'
        );


    if (frame) {
        frame.onload = async () => {
            translateEmbeddedCourse(frame);
            // The platform header owns navigation. Remove legacy in-course
            // navigation when an older course page is embedded to avoid two menus.
            try { frame.contentDocument?.querySelector('.topbar')?.remove(); } catch (error) {}
            setCourseHeaderContext(typeof frame.contentWindow?.showScreen === 'function');
            updateMarkAllModulesReadButton();
            updateCurrentModuleReadButton();
            const pendingNavigation = frame.__eacPendingNavigation;
            frame.__eacPendingNavigation = null;
            if (pendingNavigation && typeof frame.contentWindow?.showScreen === 'function') {
                navigateActiveCourse(pendingNavigation);
            }
            resizeEmbeddedCourse(frame);
            requestAnimationFrame(() => resizeEmbeddedCourse(frame));
            window.setTimeout(() => resizeEmbeddedCourse(frame), 100);
            // The iframe may finish loading after login. Always push the current
            // authentication state after the course page is fully ready.
            syncEmbeddedCourseAuth();

            // Explicitly restore the server-saved learning position. This is
            // intentionally done by the parent as well as inside the course,
            // so Dashboard -> Continue cannot fall back to the first slide.
            if (api.isAuthenticated() && frame.contentWindow) {
                try {
                    const stateResult = await api.getLearningState(id);
                    const state = stateResult?.state || null;
                    if (state?.currentPosition) {
                        frame.contentWindow.postMessage({
                            type: 'eacResume',
                            courseId: id,
                            currentPosition: state.currentPosition
                        }, window.location.origin);
                    }
                } catch (e) {
                    console.warn('Resume state load:', e);
                }
            }
        };
        const contentPath = course.contentPath || '';
        const contentVersion = Number(course.contentVersion) || Date.now();
        frame.__eacContentHeight = 0;
        setEmbeddedCourseHeight(frame, 720);
        frame.src = contentPath
            ? `${contentPath}${contentPath.includes('?') ? '&' : '?'}embed=1&v=${encodeURIComponent(String(contentVersion))}`
            : 'about:blank';
    }

    // A signed-in learner who opens a course is enrolled automatically.
    // Guests can still browse the full course; enrolment is only required to persist progress.
    if (api.isAuthenticated() && !enrolledMap[id]) {
        api.enrollCourse(id)
            .then(() => loadCourses())
            .catch(error => console.warn('Automatic enrolment:', error));
    }

    const progress =
        enrolledMap[id]?.progress || 0;


    const progressElement =
        document.getElementById(
            'courseProgress'
        );


    if (progressElement) {
        
        progressElement.style.width =
            `${Math.min(
                100,
                Math.max(
                    0,
                    Number(progress)
                )
            )}%`;

    }


    /*
     * Highlight active sidebar item.
     */

    document
        .querySelectorAll(
            '.course-nav-item'
        )
        .forEach(item => {

            item.classList.toggle(
                'active',
                Number(item.dataset.id) === id
            );

        });


    /*
     * Close mobile sidebar.
     */

    if (window.innerWidth <= 900) {
        
        document
            .getElementById('sidebar')
            ?.classList.remove('open');

        
        document
            .getElementById('mobileOverlay')
            ?.classList.remove('show');

    }


    /*
     * Update learning streak.
     */

    if (api.isAuthenticated()) {
        
        api.updateStreak()
            .catch(error => {
                console.warn(
                    'Streak update failed:',
                    error
                );
            });

    }

}


/* =========================================================
   ENROLL COURSE
========================================================= */

async function enrollInCourse(courseId) {

    const id =
        Number(courseId);


    if (!api.isAuthenticated()) {
        // The catalogue has no registration modal. Send guests to the full
        // registration form and preserve the course they intended to join.
        localStorage.setItem('pendingEnrollmentCourseId', String(id));
        window.location.href = 'register.php';
        return;

    }


    try {

        const result =
            await api.enrollCourse(id);


        if (result.success) {
            
            showToast(
                'Successfully enrolled!',
                'success'
            );


            // After successful enrollment, open the course directly.
            // We need to refresh the course list to update the UI state.
            await loadCourses(); 
            
            // Now open the course.
            openCourse(id); 
            
        } else {

            showToast(
                result.error ||
                'Enrollment could not be completed.',
                'error'
            );

        }

    } catch (error) {

        console.error(
            'Enrollment error:',
            error
        );


        showToast(
            error.message ||
            'Enrollment failed.',
            'error'
        );

    }

}



/* =========================================================
   UPDATE COURSE PROGRESS
========================================================= */

async function markProgress() {

    if (!activeCourse) {

        showToast(
            'Please open a course first.',
            'info'
        );

        return;

    }


    if (!api.isAuthenticated()) {

        postAuthAction =
            () => markProgress();

        openModal('loginModal');


        showToast(
            'Please sign in to update your progress.',
            'info'
        );


        return;

    }


    const current =
        Number(
            enrolledMap[activeCourse.id]?.progress || 0
        );


    const next =
        Math.min(
            100,
            current + 10
        );


    if (next === current) {
        
        showToast(
            'This course is already complete.',
            'info'
        );

        return;

    }


    try {

        const result =
            await api.updateProgress(
                activeCourse.id,
                next
            );


        if (!result.success) {
            
            throw new Error(
                result.error ||
                'Progress update failed.'
            );

        }


        /*
         * Update UI immediately.
         */

        const progressElement =
            document.getElementById(
                'courseProgress'
            );


        if (progressElement) {
            
            progressElement.style.width =
                `${next}%`;

        }


        /*
         * Update local enrolled map.
         */

        if (!enrolledMap[activeCourse.id]) {
            
            enrolledMap[activeCourse.id] = {
                ...activeCourse,
                progress: next
            };

        } else {

            enrolledMap[activeCourse.id].progress =
                next;

        }


        showToast(
            `Progress updated: ${next}%`,
            'success'
        );


        /*
         * Course completion.
         */

        if (next >= 100) {
            
            try {

                const certificate =
                    await api.issueCertificate(
                        activeCourse.id
                    );


                if (certificate.success) {
                    
                    showToast(
                        'Course completed! Your certificate has been issued.',
                        'success'
                    );

                }

            } catch (certificateError) {

                console.error(
                    'Certificate error:',
                    certificateError
                );

            }

        }


        renderCourseGrid();

    } catch (error) {

        console.error(
            'Progress error:',
            error
        );


        showToast(
            error.message ||
            'Could not update progress.',
            'error'
        );

    }

}



function syncEmbeddedCourseAuth(pendingScreen = null) {
    const frame = document.getElementById('contentFrame');
    if (!frame || !frame.contentWindow) return;
    try {
        if (typeof frame.contentWindow.eacSyncAuth === 'function') {
            const target = pendingScreen || frame.contentWindow.__eacPendingScreen || null;
            frame.contentWindow.__eacPendingScreen = null;
            // Pass the canonical parent-page user object as well as localStorage.
            // This removes the race where the iframe briefly renders Guest mode
            // while the authentication state is still propagating.
            frame.contentWindow.eacSyncAuth(target, api.getUser());
        }
    } catch (e) {
        console.warn('Embedded course auth sync failed:', e);
    }
}

/* =========================================================
   PASSWORD RESET
========================================================= */

async function handleForgotPassword(event) {
    event.preventDefault();

    const errorElement = document.getElementById('forgotPasswordError');
    const successElement = document.getElementById('forgotPasswordSuccess');
    const form = document.getElementById('forgotPasswordForm');
    const emailInput = document.getElementById('resetEmail');
    const submitButton = form.querySelector('button[type="submit"]');

    errorElement.style.display = 'none';
    successElement.style.display = 'none';
    submitButton.disabled = true;
    const originalButtonText = submitButton.textContent;
    submitButton.textContent = 'Sending...';

    const email = emailInput.value.trim();

    try {
        const data = await api.requestPasswordReset(email);

        if (!data.success) {
            throw new Error(data.error || 'Could not process request.');
        }

        errorElement.style.display = 'none';
        successElement.textContent = 'If an account with that email exists, a password reset link has been sent.';
        successElement.style.display = 'block';
        emailInput.value = '';

    } catch (error) {
        console.error('Password reset error:', error);
        errorElement.textContent = error.message || 'An error occurred. Please try again.';
        errorElement.style.display = 'block';
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalButtonText;
    }
}


/* =========================================================
   LOGIN
========================================================= */

async function handleLogin(event) {

    event.preventDefault();


    const errorElement =
        document.getElementById(
            'loginError'
        );


    errorElement.style.display =
        'none';
    
    const email =
        document
            .getElementById(
                'loginEmail'
            )
            .value
            .trim();


    const password =
        document
            .getElementById(
                'loginPassword'
            )
            .value;


    try {

        const data =
            await api.login(
                email,
                password
            );


        if (!data.success) {
            
            throw new Error(
                data.error ||
                'Login failed.'
            );

        }

        
        closeModal(
            'loginModal'
        );


        updateAuthUI();
        syncEmbeddedCourseAuth();


        const name =
            data.user?.fullName ||
            'User';


        showToast(
            `Welcome back, ${name.split(/\s+/)[0]}!`,
            'success'
        );


        /*
         * Continue the action that
         * required authentication.
         */

        if (
            typeof postAuthAction ===
            'function'
        ) {
            
            const action =
                postAuthAction;


            postAuthAction =
                null;


            await action();

        } else {

            await loadCourses();

        }

    } catch (error) {

        console.error(
            'Login error:',
            error
        );


        errorElement.textContent =
            error.message ||
            'Login failed.';


        errorElement.style.display =
            'block';

    }

}


/* =========================================================
   REGISTER
========================================================= */

async function handleRegister(event) {

    event.preventDefault();


    const errorElement =
        document.getElementById(
            'registerError'
        );


    errorElement.style.display =
        'none';
    

    const email =
        document
            .getElementById(
                'registerEmail'
            )
            .value
            .trim();


    const password =
        document
            .getElementById(
                'registerPassword'
            )
            .value;


    const fullName =
        document
            .getElementById(
                'fullName'
            )
            .value
            .trim();


    const organization =
        document
            .getElementById(
                'organization'
            )
            .value
            .trim();


    try {

        const data =
            await api.register(
                email,
                password,
                fullName,
                organization
            );


        if (!data.success) {
            
            throw new Error(
                data.error ||
                'Registration failed.'
            );

        }

        
        closeModal(
            'registerModal'
        );


        updateAuthUI();
        syncEmbeddedCourseAuth();


        showToast(
            'Account created successfully!',
            'success'
        );


        if (
            typeof postAuthAction ===
            'function'
        ) {
            
            const action =
                postAuthAction;


            postAuthAction =
                null;


            await action();

        } else {

            await loadCourses();

        }

    } catch (error) {

        console.error(
            'Registration error:',
            error
        );


        errorElement.textContent =
            error.message ||
            'Registration failed.';


        errorElement.style.display =
            'block';

    }

}


/* =========================================================
   SIDEBAR RESIZER
========================================================= */

let dragging = false;


document
    .getElementById(
        'sidebarResizer'
    )
    ?.addEventListener(
        'mousedown',
        () => {

            dragging = true;

            document.body.style.cursor = 
                'col-resize';

            document.body.style.userSelect = 
                'none';

        }
    );


document.addEventListener(
    'mouseup',
    () => {

        dragging = false;

        document.body.style.cursor = 
            '';

        document.body.style.userSelect = 
            '';

    }
);


document.addEventListener(
    'mousemove',
    event => {

        if (!dragging) return;


        const width =
            event.clientX; 


        if (
            width >= 200 &&
            width <= 450
        ) {

            const sidebar = 
                document.getElementById(
                    'sidebar'
                );


            if (sidebar) {

                sidebar.style.width = 
                    `${width}px`;

            }

        }

    }
);


/* =========================================================
   MOBILE SIDEBAR
========================================================= */

function updateSidebarToggleButton(expanded) {
    const button = document.getElementById('sidebarToggle');
    if (!button) return;

    const label = expanded ? 'Collapse course menu' : 'Expand course menu';
    button.setAttribute('aria-expanded', String(expanded));
    button.setAttribute('aria-label', label);
    button.setAttribute('title', label);
    button.querySelector('.sr-only').textContent = label;

    const icon = button.querySelector('i');
    icon?.classList.toggle('fa-chevron-left', expanded);
    icon?.classList.toggle('fa-chevron-right', !expanded);
}

function toggleCatalogueSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    if (window.matchMedia('(max-width: 900px)').matches) {
        toggleSidebar();
        return;
    }

    const collapsed = sidebar.classList.toggle('sidebar-collapsed');
    updateSidebarToggleButton(!collapsed);
}

document
    .getElementById('sidebarToggle')
    ?.addEventListener('click', toggleCatalogueSidebar);

updateSidebarToggleButton(!document.getElementById('sidebar')?.classList.contains('sidebar-collapsed'));

function toggleSidebar() {

    const sidebar =
        document.getElementById(
            'sidebar'
        );


    const overlay =
        document.getElementById(
            'mobileOverlay'
        );


    if (!sidebar) return;


    const open =
        sidebar.classList.toggle(
            'open'
        );


    overlay?.classList.toggle(
        'show',
        open
    );

    updateSidebarToggleButton(open);

}


document
    .getElementById(
        'menuToggle'
    )
    ?.addEventListener(
        'click',
        toggleSidebar
    );


document
    .getElementById(
        'mobileOverlay'
    )
    ?.addEventListener(
        'click',
        () => {

            document
                .getElementById('sidebar')
                ?.classList.remove('open');


            document
                .getElementById('mobileOverlay')
                ?.classList.remove('show');

            updateSidebarToggleButton(false);

        }
    );


window.addEventListener('message', event => {
    const data = event.data || {};
    // A course iframe must not be able to close/replace the catalogue while
    // the learner is entering credentials in the parent login modal.
    const loginModal = document.getElementById('loginModal');
    const loginOpen = !!loginModal && loginModal.classList.contains('show') && !loginModal.hasAttribute('hidden');
    if (loginOpen && data.type === 'eacCatalogue') return;
    if (data.type === 'eacCatalogue') {
        showCourseCatalogue();
        return;
    }
    // Only the active embedded course may control catalogue progress/UI.
    const activeFrame = document.getElementById('contentFrame');
    if (event.source !== activeFrame?.contentWindow || event.origin !== window.location.origin) return;

    if (data.type === 'eacFrameResize') {
        setEmbeddedCourseHeight(activeFrame, data.height);
        return;
    }

    if (data.type === 'eacCourseScreenChanged') {
        updateCurrentModuleReadButton();
        return;
    }

    if (data.type === 'eacScrollCourseTop') {
        requestAnimationFrame(() => scrollEmbeddedCourseToTop(activeFrame));
        return;
    }

    if (data.type === 'eacAuthRequired') {
        const target = ['hub','module','assessment','certificate'].includes(String(data.target || ''))
            ? String(data.target) : 'hub';
        postAuthAction = () => syncEmbeddedCourseAuth(target);
        openModal('loginModal');
        showToast('Please sign in before accessing course learning and assessment.', 'info');
        return;
    }

    if (data.type !== 'eacProgress') return;
    const id = Number(data.courseId), progress = Math.max(0, Math.min(100, Number(data.progress) || 0));
    if (!id) return;
    enrolledMap[id] = enrolledMap[id] || { ...(courses.find(c => Number(c.id) === id) || {}), progress };
    enrolledMap[id].progress = progress;
    if (activeCourse && Number(activeCourse.id) === id) {
        const bar = document.getElementById('courseProgress');
        if (bar) bar.style.width = `${progress}%`;
    }
    renderCourseGrid();
});

/* =========================================================
   FORMS
========================================================= */

document
    .getElementById(
        'loginForm'
    )
    ?.addEventListener(
        'submit',
        handleLogin
    );


document
    .getElementById(
        'registerForm'
    )
    ?.addEventListener(
        'submit',
        handleRegister
    );


/* =========================================================
   ESCAPE HTML
========================================================= */

function escapeHtml(value) {

    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}


/* =========================================================
   MODAL CONTROLS
========================================================= */

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    // Keep interaction inside authentication modals isolated from the
    // catalogue/iframe underneath. This is especially important on laptops
    // where autofill can emit focus/change events while credentials are typed.
    if (modalId === 'loginModal' && !modal.dataset.inputGuard) {
        modal.dataset.inputGuard = '1';
        modal.addEventListener('click', event => event.stopPropagation());
        modal.addEventListener('change', event => event.stopPropagation());
        modal.addEventListener('input', event => event.stopPropagation());
        modal.addEventListener('keydown', event => event.stopPropagation());
    }

    document.querySelectorAll('.modal-overlay.show').forEach(m => {
        m.classList.remove('show');
        m.setAttribute('hidden', '');
        m.setAttribute('aria-hidden', 'true');
    });

    modal.removeAttribute('hidden');
    modal.setAttribute('aria-hidden', 'false');
    modal.classList.add('show');
    document.body.classList.add('modal-open');

    // Focus once when the modal opens. Never re-focus while the learner
    // is typing or moving between fields with Tab.
    const first = modal.querySelector('input, button, select, textarea');
    if (first) {
        requestAnimationFrame(() => {
            if (document.activeElement !== first) {
                first.focus({ preventScroll: true });
            }
        });
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('show');
    modal.setAttribute('hidden', '');
    modal.setAttribute('aria-hidden', 'true');
    if (!document.querySelector('.modal-overlay.show')) {
        document.body.classList.remove('modal-open');
    }
}

function switchModal(fromId, toId) {
    closeModal(fromId);
    setTimeout(() => openModal(toId), 50);
}

/* =========================================================
   GLOBAL FUNCTIONS
========================================================= */

window.openCourse = 
    openCourse;

window.enrollInCourse = 
    enrollInCourse;


window.closeModal = 
    closeModal;

window.switchModal = 
    switchModal;

window.markProgress = async function () {
    if (!activeCourse) {
        showToast('Please open a course first.', 'info');
        return;
    }
    if (!api.isAuthenticated()) {
        postAuthAction = () => window.markProgress();
        openModal('loginModal');
        return;
    }

    const frame = document.getElementById('contentFrame');
    try {
        if (typeof frame?.contentWindow?.eacFlushProgress === 'function') {
            await frame.contentWindow.eacFlushProgress();
        }
        showToast('Progress is recorded automatically as you complete course modules.', 'info');
    } catch (error) {
        console.warn('Automatic progress sync:', error);
        showToast('Progress could not be synced. Please continue the course and try again.', 'error');
    }
};

/*
 * Add event listeners to close modals when clicking
 * the overlay or the close button.
 */
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (event) => {
        // Ensure we only close if clicking the overlay itself, not content within the modal
        if (event.target === overlay) {
            closeModal(overlay.id);
        }
    });
});



/* =========================================================
   START APPLICATION
========================================================= */

window.addEventListener('eac:language-applied', () => {
    if (typeof renderCourseGrid === 'function') renderCourseGrid();
    if (typeof renderSidebar === 'function') renderSidebar();
    if (activeCourse) {
        const title = document.getElementById('activeCourseTitle');
        if (title) title.textContent = localizeCourse(activeCourse).title || 'Course';
        translateEmbeddedCourse(document.getElementById('contentFrame'));
    }
});

document.addEventListener(
    'DOMContentLoaded',
    () => { 
        initialiseCourseHeaderNavigation();
        document.getElementById('courseSearch')?.addEventListener('input', event => filterCourses(event.target.value));
        loadCourses();

        const forgotPasswordModalHtml = `
<div class="modal-overlay" id="forgotPasswordModal" hidden>
    <div class="modal">
        <div class="modal-header">
            <h3>Reset password</h3>
            <button class="modal-close" onclick="closeModal('forgotPasswordModal')" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            <form id="forgotPasswordForm">
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">Enter your email address and we will send you a link to reset your password.</p>
                <div class="form-group">
                    <label for="resetEmail">Email address</label>
                    <input type="email" id="resetEmail" required autocomplete="email">
                </div>
                <div id="forgotPasswordError" class="form-error"></div>
                <div id="forgotPasswordSuccess" style="display: none; color: var(--eac-green); font-size: 0.875rem; margin-top: 1rem; padding: 0.75rem; background: var(--eac-blue-soft); border-radius: var(--radius); border: 1px solid var(--eac-green);"></div>
                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Send Reset Link</button>
            </form>
            <div class="form-footer">
                <a href="#" onclick="switchModal('forgotPasswordModal', 'loginModal'); return false;">Back to Sign In</a>
            </div>
        </div>
    </div>
</div>`;
        document.body.insertAdjacentHTML('beforeend', forgotPasswordModalHtml);
        if (typeof applyLanguage === 'function') applyLanguage();

        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            const passwordGroup = loginForm.querySelector('#loginPassword')?.closest('.form-group');
            if (passwordGroup) {
                const forgotLinkContainer = document.createElement('div');
                forgotLinkContainer.style.textAlign = 'right';
                forgotLinkContainer.style.marginTop = '-0.75rem';
                forgotLinkContainer.style.marginBottom = '1rem';
                forgotLinkContainer.innerHTML = `<a href="#" onclick="switchModal('loginModal', 'forgotPasswordModal'); return false;" style="font-size: 0.8125rem;">Forgot password?</a>`;
                passwordGroup.insertAdjacentElement('afterend', forgotLinkContainer);
            }
        }

        document.getElementById('forgotPasswordForm')?.addEventListener('submit', handleForgotPassword);

        // The language will be applied automatically by a MutationObserver in api.js
        if (typeof updateAuthUI === 'function') {
            updateAuthUI();
        }
    }
);
