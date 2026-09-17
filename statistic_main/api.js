/**
 * EAC Statistics e-Learning
 * API Client — PHP Backend
 *
 * Handles:
 * - Authentication
 * - Courses
 * - Enrollment
 * - Progress
 * - Quizzes
 * - Achievements
 * - Streaks
 * - Certificates
 * - Dashboard analytics
 * - Leaderboard
 * - Comments
 * - Admin operations
 */


/* =========================================================
   API CONFIGURATION
========================================================= */

const API_BASE = new URL('api', window.location.href).href.replace(/\/$/, '');

const API_TIMEOUT = 15000;


/* =========================================================
   API CLIENT
========================================================= */

class EACApi {

    constructor() {

        this.token =
            localStorage.getItem('authToken');

    }


    /* =====================================================
       GENERIC REQUEST
    ===================================================== */

    async request(path, options = {}) {

        const controller =
            new AbortController();

        const timeout =
            setTimeout(
                () => controller.abort(),
                API_TIMEOUT
            );


        try {

            const headers = {
                'Accept': 'application/json',
                ...(options.headers || {})
            };


            /*
             * Only send JSON Content-Type when
             * there is a request body.
             */
            if (
                options.body &&
                !headers['Content-Type']
            ) {

                headers['Content-Type'] =
                    'application/json';

            }


            /*
             * Add authentication token.
             */
            if (this.token) {

                headers['Authorization'] =
                    `Bearer ${this.token}`;

            }


            const response =
                await fetch(
                    `${API_BASE}${path}`,
                    {
                        ...options,
                        headers,
                        signal: controller.signal
                    }
                );


            /*
             * Handle empty responses.
             */
            const contentType =
                response.headers.get(
                    'content-type'
                ) || '';


            let data = {};


            if (
                contentType.includes(
                    'application/json'
                )
            ) {

                data =
                    await response.json();

            } else {

                const text =
                    await response.text();

                data = text
                    ? { message: text }
                    : {};

            }


            /*
             * Authentication expired.
             */
            if (
                response.status === 401
            ) {

                this.clearSession();

                /*
                 * Do not immediately redirect
                 * because some pages may need
                 * to display an error first.
                 */
                throw new Error(
                    data.error ||
                    'Your session has expired. Please sign in again.'
                );

            }


            /*
             * Other API errors.
             */
            if (!response.ok) {

                throw new Error(
                    data.error ||
                    data.message ||
                    `Request failed (${response.status})`
                );

            }


            return data;

        } catch (error) {

            if (
                error.name === 'AbortError'
            ) {

                throw new Error(
                    'The request timed out. Please check your connection and try again.'
                );

            }


            throw error;

        } finally {

            clearTimeout(timeout);

        }

    }


    /* =====================================================
       AUTHENTICATION
    ===================================================== */

    async register(
        email,
        password,
        fullName,
        organization,
        profile = {}
    ) {

        const data =
            await this.request(
                '/auth/register',
                {
                    method: 'POST',

                    body: JSON.stringify({
                        email,
                        password,
                        fullName,
                        organization,
                        ...profile
                    })
                }
            );


        if (data.success) {

            this._saveSession(data);

        }


        return data;

    }


    async login(
        email,
        password
    ) {

        const data =
            await this.request(
                '/auth/login',
                {
                    method: 'POST',

                    body: JSON.stringify({
                        email,
                        password
                    })
                }
            );


        if (data.success) {

            this._saveSession(data);

        }


        return data;

    }


    _saveSession(data) {

        if (!data.token) {

            throw new Error(
                'Authentication succeeded but no token was returned.'
            );

        }


        this.token =
            data.token;


        localStorage.setItem(
            'authToken',
            data.token
        );


        if (data.user) {

            localStorage.setItem(
                'user',
                JSON.stringify(data.user)
            );

        }

    }


    clearSession() {

        this.token = null;

        localStorage.removeItem(
            'authToken'
        );

        localStorage.removeItem(
            'user'
        );

    }


