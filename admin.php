<?php
declare(strict_types=1);
$questionBankCourses = [];
try {
    require_once __DIR__ . '/api/config.php';
    require_once __DIR__ . '/api/Database.php';
    $questionBankCourses = Database::connect()->query('SELECT id,title FROM courses ORDER BY title')->fetchAll();
} catch (Throwable $error) {
    error_log('Could not preload question-bank courses: ' . $error->getMessage());
}
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration &mdash; EAC Statistics e-Learning</title>
    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>
    <link rel="stylesheet" href="assets/css/main.css?v=<?= (int) filemtime(__DIR__ . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="assets/css/pages/admin.css?v=<?= (int) filemtime(__DIR__ . '/assets/css/pages/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body data-auth-required="true">
<?php $basePath = ''; $activePage = 'admin'; $headerVariant = 'standard'; include __DIR__ . '/includes/header.php'; ?>

<main class="admin-page">
    <div class="admin-head">
        <div>
            <h1>Administration</h1>
            <p>Manage learner access, courses, certificates, and platform activity.</p>
        </div>
        <a class="btn btn-outline" href="index.php"><i class="fas fa-arrow-left"></i> Return to portal</a>
    </div>

    <div class="admin-grid">
        <section class="admin-panel">
            <h2><i class="fas fa-users"></i> Registered users</h2>
            <div class="admin-panel-body">
                <div class="admin-table-wrap" id="userList">Loading users&hellip;</div>
            </div>
        </section>

        <section class="admin-panel">
            <h2><i class="fas fa-book-open"></i> Course catalogue</h2>
            <div class="admin-panel-body">
                <div class="admin-toolbar">
                    <select id="courseStatusFilter" aria-label="Filter courses by status">
                        <option value="">All statuses</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                    <input id="courseSearch" type="search" placeholder="Search courses" aria-label="Search courses">
                </div>
                <div class="course-list" id="courseList">Loading courses&hellip;</div>
            </div>
        </section>

        <section class="admin-panel">
            <h2><i class="fas fa-pen-to-square"></i> Add or edit a course</h2>
            <div class="admin-panel-body">
                <form id="courseForm">
                    <div class="form-grid">
                        <div class="full">
                            <label for="courseTitle">Course title</label>
                            <input id="courseTitle" required>
                        </div>
                        <div>
                            <label for="courseCategory">Category</label>
                            <input id="courseCategory" required>
                        </div>
                        <!-- Difficulty is temporarily hidden from course administration.
                        <div>
                            <label for="courseDifficulty">Difficulty</label>
                            <select id="courseDifficulty">
                                <option>Beginner</option>
                                <option selected>Intermediate</option>
                                <option>Advanced</option>
                            </select>
                        </div>
                        -->
                        <div>
                            <label for="courseDuration">Duration</label>
                            <input id="courseDuration" placeholder="4 weeks">
                        </div>
                        <div>
                            <label for="courseStatus">Publishing status</label>
                            <select id="courseStatus">
                                <option value="draft" selected>Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <div class="full">
                            <label for="courseDescription">Description</label>
                            <textarea id="courseDescription" rows="3"></textarea>
                        </div>
                        <div class="full">
                            <label for="courseContentUpload">Course content</label>
                            <input id="courseContentUpload" type="file" multiple accept=".html,.htm,.txt,text/html,text/plain">
                            <p class="admin-muted">For a new course, upload one HTML/text file per module. Select multiple files together in module order. PHP files are not accepted.</p>
                            <input id="courseContentPath" type="hidden">
                        </div>
                    </div>
                    <div class="admin-message" id="courseMessage"></div>
                    <button class="btn btn-primary admin-form-action" type="submit">Create course</button>
                </form>
            </div>
        </section>

        <section class="admin-panel">
            <h2><i class="fas fa-circle-info"></i> Course status guide</h2>
            <div class="admin-panel-body">
                <ul class="admin-guide">
                    <li><strong>Draft:</strong> visible only in this administration panel.</li>
                    <li><strong>Published:</strong> listed in the learner catalogue and available to study.</li>
                    <li><strong>Archived:</strong> retained in records but unavailable from the learner catalogue.</li>
                </ul>
                <p class="admin-muted">New courses start as Draft, so incomplete content is never published by accident.</p>
            </div>
        </section>
    </div>

    <section class="admin-panel admin-wide" id="courseOverviewPanel" hidden>
        <h2><i class="fas fa-list-check"></i> Course content overview</h2>
        <div class="admin-panel-body" id="courseOverview" aria-live="polite"></div>
    </section>

    <section class="admin-panel admin-wide" id="questionBankPanel">
        <h2><i class="fas fa-circle-question"></i> Quiz &amp; final assessment question bank</h2>
        <div class="admin-panel-body">
            <div class="admin-toolbar">
                <select id="questionCourse">
                    <option value="">Select course</option>
                    <?php foreach ($questionBankCourses as $questionBankCourse): ?>
                        <option value="<?= (int)$questionBankCourse['id'] ?>"><?= htmlspecialchars((string)$questionBankCourse['title'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="questionType"><option value="module_quiz">Module quiz</option><option value="final">Final assessment</option></select>
                <button class="btn btn-outline" id="loadQuestions" type="button">Load questions</button>
            </div>
            <form id="questionForm" class="question-form">
                <input type="hidden" id="questionId">
                <div class="form-grid">
                    <div><label for="questionModule">Module ID</label><input id="questionModule" placeholder="e.g. m1"></div>
                    <div><label for="questionKey">Quiz mount key</label><input id="questionKey" placeholder="e.g. q1"></div>
                    <div class="full"><label for="questionTitle">Quiz title</label><input id="questionTitle" placeholder="Knowledge Check"></div>
                    <div class="full"><label for="questionText">Question</label><textarea id="questionText" rows="3" required></textarea></div>
                    <div class="full"><label for="questionExplanation">Explanation / feedback</label><textarea id="questionExplanation" rows="2"></textarea></div>
                </div>
                <fieldset class="question-options"><legend>Answer options (select the correct answer)</legend><div id="questionOptions"></div><button type="button" class="btn btn-outline btn-sm" id="addQuestionOption">Add option</button></fieldset>
                <div class="question-form-actions"><button class="btn btn-primary" type="submit">Save question</button><button class="btn btn-outline" id="cancelQuestionEdit" type="button">Clear</button></div>
            </form>
            <form id="assessmentSettings" class="assessment-settings" hidden>
                <strong>Final assessment settings</strong>
                <label>Questions per attempt <input id="settingsAsk" type="number" min="1" max="200" value="20"></label>
                <label>Pass mark (%) <input id="settingsPass" type="number" min="0" max="100" step="0.01" value="80"></label>
                <label>Minutes <input id="settingsMinutes" type="number" min="1" max="480" value="20"></label>
                <button class="btn btn-outline btn-sm" type="submit">Save settings</button>
            </form>
            <div id="questionMessage" class="admin-message"></div>
            <div id="questionList" class="question-bank-list"><p class="admin-muted">Select a course to manage its questions.</p></div>
        </div>
    </section>

    <section class="admin-panel admin-wide">
        <h2><i class="fas fa-chart-line"></i> Platform analytics</h2>
        <div class="admin-panel-body" id="adminAnalytics">Loading reports&hellip;</div>
    </section>

    <section class="admin-panel admin-wide">
        <h2><i class="fas fa-user-graduate"></i> Learner management</h2>
        <div class="admin-panel-body">
            <div class="admin-toolbar">
                <input id="learnerSearch" type="search" placeholder="Search name, email, organisation, or country">
                <button class="btn btn-outline" id="exportLearners" type="button"><i class="fas fa-file-csv"></i> Export CSV</button>
            </div>
            <div class="admin-table-wrap" id="learnerList">Loading learners&hellip;</div>
            <div id="learnerDetail" class="admin-detail"></div>
        </div>
    </section>

    <section class="admin-panel admin-wide">
        <h2><i class="fas fa-certificate"></i> Certificate register</h2>
        <div class="admin-panel-body">
            <div class="admin-toolbar">
                <input id="certificateSearch" type="search" placeholder="Search certificate number, learner, email, or course">
                <button class="btn btn-outline" id="exportCertificates" type="button"><i class="fas fa-file-csv"></i> Export CSV</button>
            </div>
            <div class="admin-table-wrap" id="certificateList">Loading certificates&hellip;</div>
        </div>
    </section>

    <section class="admin-panel admin-wide">
        <h2><i class="fas fa-star"></i> Course comments and ratings</h2>
        <div class="admin-panel-body">
            <div class="admin-table-wrap" id="feedbackList">Loading comments&hellip;</div>
        </div>
    </section>

    <section class="admin-panel admin-wide admin-last-panel">
        <h2><i class="fas fa-clock-rotate-left"></i> Recent activity</h2>
        <div class="admin-panel-body">
            <div class="admin-table-wrap" id="auditList">Loading activity&hellip;</div>
        </div>
    </section>
</main>

<script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>
<script>
(function () {
    'use strict';

    var courseForm = document.getElementById('courseForm');
    var loadedCourses = [];
    var loadedQuestions = [];

    // Quiz fields are created and edited dynamically, so guard the whole admin
    // page against page-level keyboard shortcuts while an input has focus.
    function keepTypingInsideAdminForm(event) {
        var field = event.target;
        if (!field || !field.matches || !field.matches('input, textarea, select')) return;
        if (event.key === ' ' || event.code === 'Space') event.stopPropagation();
    }
    document.querySelector('.admin-page').addEventListener('keydown', keepTypingInsideAdminForm);
    document.querySelector('.admin-page').addEventListener('keypress', keepTypingInsideAdminForm);

    function esc(value) {
        var node = document.createElement('div');
        node.textContent = value === null || value === undefined ? '' : String(value);
        return node.innerHTML;
    }

    function normaliseStatus(value) {
        var status = String(value || 'draft').toLowerCase();
        return ['draft', 'published', 'archived'].indexOf(status) >= 0 ? status : 'draft';
    }

    function statusLabel(value) {
        var status = normaliseStatus(value);
        return status.charAt(0).toUpperCase() + status.slice(1);
    }

    function statusPill(value) {
        var status = normaliseStatus(value);
        return '<span class="status-pill status-' + status + '">' + statusLabel(status) + '</span>';
    }

    function statusOptions(selected) {
        var status = normaliseStatus(selected);
        return ['draft', 'published', 'archived'].map(function (value) {
            return '<option value="' + value + '"' + (value === status ? ' selected' : '') + '>' + statusLabel(value) + '</option>';
        }).join('');
    }

    function dateText(value) {
        if (!value) return '&mdash;';
        var date = new Date(String(value).replace(' ', 'T'));
        return Number.isNaN(date.getTime()) ? esc(value) : esc(date.toLocaleString());
    }

    function errorMessage(error, fallback) {
        return error && error.message ? error.message : fallback;
    }

    function downloadBlob(blob, filename) {
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.setTimeout(function () {
            URL.revokeObjectURL(link.href);
        }, 1000);
    }

    function certificateFilename(number) {
        var safe = String(number || 'certificate')
            .replace(/[^a-z0-9._-]+/gi, '_')
            .replace(/^_+|_+$/g, '');
        return 'EAC_Certificate_' + (safe || 'certificate') + '.pdf';
    }

    async function guard() {
        var user = api.getUser();
        if (!api.isAuthenticated() || !user || user.role !== 'admin') {
            location.href = 'admin-login.php';
            return false;
        }
        var name = (user.fullName || 'Admin').split(/\s+/)[0];
        var nameNode = document.getElementById('userName');
        var avatarNode = document.getElementById('userAvatar');
        if (nameNode) nameNode.textContent = name;
        if (avatarNode) avatarNode.textContent = name.charAt(0).toUpperCase();
        return true;
    }

    async function loadUsers() {
        var users = await api.getAdminUsers();
        var currentUserId = Number((api.getUser() || {}).id);
        var rows = users.map(function (user) {
            var id = Number(user.id);
            var action = id === currentUserId
                ? 'Current account'
                : '<select id="role-' + id + '">' +
                    '<option value="student"' + (user.role === 'student' ? ' selected' : '') + '>Student</option>' +
                    '<option value="instructor"' + (user.role === 'instructor' ? ' selected' : '') + '>Instructor</option>' +
                    '<option value="admin"' + (user.role === 'admin' ? ' selected' : '') + '>Admin</option>' +
                  '</select> <button class="btn btn-primary btn-sm" type="button" onclick="window.eacUpdateRole(' + id + ')">Save</button>';
            return '<tr>' +
                '<td><strong>' + esc(user.fullName) + '</strong></td>' +
                '<td>' + esc(user.email) + '</td>' +
                '<td><span class="role-pill ' + esc(user.role) + '">' + esc(user.role) + '</span></td>' +
                '<td>' + (user.organization ? esc(user.organization) : '&mdash;') + '</td>' +
                '<td>' + (user.sector ? esc(user.sector) : '&mdash;') + '</td>' +
                '<td>' + (user.country ? esc(user.country) : '&mdash;') + '</td>' +
                '<td>' + (user.jobTitle ? esc(user.jobTitle) : '&mdash;') + '</td>' +
                '<td>' + dateText(user.createdAt) + '</td>' +
                '<td>' + action + '</td>' +
            '</tr>';
        }).join('');
        document.getElementById('userList').innerHTML =
            '<table class="admin-table"><thead><tr>' +
            '<th>Name</th><th>Email</th><th>Role</th><th>Organisation</th><th>Sector</th><th>Country</th><th>Job title</th><th>Registered</th><th></th>' +
            '</tr></thead><tbody>' + rows + '</tbody></table>';
    }

    function filteredCourses() {
        var status = document.getElementById('courseStatusFilter').value;
        var query = document.getElementById('courseSearch').value.trim().toLowerCase();
        return loadedCourses.filter(function (course) {
            var matchesStatus = !status || normaliseStatus(course.status) === status;
            var searchable = [course.title, course.category, course.difficulty, course.description].join(' ').toLowerCase();
            return matchesStatus && (!query || searchable.indexOf(query) >= 0);
        });
    }

    function renderCourses() {
        var courses = filteredCourses();
        var list = document.getElementById('courseList');
        if (!courses.length) {
            list.innerHTML = '<p class="admin-muted">No courses match this filter.</p>';
            return;
        }
        list.innerHTML = courses.map(function (course) {
            var id = Number(course.id);
            return '<article class="course-row">' +
                '<div class="course-row-main">' +
                    '<strong>' + esc(course.title) + '</strong>' +
                    '<small>' + esc(course.category || 'Statistics') + ' &middot; ' + esc(course.difficulty || 'General') + ' &middot; ' + esc(course.duration || 'Self-paced') + '</small>' +
                '</div>' +
                '<div class="course-row-status">' +
                    statusPill(course.status) +
                    '<span class="role-pill">' + Number(course.studentCount || 0) + ' learners</span>' +
                '</div>' +
                '<div class="course-row-actions">' +
                    '<select id="course-status-' + id + '" aria-label="Status for ' + esc(course.title) + '">' + statusOptions(course.status) + '</select>' +
                    '<button class="btn btn-outline btn-sm" type="button" onclick="window.eacSaveCourseStatus(' + id + ')">Save status</button>' +
                    '<button class="btn btn-outline btn-sm" type="button" onclick="window.eacShowCourseOverview(' + id + ')">Overview</button>' +
                    '<button class="btn btn-outline btn-sm" type="button" onclick="window.eacEditCourse(' + id + ')">Edit</button>' +
                    '<button class="btn btn-sm btn-danger" type="button" data-delete-course="' + id + '" data-course-title="' + esc(course.title) + '">Delete</button>' +
                '</div>' +
            '</article>';
        }).join('');
        list.querySelectorAll('[data-delete-course]').forEach(function (button) {
            button.addEventListener('click', function () {
                removeCourse(Number(button.dataset.deleteCourse), button.dataset.courseTitle || 'this course');
            });
        });
    }

    async function loadCourses() {
        var result = await api.getAdminCourses();
        loadedCourses = result.courses || result || [];
        renderCourses();
        var questionCourse = document.getElementById('questionCourse');
        var selected = questionCourse.value;
        questionCourse.innerHTML = '<option value="">Select course</option>' + loadedCourses.map(function(course){ return '<option value="' + Number(course.id) + '">' + esc(course.title) + '</option>'; }).join('');
        questionCourse.value = selected;
    }

    function addQuestionOption(value, correct) {
        var host = document.getElementById('questionOptions');
        var row = document.createElement('div'); row.className = 'question-option-row';
        row.innerHTML = '<label class="correct-answer-choice"><input type="radio" name="correctOption" aria-label="Correct answer"> <span>Correct answer</span></label>' +
            '<input class="question-option-text" placeholder="Answer option" value="' + esc(value || '') + '">' +
            '<button class="btn btn-danger btn-sm" type="button" aria-label="Remove option">Remove</button>';
        row.querySelector('input[type="radio"]').checked = !!correct;
        row.querySelector('button').addEventListener('click', function(){ if(host.children.length > 2) row.remove(); });
        host.appendChild(row);
    }

    function resetQuestionForm() {
        document.getElementById('questionId').value = '';
        ['questionModule','questionKey','questionTitle','questionText','questionExplanation'].forEach(function(id){ document.getElementById(id).value=''; });
        document.getElementById('questionOptions').innerHTML='';
        addQuestionOption('', true); addQuestionOption('', false); addQuestionOption('', false); addQuestionOption('', false);
    }

    function questionPayload() {
        var rows = Array.from(document.querySelectorAll('.question-option-row'));
        return {questionType:document.getElementById('questionType').value,moduleId:document.getElementById('questionModule').value,quizKey:document.getElementById('questionKey').value,title:document.getElementById('questionTitle').value,questionText:document.getElementById('questionText').value,explanation:document.getElementById('questionExplanation').value,options:rows.map(function(row){return {text:row.querySelector('.question-option-text').value,correct:row.querySelector('input[type="radio"]').checked};})};
    }

    function renderQuestionBank() {
        var host=document.getElementById('questionList');
        if(!loadedQuestions.length){host.innerHTML='<p class="admin-muted">No database questions for this selection.</p>';return;}
        host.innerHTML=loadedQuestions.map(function(q){return '<article class="question-bank-item"><div><span class="role-pill">'+esc(q.questionType)+'</span> <small>'+esc(q.moduleId||'All modules')+'</small><strong>'+esc(q.q)+'</strong><small>'+q.options.length+' options &middot; '+(q.quizKey?'Mount: '+esc(q.quizKey):'No mount key')+'</small></div><div><button class="btn btn-outline btn-sm" data-edit-question="'+Number(q.id)+'">Edit</button> <button class="btn btn-danger btn-sm" data-delete-question="'+Number(q.id)+'">Delete</button></div></article>';}).join('');
        host.querySelectorAll('[data-edit-question]').forEach(function(button){button.addEventListener('click',function(){editQuestion(Number(button.dataset.editQuestion));});});
        host.querySelectorAll('[data-delete-question]').forEach(function(button){button.addEventListener('click',function(){deleteQuestion(Number(button.dataset.deleteQuestion));});});
    }

    async function loadQuestionBank() {
        var cid=Number(document.getElementById('questionCourse').value); if(!cid){showToast('Select a course first.','error');return;}
        var type=document.getElementById('questionType').value;
        var result=await api.getAdminQuestions(cid,type); loadedQuestions=result.questions||[]; renderQuestionBank();
        var settings=document.getElementById('assessmentSettings'); settings.hidden=type!=='final';
        if(type==='final'){var sr=await api.getAssessmentSettings(cid);var s=sr.settings||{};document.getElementById('settingsAsk').value=s.questionsPerAttempt||20;document.getElementById('settingsPass').value=s.passMark||80;document.getElementById('settingsMinutes').value=s.minutes||20;}
    }

    function editQuestion(id) {
        var q=loadedQuestions.find(function(item){return Number(item.id)===id;}); if(!q)return;
        document.getElementById('questionId').value=id;document.getElementById('questionModule').value=q.moduleId||'';document.getElementById('questionKey').value=q.quizKey||'';document.getElementById('questionTitle').value=q.title||'';document.getElementById('questionText').value=q.q||'';document.getElementById('questionExplanation').value=q.explain||'';
        document.getElementById('questionOptions').innerHTML='';q.options.forEach(function(o){addQuestionOption(o.text,!!o.correct);});document.getElementById('questionForm').scrollIntoView({behavior:'smooth',block:'center'});
    }

    async function deleteQuestion(id) { if(!confirm('Delete this question?'))return;try{await api.deleteAdminQuestion(id);showToast('Question deleted.','success');await loadQuestionBank();}catch(error){showToast(errorMessage(error,'Could not delete question.'),'error');} }

    async function saveCourseStatus(id) {
        var control = document.getElementById('course-status-' + id);
        if (!control) return;
        try {
            await api.updateAdminCourseStatus(id, control.value);
            showToast('Course status updated.', 'success');
            await Promise.all([loadCourses(), loadAnalytics()]);
        } catch (error) {
            showToast(errorMessage(error, 'Could not update course status.'), 'error');
        }
    }

    async function editCourse(id) {
        try {
            var result = await api.getAdminCourse(id);
            var course = result.course || result;
            courseForm.dataset.editId = String(id);
            document.getElementById('courseTitle').value = course.title || '';
            document.getElementById('courseCategory').value = course.category || '';
            // Difficulty is temporarily hidden; the API preserves its stored value.
            document.getElementById('courseDuration').value = course.duration || '';
            document.getElementById('courseDescription').value = course.description || '';
            document.getElementById('courseContentPath').value = course.contentPath || '';
            document.getElementById('courseStatus').value = normaliseStatus(course.status);
            document.querySelector('#courseForm button[type="submit"]').textContent = 'Update course';
            var message = document.getElementById('courseMessage');
            message.textContent = 'Editing selected course.';
            message.className = 'admin-message ok';
            courseForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (error) {
            showToast(errorMessage(error, 'Could not load the course.'), 'error');
        }
    }

    async function removeCourse(id, title) {
        if (!confirm('Delete course "' + title + '"? This action cannot be undone.')) return;
        try {
            await api.deleteCourse(id);
            showToast('Course deleted.', 'success');
            await Promise.all([loadCourses(), loadAnalytics()]);
        } catch (error) {
            if (error && error.message && error.message.indexOf('force=1') >= 0) {
                if (!confirm('This course has learner records. Delete it and related records?')) return;
                try {
                    await api.deleteCourse(id, true);
                    showToast('Course and related records deleted.', 'success');
                    await Promise.all([loadCourses(), loadAnalytics()]);
                } catch (forcedError) {
                    showToast(errorMessage(forcedError, 'Could not delete the course.'), 'error');
                }
                return;
            }
            showToast(errorMessage(error, 'Could not delete the course.'), 'error');
        }
    }

    async function showCourseOverview(id) {
        var panel = document.getElementById('courseOverviewPanel');
        var target = document.getElementById('courseOverview');
        panel.hidden = false;
        target.innerHTML = '<p class="admin-muted">Loading course overview&hellip;</p>';
        panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        try {
            var result = await api.getAdminCourseOverview(id);
            var course = result.course || {};
            var assessment = result.assessment || {};
            var learners = result.learners || {};
            var modules = result.modules || [];
            var moduleList = modules.length
                ? '<ol class="module-overview-list">' + modules.map(function (module) {
                    return '<li><strong>' + esc(module.title) + '</strong><small>Module ID: ' + esc(module.id) + '</small></li>';
                }).join('') + '</ol>'
                : '<p class="admin-muted">No module metadata was found in this course source.</p>';
            target.innerHTML =
                '<div class="course-overview-head">' +
                    '<div><h3>' + esc(course.title || 'Course') + '</h3>' +
                    '<p>' + statusPill(course.status) + ' <span class="admin-muted">' + esc(course.contentPath || '') + '</span></p></div>' +
                    '<button type="button" class="btn btn-outline btn-sm" id="closeCourseOverview">Close</button>' +
                '</div>' +
                '<div class="overview-metrics">' +
                    '<div><span>Modules</span><strong>' + modules.length + '</strong></div>' +
                    '<div><span>Question bank</span><strong>' + Number(assessment.questionBank || 0) + '</strong></div>' +
                    '<div><span>Questions per attempt</span><strong>' + Number(assessment.questionsPerAttempt || 0) + '</strong></div>' +
                    '<div><span>Pass mark</span><strong>' + Number(assessment.passMark || 0) + '%</strong></div>' +
                    '<div><span>Time limit</span><strong>' + Number(assessment.minutes || 0) + ' min</strong></div>' +
                    '<div><span>Enrolled learners</span><strong>' + Number(learners.enrolled || 0) + '</strong></div>' +
                    '<div><span>Completed learners</span><strong>' + Number(learners.completed || 0) + '</strong></div>' +
                    '<div><span>Average progress</span><strong>' + Number(learners.averageProgress || 0) + '%</strong></div>' +
                '</div>' +
                '<h4>Modules</h4>' + moduleList +
                '<p class="admin-muted">This panel reads module and assessment details from the course source. Use Edit to update course metadata; authored lesson content remains in its course file.</p>';
            document.getElementById('closeCourseOverview').addEventListener('click', function () {
                panel.hidden = true;
            });
        } catch (error) {
            target.innerHTML = '<p class="admin-message err admin-message-visible">' + esc(errorMessage(error, 'Could not load the course overview.')) + '</p>';
        }
    }

    async function updateRole(id) {
        var role = document.getElementById('role-' + id);
        if (!role) return;
        try {
            await api.updateUserRole(id, role.value);
            showToast('User role updated.', 'success');
            await loadUsers();
        } catch (error) {
            showToast(errorMessage(error, 'Could not update user role.'), 'error');
        }
    }

    async function loadAnalytics() {
        var analytics = await api.getAdminAnalytics();
        var completionRate = analytics.enrollments ? Math.round(analytics.completedEnrollments / analytics.enrollments * 100) : 0;
        document.getElementById('adminAnalytics').innerHTML =
            '<div class="stats-row">' +
                '<div class="stat-card"><div class="label">Students</div><div class="value">' + Number(analytics.users || 0) + '</div></div>' +
                '<div class="stat-card"><div class="label">All courses</div><div class="value">' + Number(analytics.courses || 0) + '</div></div>' +
                '<div class="stat-card"><div class="label">Published</div><div class="value">' + Number(analytics.publishedCourses || 0) + '</div></div>' +
                '<div class="stat-card"><div class="label">Drafts</div><div class="value">' + Number(analytics.draftCourses || 0) + '</div></div>' +
                '<div class="stat-card"><div class="label">Archived</div><div class="value">' + Number(analytics.archivedCourses || 0) + '</div></div>' +
                '<div class="stat-card"><div class="label">Completion rate</div><div class="value">' + completionRate + '%</div></div>' +
                '<div class="stat-card"><div class="label">Average quiz score</div><div class="value">' + Number(analytics.averageQuizScore || 0) + '%</div></div>' +
            '</div>';
    }

    async function loadLearners(search) {
        var result = await api.getAdminLearners(search || '');
        var learners = result.learners || [];
        var list = document.getElementById('learnerList');
        if (!learners.length) {
            list.innerHTML = '<p class="admin-muted">No learners found.</p>';
            return;
        }
        list.innerHTML =
            '<table class="admin-table"><thead><tr>' +
            '<th>Name</th><th>Email</th><th>Organisation</th><th>Sector</th><th>Country</th><th>Job title</th><th>Courses</th><th>Completed</th><th>Progress</th><th>Last saved</th><th></th>' +
            '</tr></thead><tbody>' +
            learners.map(function (user) {
                return '<tr>' +
                    '<td><strong>' + esc(user.fullName) + '</strong></td>' +
                    '<td>' + esc(user.email) + '</td>' +
                    '<td>' + (user.organization ? esc(user.organization) : '&mdash;') + '</td>' +
                    '<td>' + (user.sector ? esc(user.sector) : '&mdash;') + '</td>' +
                    '<td>' + (user.country ? esc(user.country) : '&mdash;') + '</td>' +
                    '<td>' + (user.jobTitle ? esc(user.jobTitle) : '&mdash;') + '</td>' +
                    '<td>' + Number(user.enrolledCourses || 0) + '</td>' +
                    '<td>' + Number(user.completedCourses || 0) + '</td>' +
                    '<td>' + Number(user.averageProgress || 0) + '%</td>' +
                    '<td>' + dateText(user.lastProgressSaved) + '</td>' +
                    '<td><button class="btn btn-outline btn-sm" type="button" onclick="window.eacShowLearner(' + Number(user.id) + ')">View</button></td>' +
                '</tr>';
            }).join('') +
            '</tbody></table>';
    }

    async function showLearner(id) {
        try {
            var result = await api.getAdminLearner(id);
            var user = result.user || {};
            var courses = result.courses || [];
            var quizzes = result.quizzes || [];
            var courseRows = courses.length
                ? courses.map(function (course) {
                    return '<tr><td>' + esc(course.courseName) + '</td><td>' + Number(course.progress || 0) + '%</td><td>' + esc(course.status) + '</td><td>' + dateText(course.lastProgressSaved) + '</td><td>' + dateText(course.completedAt) + '</td></tr>';
                }).join('')
                : '<tr><td colspan="5">No enrolments.</td></tr>';
            var quizList = quizzes.length
                ? quizzes.map(function (quiz) {
                    return Number(quiz.score || 0) + '% (' + Number(quiz.correctAnswers || 0) + '/' + Number(quiz.totalQuestions || 0) + ') &mdash; ' + dateText(quiz.attemptedAt);
                }).join('<br>')
                : 'No quiz attempts.';
            document.getElementById('learnerDetail').innerHTML =
                '<div class="admin-detail-card">' +
                    '<div class="course-overview-head">' +
                        '<div><h3>' + esc(user.fullName) + '</h3><p class="admin-muted">' + esc(user.email) + ' &middot; ' + esc(user.organization || 'No organisation') + ' &middot; ' + esc(user.country || 'No country') + '</p></div>' +
                        '<button class="btn btn-outline btn-sm" type="button" id="closeLearnerDetail">Close</button>' +
                    '</div>' +
                    '<h4>Course progress</h4>' +
                    '<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Course</th><th>Progress</th><th>Status</th><th>Last saved</th><th>Completed</th></tr></thead><tbody>' + courseRows + '</tbody></table></div>' +
                    '<h4>Quiz attempts</h4><p class="admin-muted">' + quizList + '</p>' +
                '</div>';
            document.getElementById('closeLearnerDetail').addEventListener('click', function () {
                document.getElementById('learnerDetail').innerHTML = '';
            });
            document.getElementById('learnerDetail').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            showToast(errorMessage(error, 'Could not load learner details.'), 'error');
        }
    }

    async function loadCertificates(search) {
        var result = await api.getAdminCertificates(search || '');
        var certificates = result.certificates || [];
        var list = document.getElementById('certificateList');
        if (!certificates.length) {
            list.innerHTML = '<p class="admin-muted">No certificates found.</p>';
            return;
        }
        list.innerHTML =
            '<table class="admin-table"><thead><tr>' +
            '<th>Certificate number</th><th>Learner</th><th>Email</th><th>Organisation</th><th>Course</th><th>Course status</th><th>Issued</th><th></th>' +
            '</tr></thead><tbody>' +
            certificates.map(function (certificate) {
                return '<tr>' +
                    '<td><strong>' + esc(certificate.certificateNumber) + '</strong></td>' +
                    '<td>' + esc(certificate.userName) + '</td>' +
                    '<td>' + esc(certificate.email) + '</td>' +
                    '<td>' + (certificate.organization ? esc(certificate.organization) : '&mdash;') + '</td>' +
                    '<td>' + esc(certificate.courseName) + '</td>' +
                    '<td>' + statusPill(certificate.courseStatus) + '</td>' +
                    '<td>' + dateText(certificate.issuedAt) + '</td>' +
                    '<td><button class="btn btn-outline btn-sm" type="button" onclick="window.eacDownloadAdminCertificate(' + Number(certificate.id) + ', \'' + esc(certificate.certificateNumber) + '\')"><i class="fas fa-download"></i> PDF</button></td>' +
                '</tr>';
            }).join('') +
            '</tbody></table>';
    }

    async function loadAudit() {
        var result = await api.getAdminAuditLogs(100);
        var logs = result.logs || [];
        document.getElementById('auditList').innerHTML = logs.length
            ? '<table class="admin-table"><thead><tr><th>Date</th><th>User</th><th>Action</th><th>Entity</th><th>Details</th></tr></thead><tbody>' +
                logs.map(function (log) {
                    return '<tr><td>' + dateText(log.createdAt) + '</td><td>' + esc(log.userName || 'System') + '</td><td><span class="role-pill">' + esc(log.action) + '</span></td><td>' + (log.entityType ? esc(log.entityType) : '&mdash;') + (log.entityId ? ' #' + Number(log.entityId) : '') + '</td><td class="admin-wrap-cell">' + esc(log.details || '') + '</td></tr>';
                }).join('') +
              '</tbody></table>'
            : '<p class="admin-muted">No activity recorded yet.</p>';
    }

    async function loadFeedback() {
        var result = await api.getAdminFeedback();
        var feedback = result.feedback || [];
        document.getElementById('feedbackList').innerHTML = feedback.length
            ? '<table class="admin-table"><thead><tr><th>Course</th><th>Level</th><th>Learner</th><th>Rating</th><th>Comment</th><th>Date</th></tr></thead><tbody>' +
                feedback.map(function (item) {
                    var rating = Math.max(0, Math.min(5, Number(item.rating || 0)));
                    return '<tr><td>' + esc(item.courseName) + '</td><td><span class="role-pill">' + esc(item.difficulty || 'General') + '</span></td><td>' + esc(item.userName) + '<small class="admin-email">' + esc(item.email) + '</small></td><td>' + '&#9733;'.repeat(rating) + '&#9734;'.repeat(5 - rating) + '</td><td class="admin-wrap-cell">' + (item.comment ? esc(item.comment) : '&mdash;') + '</td><td>' + dateText(item.createdAt) + '</td></tr>';
                }).join('') +
              '</tbody></table>'
            : '<p class="admin-muted">No course comments yet.</p>';
    }

    async function exportLearners() {
        try {
            downloadBlob(await api.downloadAdminLearnersCsv(), 'eac-learners.csv');
        } catch (error) {
            showToast(errorMessage(error, 'Could not export learner report.'), 'error');
        }
    }

    async function exportCertificates() {
        try {
            downloadBlob(await api.downloadAdminCertificatesCsv(), 'eac-certificates.csv');
        } catch (error) {
            showToast(errorMessage(error, 'Could not export certificate register.'), 'error');
        }
    }

    async function downloadAdminCertificate(id, number) {
        try {
            downloadBlob(
                await api.downloadAdminCertificatePdf(id),
                certificateFilename(number)
            );
        } catch (error) {
            showToast(errorMessage(error, 'Could not download certificate.'), 'error');
        }
    }

    courseForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        var message = document.getElementById('courseMessage');
        message.className = 'admin-message';
        var contentFiles = Array.from(document.getElementById('courseContentUpload').files || []);
        if (!courseForm.dataset.editId && !contentFiles.length && !document.getElementById('courseContentPath').value.trim()) {
            message.textContent = 'Upload at least one HTML or text module file.';
            message.className = 'admin-message err';
            return;
        }
        if (contentFiles.reduce(function (total, file) { return total + file.size; }, 0) > 5 * 1024 * 1024) {
            message.textContent = 'All course module files together must not exceed 5 MB.';
            message.className = 'admin-message err';
            return;
        }
        var data = {
            title: document.getElementById('courseTitle').value.trim(),
            category: document.getElementById('courseCategory').value.trim(),
            duration: document.getElementById('courseDuration').value.trim(),
            description: document.getElementById('courseDescription').value.trim(),
            contentPath: document.getElementById('courseContentPath').value.trim(),
            status: document.getElementById('courseStatus').value,
            icon: 'book'
        };
        if (contentFiles.length) {
            data.contentFiles = await Promise.all(contentFiles.map(async function (file) {
                return { name: file.name, content: await file.text() };
            }));
        }
        try {
            if (courseForm.dataset.editId) {
                await api.updateCourse(courseForm.dataset.editId, data);
                message.textContent = 'Course updated successfully.';
            } else {
                await api.createCourse(data);
                message.textContent = 'Course created successfully as ' + statusLabel(data.status) + '.';
            }
            message.className = 'admin-message ok';
            courseForm.reset();
            document.getElementById('courseStatus').value = 'draft';
            delete courseForm.dataset.editId;
            document.querySelector('#courseForm button[type="submit"]').textContent = 'Create course';
            await Promise.all([loadCourses(), loadAnalytics()]);
        } catch (error) {
            message.textContent = errorMessage(error, 'Could not save course.');
            message.className = 'admin-message err';
        }
    });

    document.getElementById('courseStatusFilter').addEventListener('change', renderCourses);
    document.getElementById('courseSearch').addEventListener('input', renderCourses);
    document.getElementById('learnerSearch').addEventListener('input', function (event) {
        window.clearTimeout(window.__learnerSearchTimer);
        window.__learnerSearchTimer = window.setTimeout(function () {
            loadLearners(event.target.value.trim());
        }, 250);
    });
    document.getElementById('certificateSearch').addEventListener('input', function (event) {
        window.clearTimeout(window.__certificateSearchTimer);
        window.__certificateSearchTimer = window.setTimeout(function () {
            loadCertificates(event.target.value.trim());
        }, 250);
    });
    document.getElementById('exportLearners').addEventListener('click', exportLearners);
    document.getElementById('exportCertificates').addEventListener('click', exportCertificates);

    window.eacUpdateRole = updateRole;
    window.eacSaveCourseStatus = saveCourseStatus;
    window.eacEditCourse = editCourse;
    window.eacShowCourseOverview = showCourseOverview;
    window.eacShowLearner = showLearner;
    window.eacDownloadAdminCertificate = downloadAdminCertificate;

    document.getElementById('addQuestionOption').addEventListener('click', function(){ addQuestionOption('', false); });
    document.getElementById('cancelQuestionEdit').addEventListener('click', resetQuestionForm);
    document.getElementById('loadQuestions').addEventListener('click', function(){ loadQuestionBank().catch(function(error){showToast(errorMessage(error,'Could not load questions.'),'error');}); });
    document.getElementById('questionType').addEventListener('change', function(){ if(document.getElementById('questionCourse').value) document.getElementById('loadQuestions').click(); });
    document.getElementById('questionForm').addEventListener('submit', async function(event){
        event.preventDefault(); var cid=Number(document.getElementById('questionCourse').value); if(!cid){showToast('Select a course first.','error');return;}
        try{var id=Number(document.getElementById('questionId').value);var payload=questionPayload();if(id)await api.updateAdminQuestion(id,payload);else await api.createAdminQuestion(cid,payload);showToast(id?'Question updated in the database.':'Question saved to the database.','success');resetQuestionForm();await loadQuestionBank();}catch(error){showToast(errorMessage(error,'Could not save question.'),'error');}
    });
    document.getElementById('assessmentSettings').addEventListener('submit', async function(event){
        event.preventDefault();var cid=Number(document.getElementById('questionCourse').value);if(!cid)return;
        try{await api.updateAssessmentSettings(cid,{questionsPerAttempt:Number(document.getElementById('settingsAsk').value),passMark:Number(document.getElementById('settingsPass').value),minutes:Number(document.getElementById('settingsMinutes').value)});showToast('Assessment settings saved.','success');}catch(error){showToast(errorMessage(error,'Could not save settings.'),'error');}
    });
    resetQuestionForm();

    document.addEventListener('DOMContentLoaded', async function () {
        if (!await guard()) return;
        try {
            await Promise.all([
                loadUsers(),
                loadCourses(),
                loadAnalytics(),
                loadLearners(),
                loadCertificates(),
                loadAudit(),
                loadFeedback()
            ]);
        } catch (error) {
            showToast(errorMessage(error, 'Could not load administration data.'), 'error');
        }
    });
}());
</script>

<?php $basePath = ''; include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
