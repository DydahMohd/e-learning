<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/forum.css">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Community Forum — EAC Statistics e-Learning</title>
<?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php $basePath = ""; $activePage = "forum"; $headerVariant = "standard"; include __DIR__ . "/includes/header.php"; ?>

<main class="forum-page">
  <div class="forum-intro"><div><h1>Community Forum</h1><p>Discuss statistical methods, course content and regional data practices with the EAC learning community.</p></div><a class="btn btn-outline" href="index.php">Browse Courses</a></div>
  <div class="forum-grid">
    <aside class="forum-panel"><div class="forum-panel-head">Course discussions</div><div class="topic-list" id="topicList"><div class="empty-forum">Loading discussions…</div></div></aside>
    <section class="forum-panel forum-main">
      <div class="forum-main-head"><h2 id="forumTitle">Select a course</h2><p id="forumSubtitle">Choose a course to view its discussion.</p></div>
      <div class="composer" id="composer">
        <form id="commentForm"><textarea id="commentText" maxlength="5000" placeholder="Share an insight, ask a question, or help another learner…"></textarea><div class="composer-actions"><span class="guest-note" id="guestNote"></span><button type="submit" class="btn btn-primary" id="postBtn">Post comment</button></div></form>
      </div>
      <div class="comments" id="commentsList"><div class="empty-forum">Select a course to begin.</div></div>
    </section>
  </div>
</main>
<script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>
<script>
let courses=[]; let activeCourseId=null; let replyTo=null;
function esc(v){const d=document.createElement('div');d.textContent=v??'';return d.innerHTML;}
function auth(){return api.isAuthenticated();}
function updateComposer(){
  const note=document.getElementById('guestNote'), btn=document.getElementById('postBtn'), area=document.getElementById('commentText');
  if(auth()){note.textContent='Signed in as '+(api.getUser()?.fullName||'learner');btn.disabled=false;area.disabled=false;}
  else{note.textContent='Sign in to participate in discussions.';btn.disabled=false;area.disabled=true;area.placeholder='Sign in to post a comment.';}
}
async function loadTopics(){
  try{const r=await api.getAllCourses();courses=Array.isArray(r)?r:(r.courses||[]);const list=document.getElementById('topicList');list.innerHTML=courses.map(c=>`<button class="topic" data-id="${c.id}"><strong>${esc(c.title)}</strong><small>${esc(c.category||'Statistics')}</small></button>`).join('');list.querySelectorAll('.topic').forEach(b=>b.addEventListener('click',()=>selectTopic(Number(b.dataset.id))));if(courses.length)selectTopic(courses[0].id);else list.innerHTML='<div class="empty-forum">No courses are available yet.</div>';}
  catch(e){document.getElementById('topicList').innerHTML='<div class="empty-forum">Could not load course discussions.</div>';}
}
async function selectTopic(id){activeCourseId=id;replyTo=null;const c=courses.find(x=>Number(x.id)===id);document.getElementById('forumTitle').textContent=c?.title||'Course discussion';document.getElementById('forumSubtitle').textContent=(c?.category||'Statistics')+' · EAC learning community';document.querySelectorAll('.topic').forEach(b=>b.classList.toggle('active',Number(b.dataset.id)===id));updateComposer();await loadComments();}
async function loadComments(){const el=document.getElementById('commentsList');el.innerHTML='<div class="empty-forum">Loading discussion…</div>';try{const comments=await api.getComments(activeCourseId);if(!comments.length){el.innerHTML='<div class="empty-forum"><strong>No discussion yet.</strong><br>Be the first learner to post a comment.</div>';return;}el.innerHTML=comments.map(c=>`<article class="comment-card ${c.parentId?'reply':''}"><div class="comment-head"><span class="comment-author">${esc(c.userName)}</span><span class="comment-date">${new Date(c.createdAt).toLocaleString()}</span></div><div class="comment-text">${esc(c.commentText)}</div><div class="comment-actions"><button onclick="likeComment(${c.id})"><i class="fas fa-thumbs-up"></i> ${Number(c.likes||0)}</button><button onclick="replyComment(${c.id})"><i class="fas fa-reply"></i> Reply</button></div></article>`).join('');}catch(e){el.innerHTML='<div class="empty-forum">Could not load this discussion. Please try again.</div>';}}
function replyComment(id){if(!auth()){document.getElementById('authBtn')?.click();return;}replyTo=id;document.getElementById('commentText').focus();document.getElementById('guestNote').textContent='Replying to comment #'+id;}
async function likeComment(id){if(!auth()){document.getElementById('authBtn')?.click();return;}try{await api.likeComment(id);await loadComments();}catch(e){showToast(e.message||'Could not update like.','error');}}
document.getElementById('commentForm').addEventListener('submit',async e=>{e.preventDefault();if(!auth()){document.getElementById('authBtn')?.click();return;}const text=document.getElementById('commentText').value.trim();if(!text||!activeCourseId)return;if(text.length>5000){showToast('Comment must be 5,000 characters or fewer.','error');return;}try{await api.postComment(activeCourseId,text,replyTo);document.getElementById('commentText').value='';replyTo=null;showToast('Comment posted successfully.','success');await loadComments();}catch(err){showToast(err.message||'Could not post discussion.','error');}});
document.addEventListener('DOMContentLoaded',()=>{updateComposer();loadTopics();});
</script>
<?php $basePath = ""; include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