    logout() {

        this.clearSession();

    }


    isAuthenticated() {

        return Boolean(
            this.token
        );

    }


    getUser() {

        try {

            const user =
                localStorage.getItem(
                    'user'
                );


            return user
                ? JSON.parse(user)
                : null;

        } catch (error) {

            console.error(
                'Unable to read stored user:',
                error
            );

            return null;

        }

    }


    /* =====================================================
       COURSES
    ===================================================== */

    getAllCourses(filters = {}) {
        const query = new URLSearchParams();
        Object.entries(filters).forEach(([key, value]) => { if (value) query.set(key, value); });
        return this.request(`/courses${query.toString() ? `?${query}` : ''}`);

    }


    getEnrolledCourses() {

        return this.request(
            '/courses/enrolled'
        );

    }


    getCourse(id) {

        return this.request(
            `/courses/${encodeURIComponent(id)}`
        );

    }


    enrollCourse(id) {

        return this.request(
            `/courses/${encodeURIComponent(id)}/enroll`,
            {
                method: 'POST'
            }
        );

    }


    updateProgress(
        id,
        progress
    ) {
        return Promise.reject(
            new Error(
                'Progress is recorded automatically when course modules are completed.'
            )
        );
    }


    /* =====================================================
       LEARNING STATE
    ===================================================== */

    getLearningState(id) {
        return this.request(`/courses/${encodeURIComponent(id)}/learning-state`);
    }

    updateLearningState(id, state) {
        return this.request(`/courses/${encodeURIComponent(id)}/learning-state`, {
            method: 'PUT',
            body: JSON.stringify(state)
        });
    }

    /* =====================================================
       QUIZZES
    ===================================================== */

    submitQuiz(
        courseId,
        quizId,
        score,
        total,
        correct
    ) {

        return this.request(
            '/quizzes/submit',
            {
                method: 'POST',

                body: JSON.stringify({
                    courseId,
                    quizId,
                    score,
                    totalQuestions: total,
                    correctAnswers: correct
                })
            }
        );

    }


    getQuizHistory() {

        return this.request(
            '/quizzes/history'
        );

    }


    /* =====================================================
       ACHIEVEMENTS
    ===================================================== */

    getAchievements() {

        return this.request(
            '/achievements'
        );

    }


    /* =====================================================
       STREAK
    ===================================================== */

    getStreak() {

        return this.request(
            '/streak'
        );

    }


    updateStreak() {

        return this.request(
            '/streak/update',
            {
                method: 'POST'
            }
        );

    }


    /* =====================================================
       CERTIFICATES
    ===================================================== */

    issueCertificate(
        courseId
    ) {

        return this.request(
            '/certificates/issue',
            {
                method: 'POST',

                body: JSON.stringify({
                    courseId
                })
            }
        );

    }


    getCertificates() {

        return this.request(
            '/certificates'
        );

    }

    async downloadCertificatePdf(certificateId) {
        const response = await fetch(
            API_BASE + '/certificates/' + encodeURIComponent(certificateId) + '/download',
            {
                headers: {
                    Accept: 'application/pdf',
                    Authorization: 'Bearer ' + (this.token || '')
                }
            }
        );
        if (!response.ok) {
            const data = await response.json().catch(() => ({}));
            throw new Error(data.error || 'Could not download certificate.');
        }
        return response.blob();
    }


    /* =====================================================
       ANALYTICS
    ===================================================== */

    getDashboardStats() {

        return this.request(
            '/analytics/dashboard'
        );

    }

    requestPasswordReset(email) { return this.request('/auth/forgot-password', { method:'POST', body:JSON.stringify({email}) }); }
    resetPassword(token, password) { return this.request('/auth/reset-password', { method:'POST', body:JSON.stringify({token,password}) }); }
    getNotifications() { return this.request('/notifications'); }
    markNotificationRead(id) { return this.request(`/notifications/${encodeURIComponent(id)}/read`, {method:'POST'}); }
    submitFeedback(courseId, rating, comment='') { return this.request('/feedback', {method:'POST', body:JSON.stringify({courseId,rating,comment})}); }
    getAdminAnalytics() { return this.request('/admin/analytics'); }


