<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify EAC Certificate</title>
<link rel="stylesheet" href="assets/css/main.css?v=<?= (int) filemtime(__DIR__ . '/assets/css/main.css') ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<?php $faviconBasePath=''; include __DIR__ . '/includes/favicon.php'; ?>
<style>
.verify-page{min-height:calc(100vh - var(--header-h));padding:110px 20px 60px;background:var(--bg-page)}
.verify-card{max-width:720px;margin:0 auto;background:var(--bg-surface);border:1px solid var(--border);border-radius:16px;box-shadow:var(--shadow-md);padding:32px}
.verify-card h1{margin:0 0 8px;color:var(--eac-navy);font-size:1.7rem}.verify-card>p{color:var(--text-secondary);margin-bottom:22px}
.verify-form{display:flex;gap:10px;flex-wrap:wrap}.verify-form input{flex:1;min-width:230px;padding:12px 14px;border:1px solid var(--border);border-radius:8px;font:inherit}
.verify-result{margin-top:22px;padding:18px;border-radius:10px;display:none}.verify-result.valid{display:block;background:#eef8f0;border:1px solid #b9dec3}.verify-result.invalid{display:block;background:#fff2f2;border:1px solid #efb9b9}.verify-result h2{font-size:1.05rem;margin-bottom:8px}.verify-meta{display:grid;grid-template-columns:150px 1fr;gap:7px 12px;font-size:.92rem}.verify-meta strong{color:var(--text-secondary)}
@media(max-width:600px){.verify-card{padding:22px}.verify-meta{grid-template-columns:1fr}.verify-form .btn{width:100%}}
</style>
</head>
<body>
<?php $basePath=''; $activePage=''; $headerVariant='standard'; include __DIR__ . '/includes/header.php'; ?>
<main class="verify-page">
<section class="verify-card">
<h1><i class="fas fa-certificate"></i> Verify EAC Certificate</h1>
<p>Enter the certificate number exactly as shown on the issued EAC Statistics e-Learning certificate.</p>
<form class="verify-form" id="verifyForm">
<input type="text" id="certificateNumber" placeholder="EAC-2026-..." value="<?= htmlspecialchars((string)($_GET['number'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
<button type="submit" class="btn btn-primary"><i class="fas fa-shield-check"></i> Verify</button>
</form>
<div class="verify-result" id="verifyResult" aria-live="polite"></div>
</section>
</main>
<script>
(function(){
 const form=document.getElementById('verifyForm'),input=document.getElementById('certificateNumber'),result=document.getElementById('verifyResult');
 function esc(v){return String(v??'').replace(/[&<>\"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;',"'":'&#039;'}[c]));}
 async function verify(){
   const number=input.value.trim(); if(!number)return;
   result.className='verify-result'; result.style.display='block'; result.innerHTML='<p>Checking certificate…</p>';
   try{
     const r=await fetch('api/certificates/verify?number='+encodeURIComponent(number),{headers:{Accept:'application/json'}});
     const d=await r.json().catch(()=>({}));
     if(!r.ok||!d.valid)throw new Error(d.error||'Certificate not found.');
     const c=d.certificate||{};
     result.className='verify-result valid';
     result.innerHTML='<h2>✓ Valid EAC certificate</h2><div class="verify-meta"><strong>Learner</strong><span>'+esc(c.fullName)+'</span><strong>Course</strong><span>'+esc(c.courseName)+'</span><strong>Certificate No.</strong><span>'+esc(c.certificateNumber)+'</span><strong>Issued</strong><span>'+esc(c.issuedAt)+'</span></div>';
   }catch(e){result.className='verify-result invalid';result.innerHTML='<h2>Certificate not verified</h2><p>'+esc(e.message||'Certificate not found.')+'</p>';}
 }
 form.addEventListener('submit',e=>{e.preventDefault();verify();});
 if(input.value.trim())verify();
})();
</script>
<?php $basePath=''; include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