    /* =====================================================
       LEADERBOARD
    ===================================================== */

    getLeaderboard() {

        return this.request(
            '/leaderboard'
        );

    }


    getUserRank() {

        return this.request(
            '/leaderboard/rank'
        );

    }


    /* =====================================================
       COMMENTS
    ===================================================== */

    getComments(
        courseId = null
    ) {

        const query =
            courseId
                ? `?courseId=${encodeURIComponent(courseId)}`
                : '';


        return this.request(
            `/comments${query}`
        );

    }


    postComment(
        courseId,
        text,
        parentId = null
    ) {

        return this.request(
            '/comments',
            {
                method: 'POST',

                body: JSON.stringify({
                    courseId,
                    commentText: text,
                    parentId
                })
            }
        );

    }


    likeComment(
        id
    ) {

        return this.request(
            `/comments/${encodeURIComponent(id)}/like`,
            {
                method: 'POST'
            }
        );

    }


    /* =====================================================
       ADMIN
    ===================================================== */

    getAdminUsers() {

        return this.request(
            '/admin/users'
        );

    }

    getAdminLearners(search = '') {
        const query = search ? `?search=${encodeURIComponent(search)}` : '';
        return this.request(`/admin/learners${query}`);
    }

    getAdminLearner(id) {
        return this.request(`/admin/learners/${encodeURIComponent(id)}`);
    }

    getAdminAuditLogs(limit = 100) {
        return this.request(`/admin/audit-logs?limit=${encodeURIComponent(limit)}`);
    }

    getAdminFeedback() {
        return this.request('/admin/feedback');
    }

    getAdminCourses() {
        return this.request('/admin/courses');
    }

    getAdminCourse(id) {
        return this.request('/admin/courses/' + encodeURIComponent(id));
    }

    getAdminCourseOverview(id) {
        return this.request('/admin/courses/' + encodeURIComponent(id) + '/overview');
    }

    updateAdminCourseStatus(id, status) {
        return this.request('/admin/courses/' + encodeURIComponent(id) + '/status', {
            method: 'PUT',
            body: JSON.stringify({ status })
        });
    }

    getAdminCertificates(search = '') {
        const query = search ? '?search=' + encodeURIComponent(search) : '';
        return this.request('/admin/certificates' + query);
    }

    async downloadAdminLearnersCsv() {
        const response = await fetch(`${API_BASE}/admin/export/learners.csv`, {
            headers: { Accept: 'text/csv', Authorization: `Bearer ${this.token || ''}` }
        });
        if (!response.ok) throw new Error('Could not export learner report.');
        return response.blob();
    }

    async downloadAdminCertificatesCsv() {
        const response = await fetch(API_BASE + '/admin/export/certificates.csv', {
            headers: { Accept: 'text/csv', Authorization: 'Bearer ' + (this.token || '') }
        });
        if (!response.ok) throw new Error('Could not export certificate register.');
        return response.blob();
    }

    async downloadAdminCertificatePdf(certificateId) {
        const response = await fetch(
            API_BASE + '/admin/certificates/' + encodeURIComponent(certificateId) + '/download',
            {
                headers: {
                    Accept: 'application/pdf',
                    Authorization: 'Bearer ' + (this.token || '')
                }
            }
        );
        if (!response.ok) {
            const data = await response.json().catch(() => ({}));
            throw new Error(data.error || 'Could not download certificate.');
        }
        return response.blob();
    }


    updateUserRole(
        userId,
        role
    ) {

        return this.request(
            `/admin/users/${encodeURIComponent(userId)}/role`,
            {
                method: 'PUT',

                body: JSON.stringify({
                    role
                })
            }
        );

    }


    createCourse(
        courseData
    ) {

        return this.request(
            '/admin/courses',
            {
                method: 'POST',

                body: JSON.stringify(
                    courseData
                )
            }
        );

    }

    updateCourse(id, courseData) {
        return this.request(`/admin/courses/${encodeURIComponent(id)}`, { method:'PUT', body:JSON.stringify(courseData) });
    }

    deleteCourse(id, force=false) {
        return this.request(`/admin/courses/${encodeURIComponent(id)}${force?'?force=1':''}`, { method:'DELETE' });
    }

}


/* =========================================================
   GLOBAL API INSTANCE
========================================================= */

const api =
    new EACApi();


/* =========================================================
   TOAST NOTIFICATIONS
========================================================= */

function showToast(
    message,
    type = 'info'
) {

    let container =
        document.querySelector(
            '.toast-container'
        );


    if (!container) {

        container =
            document.createElement(
                'div'
            );

        container.className =
            'toast-container';

        container.setAttribute(
            'aria-live',
            'polite'
        );

        container.setAttribute(
            'aria-atomic',
            'true'
        );

        document.body.appendChild(
            container
        );

    }


    const toast =
        document.createElement(
            'div'
        );


    toast.className =
        `toast ${type}`;


    toast.textContent =
        String(message);


    container.appendChild(
        toast
    );


    setTimeout(
        () => {

            toast.remove();

        },
        3500
    );

}


/* =========================================================
   DARK MODE
========================================================= */

function applyDarkMode() {

    const dark =
        localStorage.getItem(
            'darkMode'
        ) === 'true';


    document.body.classList.toggle(
        'dark-mode',
        dark
    );


    const button =
        document.getElementById(
            'themeToggle'
        );


    if (button) {

        button.innerHTML =
            dark
                ? '<i class="fas fa-sun"></i>'
                : '<i class="fas fa-moon"></i>';


        button.setAttribute(
            'aria-pressed',
            String(dark)
        );


        button.setAttribute(
            'aria-label',
            dark
                ? 'Switch to light mode'
                : 'Switch to dark mode'
        );

    }

}


function toggleDarkMode() {

    const current =
        document.body.classList.contains(
            'dark-mode'
        );


    localStorage.setItem(
        'darkMode',
        String(!current)
    );


    applyDarkMode();

}

/* =========================================================
   LANGUAGE PREFERENCE
========================================================= */
const eacTranslations = {
    en: { courses: 'Courses', dashboard: 'Dashboard', forum: 'Forum', signIn: 'Sign In', register: 'Register', signOut: 'Sign Out' },
    sw: { courses: 'Kozi', dashboard: 'Dashibodi', forum: 'Jukwaa', signIn: 'Ingia', register: 'Jisajili', signOut: 'Toka' },
    fr: { courses: 'Cours', dashboard: 'Tableau de bord', forum: 'Forum', signIn: 'Se connecter', register: "S'inscrire", signOut: 'Se déconnecter' }
};
const eacTextTranslations = {
    'All Courses': {sw:'Kozi Zote',fr:'Tous les cours'}, 'Course Catalogue': {sw:'Orodha ya Kozi',fr:'Catalogue des cours'},
    'Community Forum': {sw:'Jukwaa la Jamii',fr:'Forum communautaire'}, 'Browse Courses': {sw:'Tazama Kozi',fr:'Parcourir les cours'},
    'Search courses': {sw:'Tafuta kozi',fr:'Rechercher des cours'}, 'Search by title, topic or category': {sw:'Tafuta kwa jina, mada au kategoria',fr:'Rechercher par titre, sujet ou catégorie'},
    'Welcome to the EAC Statistics E-Learning Portal': {sw:'Karibu kwenye Tovuti ya EAC ya Kujifunza Takwimu',fr:"Bienvenue sur le portail d'apprentissage des statistiques de l'EAC"},
    'Select a course from the sidebar to begin your learning journey, or browse available courses below.': {sw:'Chagua kozi kwenye menyu kuanza safari yako ya kujifunza, au tazama kozi zilizo hapa chini.',fr:'Sélectionnez un cours dans le menu pour commencer votre parcours, ou parcourez les cours disponibles ci-dessous.'},
    'Learning Dashboard': {sw:'Dashibodi ya Kujifunza',fr:"Tableau de bord d'apprentissage"}, 'Active Courses': {sw:'Kozi Zinazoendelea',fr:'Cours actifs'},
    'Completed': {sw:'Zilizokamilika',fr:'Terminés'}, 'Learning Streak': {sw:'Mfululizo wa Kujifunza',fr:"Série d'apprentissage"}, 'Total Points': {sw:'Jumla ya Alama',fr:'Total des points'},
    'My Enrolled Courses': {sw:'Kozi Nilizojiandikisha',fr:'Mes cours inscrits'}, 'Certificates': {sw:'Vyeti',fr:'Certificats'}, 'Community Leaderboard': {sw:'Orodha ya Washindi',fr:'Classement de la communauté'},
    'Notifications': {sw:'Arifa',fr:'Notifications'}, 'Achievements': {sw:'Mafanikio',fr:'Réalisations'}, 'Administration': {sw:'Usimamizi',fr:'Administration'},
    'Loading courses...': {sw:'Inapakia kozi...',fr:'Chargement des cours...'}, 'Loading notifications...': {sw:'Inapakia arifa...',fr:'Chargement des notifications...'},
    'No new notifications.': {sw:'Hakuna arifa mpya.',fr:'Aucune nouvelle notification.'}, 'Mark read': {sw:'Weka imesomwa',fr:'Marquer comme lu'},
    'Sign in': {sw:'Ingia',fr:'Se connecter'}, 'Sign In': {sw:'Ingia',fr:'Se connecter'}, 'Register': {sw:'Jisajili',fr:"S'inscrire"}, 'Sign Out': {sw:'Toka',fr:'Se déconnecter'}, 'Courses': {sw:'Kozi',fr:'Cours'}, 'Dashboard': {sw:'Dashibodi',fr:'Tableau de bord'}, 'Forum': {sw:'Jukwaa',fr:'Forum'}, 'Create account': {sw:'Fungua akaunti',fr:'Créer un compte'}, 'Password': {sw:'Nenosiri',fr:'Mot de passe'},
    'Email address': {sw:'Anwani ya barua pepe',fr:'Adresse e-mail'}, 'Email Address': {sw:'Anwani ya barua pepe',fr:'Adresse e-mail'}, 'Organization': {sw:'Shirika',fr:'Organisation'}, 'No courses available': {sw:'Hakuna kozi zilizopo',fr:'Aucun cours disponible'},
    'View Course': {sw:'Tazama Kozi',fr:'Voir le cours'}, 'Continue Learning': {sw:'Endelea Kujifunza',fr:'Continuer l’apprentissage'}, 'Enroll': {sw:'Jisajili',fr:"S'inscrire"}, 'Enrolled': {sw:'Umejiandikisha',fr:'Inscrit'},
    'Mark as Read': {sw:'Weka Imesomwa',fr:'Marquer comme lu'}, 'Loading your courses...': {sw:'Inapakia kozi zako...',fr:'Chargement de vos cours...'}, 'Loading certificates...': {sw:'Inapakia vyeti...',fr:'Chargement des certificats...'},
    'Loading leaderboard...': {sw:'Inapakia orodha ya washindi...',fr:'Chargement du classement...'}, 'Complete a course to earn your first certificate.': {sw:'Kamilisha kozi ili upate cheti chako cha kwanza.',fr:'Terminez un cours pour obtenir votre premier certificat.'},
    'No enrolled courses yet.': {sw:'Bado hujajiandikisha kwenye kozi.',fr:"Vous n'êtes inscrit à aucun cours."}, 'Course not found.': {sw:'Kozi haijapatikana.',fr:'Cours introuvable.'},
    'General': {sw:'Jumla',fr:'Général'}, 'Self-paced': {sw:'Kwa kasi yako',fr:'À votre rythme'}, 'Statistics': {sw:'Takwimu',fr:'Statistiques'}, 'learner': {sw:'mwanafunzi',fr:'apprenant'}, 'learners': {sw:'wanafunzi',fr:'apprenants'}
};
Object.assign(eacTextTranslations, {
    "Don't have an account?": {sw:'Huna akaunti?',fr:"Vous n’avez pas de compte ?"},
    'Course Title': {sw:'Jina la kozi',fr:'Titre du cours'},
    'Course Content': {sw:'Maudhui ya kozi',fr:'Contenu du cours'},
    'Discuss statistical methods, course content and regional data practices with the EAC learning community.': {sw:'Jadili mbinu za takwimu, maudhui ya kozi na matumizi ya data za kikanda pamoja na jumuiya ya EAC ya kujifunza.',fr:'Discutez des méthodes statistiques, du contenu des cours et des pratiques régionales en matière de données avec la communauté d’apprentissage de l’EAC.'},
    'Course discussions': {sw:'Majadiliano ya kozi',fr:'Discussions des cours'},
    'Select a course': {sw:'Chagua kozi',fr:'Sélectionnez un cours'},
    'Choose a course to view its discussion.': {sw:'Chagua kozi ili kuona mjadala wake.',fr:'Choisissez un cours pour voir sa discussion.'},
    'Post discussion': {sw:'Tuma mjadala',fr:'Publier la discussion'},
    'Share an insight, ask a question, or help another learner…': {sw:'Shiriki wazo, uliza swali, au msaidie mwanafunzi mwingine…',fr:'Partagez une idée, posez une question ou aidez un autre apprenant…'},
    'Select a course to begin.': {sw:'Chagua kozi kuanza.',fr:'Sélectionnez un cours pour commencer.'},
    'Welcome back':{sw:'Karibu tena',fr:'Bon retour'},
    'Course catalogue':{sw:'Orodha ya kozi',fr:'Catalogue des cours'},
    'Forgot password?':{sw:'Umesahau nenosiri?',fr:'Mot de passe oublie ?'},
    'Reset password':{sw:'Weka upya nenosiri',fr:'Reinitialiser le mot de passe'},
    'Create an account':{sw:'Fungua akaunti',fr:'Creer un compte'},
    'Sign in to administration':{sw:'Ingia kwenye usimamizi',fr:'Se connecter a l’administration'},
    'Open learning':{sw:'Kujifunza wazi',fr:'Apprentissage ouvert'},
    'Track progress':{sw:'Fuatilia maendeleo',fr:'Suivre les progres'},
    'EAC certificates':{sw:'Vyeti vya EAC',fr:'Certificats EAC'},
    'Enter your email address and we will send you a link to reset your password.': {sw: 'Weka anwani yako ya barua pepe na tutakutumia kiungo cha kuweka upya nenosiri lako.', fr: 'Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.'},
    'Send Reset Link': {sw: 'Tuma Kiungo cha Kuweka Upya', fr: 'Envoyer le lien de réinitialisation'},
    'Back to Sign In': {sw: 'Rudi Kuingia', fr: 'Retour à la connexion'},
    'If an account with that email exists, a password reset link has been sent.': {sw: 'Ikiwa akaunti yenye barua pepe hiyo ipo, kiungo cha kuweka upya nenosiri kimetumwa.', fr: 'Si un compte avec cet e-mail existe, un lien de réinitialisation de mot de passe a été envoyé.'},
    'I agree to the': {sw: 'Ninakubali', fr: "J'accepte les"},
    'Terms and Conditions': {sw: 'Masharti na Vigezo', fr: 'Termes et Conditions'},
    'You must agree to the Terms and Conditions to register.': {sw: 'Lazima ukubali Masharti na Vigezo ili kujisajili.', fr: 'Vous devez accepter les Termes et Conditions pour vous inscrire.'}
});
function applyLanguage(language = localStorage.getItem('language') || 'en') {
    const lang = eacTranslations[language] ? language : 'en';
    localStorage.setItem('language', lang); document.documentElement.lang = lang;
    document.querySelectorAll('[data-i18n]').forEach(el => { const key=el.dataset.i18n; if(eacTranslations[lang][key]) el.textContent=eacTranslations[lang][key]; });
    document.querySelectorAll('[data-language]').forEach(el => { el.value=lang; el.setAttribute('aria-label', lang==='fr'?'Choisir la langue':lang==='sw'?'Chagua lugha':'Choose language'); });
    const translateValue = value => {
        const clean=String(value||'').trim(); if(!clean) return value;
        for (const [source, translations] of Object.entries(eacTextTranslations)) {
            if (clean===source || Object.values(translations).includes(clean)) return translations[lang] || source;
        }
        return value;
    };
    document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach(el => { el.placeholder=translateValue(el.placeholder); });
    document.querySelectorAll('[aria-label]').forEach(el => { el.setAttribute('aria-label',translateValue(el.getAttribute('aria-label'))); });
    const walker=document.createTreeWalker(document.body,NodeFilter.SHOW_TEXT);
    const nodes=[]; let node; while(node=walker.nextNode()) { if(!node.parentElement.closest('script,style')) nodes.push(node); }
    nodes.forEach(textNode => { const value=textNode.nodeValue; const translated=translateValue(value); if(translated!==value) textNode.nodeValue=value.replace(value.trim(),translated.trim()); });
}

// Delegated handler also covers selectors injected on authentication pages.
document.addEventListener('change', event => {
    const selector = event.target.closest?.('[data-language]');
    if (!selector) return;
    localStorage.setItem('language', selector.value);
    window.location.reload();
});


/* =========================================================
   AUTHENTICATION UI
========================================================= */

function updateAuthUI() {

    const user =
        api.getUser();


    const authButton =
        document.getElementById(
            'authBtn'
        );


    const logoutButton =
        document.getElementById(
            'logoutBtn'
        );


    const userChip =
        document.getElementById(
            'userChip'
        );


    /*
     * Show/hide authentication buttons.
     */

    authButton?.classList.toggle(
        'hidden',
        Boolean(user)
    );


    logoutButton?.classList.toggle(
        'hidden',
        !user
    );


    userChip?.classList.toggle(
        'visible',
        Boolean(user)
    );


    /*
     * User information.
     */

    if (user) {

        const fullName =
            String(
                user.fullName || 'User'
            ).trim();


        const firstName =
            fullName.split(
                /\s+/
            )[0] || 'User';


        const nameElement =
            document.getElementById(
                'userName'
            );


        const avatarElement =
            document.getElementById(
                'userAvatar'
            );


        if (nameElement) {

            nameElement.textContent =
                firstName;

        }


        if (avatarElement) {

            avatarElement.textContent =
                firstName
                    .charAt(0)
                    .toUpperCase();

        }

    }


    /*
     * Authentication-required navigation.
     */

    document
        .querySelectorAll(
            '[data-auth-required]'
        )
        .forEach(element => {
            element.style.display = user ? '' : 'none';
        });

    document.querySelectorAll('[data-admin-only]').forEach(element => {
        element.style.display = user?.role === 'admin' ? '' : 'none';
    });
    document.querySelectorAll('[data-guest-only]').forEach(element => {
        element.style.display = user ? 'none' : '';
    });

}


/* =========================================================
   REQUIRE AUTHENTICATION
========================================================= */

function requireAuth() {

    if (
        !api.isAuthenticated()
    ) {

        const modal =
            document.getElementById(
                'loginModal'
            );


        if (modal) {

            modal.removeAttribute(
                'hidden'
            );

            modal.classList.add(
                'show'
            );

        }


        showToast(
            'Please sign in to continue.',
            'warning'
        );


        return false;

    }


    return true;

}


/* =========================================================
   MOBILE MENU
========================================================= */

function initializeMobileMenu() {

    const menuButton =
        document.getElementById(
            'menuToggle'
        );


    const navigation =
        document.querySelector(
            '.header-nav'
        );


    const overlay =
        document.getElementById(
            'mobileOverlay'
        );


    if (
        !menuButton ||
        !navigation
    ) {

        return;

    }


    function closeMenu() {

        navigation.classList.remove(
            'show'
        );


        overlay?.classList.remove(
            'show'
        );


        menuButton.setAttribute(
            'aria-expanded',
            'false'
        );

    }


    function toggleMenu() {

        const open =
            navigation.classList.toggle(
                'show'
            );


        overlay?.classList.toggle(
            'show',
            open
        );


        menuButton.setAttribute(
            'aria-expanded',
            String(open)
        );

    }


    menuButton.addEventListener(
        'click',
        toggleMenu
    );


    overlay?.addEventListener(
        'click',
        closeMenu
    );


    navigation
        .querySelectorAll(
            'a'
        )
        .forEach(link => {

            link.addEventListener(
                'click',
                closeMenu
            );

        });


    document.addEventListener(
        'keydown',
        event => {

            if (
                event.key === 'Escape'
            ) {

                closeMenu();

            }

        }
    );

}

/* =========================================================
   MODAL CONTROLS (Moved to app.js for centralized UI control)
========================================================= */

// These functions are now expected to be globally available from app.js
// function openModal(modalId) { /* ... */ }
// function closeModal(modalId) { /* ... */ }
// function switchModal(fromId, toId) { /* ... */ }


/* =========================================================
   LOGOUT
========================================================= */

async function handleLogout() {

    api.logout();

    updateAuthUI();
    if (typeof syncEmbeddedCourseAuth === 'function') syncEmbeddedCourseAuth();

    showToast(
        'You have been signed out. Come back soon!',
        'success'
    );


    /*
     * If the current page requires authentication,
     * return to the main application.
     */

    const protectedPage =
        document.body.dataset.authRequired ===
        'true';


    if (protectedPage) {

        window.location.href =
            'index.php';

    }

}


/* =========================================================
   INITIALIZATION
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    () => {

        if (!document.querySelector('[data-language]')) {
            const selector = document.createElement('select');
            selector.className = 'language-select language-floating';
            selector.setAttribute('data-language','');
            selector.setAttribute('aria-label','Choose language');
            selector.innerHTML = '<option value="en">EN</option><option value="sw">SW</option><option value="fr">FR</option>';
            document.body.appendChild(selector);
        }

        /*
         * Theme
         */
        applyDarkMode();
        applyLanguage();
        document.querySelectorAll('[data-language]').forEach(el => el.addEventListener('change', () => {
            localStorage.setItem('language', el.value);
            window.location.reload();
        }));
        let languageRefresh;
        new MutationObserver(() => {
            clearTimeout(languageRefresh);
            languageRefresh = setTimeout(() => applyLanguage(), 30);
        }).observe(document.body, { childList: true, subtree: true });


        /*
         * Authentication UI
         */
        updateAuthUI();


        /*
         * Theme button
         */
        document
            .getElementById(
                'themeToggle'
            )
            ?.addEventListener(
                'click',
                toggleDarkMode
            );


        /*
         * Sign in
         */
        document
            .getElementById(
                'authBtn'
            )
            ?.addEventListener(
                'click',
                () => openModal('loginModal') // Call the global openModal
            );


        /*
         * Sign out
         */
        document
            .getElementById(
                'logoutBtn'
            )
            ?.addEventListener(
                'click',
                handleLogout
            );


        /*
         * Mobile menu
         */
        // initializeMobileMenu(); // Handled by app.js

    }
);
