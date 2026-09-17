/* EAC Statistics e-Learning - Shared Course Runtime 
 * Course content and assessment data are loaded separately per course.
 * Navigation, progress, assessment UI, translation hooks and API sync live here.
 */
(function(){
'use strict';
if (window.__eacCourseRuntimeLoaded) return;
window.__eacCourseRuntimeLoaded=true;
const STATE={learner:null,passed:false,testScore:null,completed:{},pos:null,localSavedAt:0};
window.STATE=STATE;
/* QUIZZES, DRAGDROPS, MODNAME, FINAL, COURSE are declared with the injected data block above */

// Shared course/API context. These helpers must live in the outer course runtime
// scope because assessment and certificate functions use them as well as the
// persistence integration below. Keeping a second private copy in the nested
// integration made Assessment and Certificate see undefined COURSE_ID/API_ROOT.
const COURSE_ID=Number((window.COURSE&&window.COURSE.id)||0);
const API_ROOT=new URL('../api',location.href).href.replace(/\/$/,'');
function token(){ return localStorage.getItem('authToken')||''; }
function apiFetch(path,options){
  options=options||{};
  options.headers=Object.assign({'Accept':'application/json'},options.headers||{});
  if(options.body) options.headers['Content-Type']='application/json';
  const t=token(); if(t) options.headers.Authorization='Bearer '+t;
  return fetch(API_ROOT+path,options).then(function(response){
    return response.json().catch(function(){return {};}).then(function(data){
      if(!response.ok) throw new Error(data.error||data.message||('Request failed ('+response.status+')'));
      return data;
    });
  });
}

/* ---------- progress persistence (per course, per browser/device) ---------- */
const SKEY_BASE='eac_'+((COURSE.code||'crs')+'').toLowerCase()+'_progress_v2';
function getSKey(){ try { const u=JSON.parse(localStorage.getItem('user')||'null'); return SKEY_BASE+'_u'+(u&&u.id?String(u.id):'guest'); } catch(e){ return SKEY_BASE+'_guest'; } }
function storageOK(){
  try{
    const k='__eac_t'; localStorage.setItem(k,'1'); localStorage.removeItem(k); return true;
  }catch(error){ return false; }
}
const HASSTORE=storageOK();

/* ---------- embedded reader sizing ---------- */
function getCourseDocumentHeight(){
  const root=document.documentElement,body=document.body;
  return Math.ceil(Math.max(
    root?.scrollHeight||0,
    root?.offsetHeight||0,
    body?.scrollHeight||0,
    body?.offsetHeight||0
  ));
}
function sendCourseFrameHeight(){
  if(window.parent===window) return;
  const height=getCourseDocumentHeight();
  if(height>0) window.parent.postMessage({type:'eacFrameResize',height},location.origin);
}
function scrollCourseToTop(){
  if(window.parent!==window){
    sendCourseFrameHeight();
    window.parent.postMessage({type:'eacScrollCourseTop'},location.origin);
    return;
  }
  window.scrollTo({top:0,behavior:'auto'});
}
function initialiseEmbeddedReaderSizing(){
  if(window.parent===window||!document.body) return;
  let queued=false;
  const schedule=()=>{
    if(queued) return;
    queued=true;
    requestAnimationFrame(()=>{queued=false;sendCourseFrameHeight();});
  };
  if(typeof ResizeObserver==='function') new ResizeObserver(schedule).observe(document.body);
  new MutationObserver(schedule).observe(document.body,{childList:true,subtree:true,attributes:true,attributeFilter:['class','style']});
  window.addEventListener('resize',schedule);
  window.addEventListener('load',schedule,{once:true});
  schedule();
}
initialiseEmbeddedReaderSizing();

// Older course data files contain this retired advisory. Do not render it.
document.querySelectorAll('#noStoreNote, .nostore-note').forEach(note=>note.remove());
function saveState(){
  if(!HASSTORE) return;
  const savedAt=Date.now();
  STATE.localSavedAt=savedAt;
  try{localStorage.setItem(getSKey(),JSON.stringify({
    learner:STATE.learner,completed:STATE.completed,passed:STATE.passed,
    testScore:STATE.testScore,correct:STATE.correct,total:STATE.total,
    certId:STATE.certId,pos:STATE.pos,ts:savedAt,localSavedAt:savedAt
  }));}catch(e){}
  // Keep the database position in step with slide navigation. The integration
  // layer registers this hook after boot; local-only use simply ignores it.
  if(typeof window.__eacScheduleProgressSync==='function') window.__eacScheduleProgressSync();
}
function loadState(){
  if(!HASSTORE) return false;
  try{const raw=localStorage.getItem(getSKey()); if(!raw) return false; const d=JSON.parse(raw);
    STATE.learner=d.learner||null; STATE.completed=d.completed||{}; STATE.passed=!!d.passed;
    STATE.testScore=(d.testScore!=null?d.testScore:null); STATE.correct=d.correct||0; STATE.total=d.total||0;
    STATE.certId=d.certId||null; STATE.pos=d.pos||null; STATE.localSavedAt=Number(d.localSavedAt||d.ts||0);
    return !!STATE.learner;
  }catch(e){return false;}
}
function resetProgress(){
  if(!confirm('Start over? This clears your saved registration and progress on this device.')) return;
  try{localStorage.removeItem(getSKey());}catch(e){}
  location.reload();
}

/* ---------- quizzes (with ~2 min timer) ---------- */
function renderQuizzes(){
  document.querySelectorAll('.quiz-mount').forEach(m=>{
    // Legacy QUIZZES data remains in courses/data/*.js for rollback only.
    // Runtime questions are database-only.
    const bank=Array.isArray(window.__databaseQuizzes)?window.__databaseQuizzes:[];
    const q=bank.find(x=>String(x.id)===String(m.dataset.quiz));
    if(!q){m.innerHTML='<div class="quiz"><div class="fb show no">This quiz is not configured in the database.</div></div>';return;}
    const box=document.createElement('div'); box.className='quiz';
    let h='<div class="q-top"><span class="q-tag">'+(q.icon||'')+' '+(q.title||'Knowledge Check')+'</span></div>';
    h+='<div class="q-q">'+q.question+'</div>';
    q.options.forEach((o,i)=>{h+='<button class="opt" data-correct="'+(o.correct?'1':'0')+'"><b>'+String.fromCharCode(65+i)+'.</b> '+o.text+'</button>';});
    h+='<div class="fb"></div>'; box.innerHTML=h;
    const fb=box.querySelector('.fb'); const opts=[...box.querySelectorAll('.opt')];
    opts.forEach(btn=>btn.addEventListener('click',()=>{
      if(box.dataset.answered==='1') return; box.dataset.answered='1';
      opts.forEach(b=>{b.disabled=true; if(b.dataset.correct==='1') b.classList.add('correct');});
      const ok=btn.dataset.correct==='1'; if(!ok) btn.classList.add('wrong');
      fb.innerHTML=ok?q.feedbackCorrect:q.feedbackIncorrect; fb.className='fb show '+(ok?'ok':'no');
    }));
    m.replaceWith(box);
  });
}

function loadDatabaseQuizzes(){
  if(!COURSE_ID) return Promise.resolve();
  return apiFetch('/courses/'+encodeURIComponent(COURSE_ID)+'/questions').then(function(result){
    window.__databaseQuizzes=Array.isArray(result.questions)?result.questions:[];
  }).catch(function(error){
    window.__databaseQuizzes=[];
    console.warn('Database quizzes unavailable:',error.message);
  });
}

function bindStaticQuizzes(){
  document.querySelectorAll('.quiz:not([data-bound])').forEach(box=>{
    const opts=[...box.querySelectorAll('.opt')];
    const fb=box.querySelector('.fb');
    if(!opts.length || !fb) return;
    box.dataset.bound='1';
    opts.forEach(btn=>btn.addEventListener('click',()=>{
      if(box.dataset.answered==='1') return;
      box.dataset.answered='1';
      opts.forEach(b=>{b.disabled=true;if(b.dataset.correct==='1')b.classList.add('correct');});
      const ok=btn.dataset.correct==='1';
      if(!ok) btn.classList.add('wrong');
      fb.textContent=ok?'Correct!':'Not quite. The correct answer is highlighted.';
      fb.className='fb show '+(ok?'ok':'no');
    }));
  });
}
function bindStaticDragdrops(){
  document.querySelectorAll('.dd:not([data-bound])').forEach(box=>{
    const pool=box.querySelector('.pool'), fb=box.querySelector('.fb');
    const chips=[...box.querySelectorAll('.chip')];
    const drops=[...box.querySelectorAll('.drop')];
    if(!pool || !fb || !chips.length || !drops.length) return;
    box.dataset.bound='1';
    let selected=null;
    const place=(zone,chip)=>{chip.classList.remove('sel');selected=null;zone.appendChild(chip);};
    chips.forEach(chip=>{
      chip.draggable=true;
      chip.addEventListener('dragstart',e=>{e.dataTransfer.setData('text',chip.dataset.id||'');chip.classList.add('sel');});
      chip.addEventListener('dragend',()=>chip.classList.remove('sel'));
      chip.addEventListener('click',()=>{if(selected===chip){chip.classList.remove('sel');selected=null;}else{if(selected)selected.classList.remove('sel');selected=chip;chip.classList.add('sel');}});
    });
    [pool,...drops].forEach(zone=>{
      const host=zone.classList.contains('drop')?zone.closest('.bin'):zone;
      zone.addEventListener('dragover',e=>{e.preventDefault();host.classList.add('over');});
      zone.addEventListener('dragleave',()=>host.classList.remove('over'));
      zone.addEventListener('drop',e=>{e.preventDefault();host.classList.remove('over');const id=e.dataTransfer.getData('text');const chip=box.querySelector('.chip[data-id="'+id+'"]');if(chip)place(zone,chip);});
      zone.addEventListener('click',e=>{if(selected&&!e.target.classList.contains('chip'))place(zone,selected);});
      if(host!==pool)host.addEventListener('click',e=>{if(selected&&!e.target.classList.contains('chip'))place(zone,selected);});
    });
    box.querySelector('.check')?.addEventListener('click',()=>{
      let all=true,placedAll=!pool.querySelector('.chip');
      box.querySelectorAll('.bin').forEach(bin=>bin.querySelectorAll('.chip').forEach(chip=>{const ok=chip.dataset.cat===bin.dataset.key;chip.classList.toggle('right',ok);chip.classList.toggle('wrong',!ok);if(!ok)all=false;}));
      if(!placedAll)all=false;
      fb.textContent=all?'Correct!':'Place every item in the correct category, then check again.';
      fb.className='fb show '+(all?'ok':'no');
    });
    box.querySelector('.reset')?.addEventListener('click',()=>{chips.forEach(chip=>{chip.classList.remove('right','wrong','sel');pool.appendChild(chip);});selected=null;fb.className='fb';});
  });
}
/* ---------- dragdrops ---------- */
function renderDragdrops(){
  document.querySelectorAll('.dragdrop-mount').forEach(m=>{
    const d=DRAGDROPS.find(x=>x.id===m.dataset.dragdrop); if(!d) return;
    const box=document.createElement('div'); box.className='dd';
    let h='<span class="dd-tag">'+(d.icon||'🧩')+' '+(d.title||'Sort the items')+'</span>';
    h+='<div class="dd-i">'+(d.instructions||'')+'</div><div class="pool"></div><div class="bins">';
    d.categories.forEach(c=>{h+='<div class="bin" data-key="'+c.key+'"><h5>'+c.label+'</h5><div class="drop"></div></div>';});
    h+='</div><div class="dd-actions"><button class="dd-btn check">Check Answers</button><button class="dd-btn reset">Reset</button></div><div class="fb"></div>';
    box.innerHTML=h;
    const pool=box.querySelector('.pool'); const fb=box.querySelector('.fb');
    let items=d.items.map((it,i)=>({...it,id:d.id+'_'+i}));
    items=items.map(v=>({v,r:Math.random()})).sort((a,b)=>a.r-b.r).map(o=>o.v);
    let selected=null;
    function mkchip(it){const c=document.createElement('div');c.className='chip';c.textContent=it.text;c.draggable=true;c.dataset.cat=it.category;c.dataset.id=it.id;
      c.addEventListener('dragstart',e=>{e.dataTransfer.setData('text',it.id);c.classList.add('sel');});
      c.addEventListener('dragend',()=>c.classList.remove('sel'));
      c.addEventListener('click',()=>{if(selected===c){c.classList.remove('sel');selected=null;}else{if(selected)selected.classList.remove('sel');selected=c;c.classList.add('sel');}});
      return c;}
    items.forEach(it=>pool.appendChild(mkchip(it)));
    function place(t,chip){chip.classList.remove('sel');selected=null;t.appendChild(chip);}
    [pool,...box.querySelectorAll('.drop')].forEach(zone=>{
      const host=zone.classList.contains('drop')?zone.closest('.bin'):zone;
      zone.addEventListener('dragover',e=>{e.preventDefault();host.classList&&host.classList.add('over');});
      zone.addEventListener('dragleave',()=>host.classList&&host.classList.remove('over'));
      zone.addEventListener('drop',e=>{e.preventDefault();host.classList&&host.classList.remove('over');const id=e.dataTransfer.getData('text');const chip=box.querySelector('.chip[data-id="'+id+'"]');if(chip)place(zone,chip);});
      zone.addEventListener('click',e=>{if(selected&&(e.target===zone))place(zone,selected);});
      if(host!==pool)host.addEventListener('click',e=>{if(selected&&!e.target.classList.contains('chip'))place(zone,selected);});
    });
    box.querySelector('.check').addEventListener('click',()=>{
      let all=true,placedAll=true;
      box.querySelectorAll('.bin').forEach(bin=>{bin.querySelectorAll('.chip').forEach(ch=>{
        if(ch.dataset.cat===bin.dataset.key){ch.classList.add('right');ch.classList.remove('wrong');}
        else{ch.classList.add('wrong');ch.classList.remove('right');all=false;}});});
      if(pool.querySelector('.chip')){placedAll=false;all=false;}
      fb.innerHTML=(all&&placedAll)?d.feedbackCorrect:(placedAll?d.feedbackIncorrect:'⚠️ Place every item in a category first, then check.');
      fb.className='fb show '+((all&&placedAll)?'ok':'no');
    });
    box.querySelector('.reset').addEventListener('click',()=>{box.querySelectorAll('.chip').forEach(ch=>{ch.classList.remove('right','wrong','sel');pool.appendChild(ch);});fb.className='fb';selected=null;});
    m.replaceWith(box);
  });
}

/* ---------- click-to-reveal (e.g. lending by economic activity) ---------- */
function renderReveals(){
  document.querySelectorAll('.reveal-mount').forEach(m=>{
    const r=REVEALS.find(x=>x.id===m.dataset.reveal); if(!r) return;
    const box=document.createElement('div'); box.className='reveal';
    let h='<div class="rv-top"><span class="rv-tag">'+(r.icon||'🔎')+' '+(r.title||'Click to explore')+'</span></div>';
    if(r.instructions) h+='<div class="rv-i">'+r.instructions+'</div>';
    h+='<div class="rv-grid">';
    r.items.forEach((it,i)=>{h+='<button class="rv-chip" data-i="'+i+'">'+it.label+'</button>';});
    h+='</div><div class="rv-panel"><div class="rv-hint">👆 Select an item above to read its definition.</div></div>';
    box.innerHTML=h;
    const panel=box.querySelector('.rv-panel'); const chips=[...box.querySelectorAll('.rv-chip')];
    chips.forEach(c=>c.addEventListener('click',()=>{
      chips.forEach(x=>x.classList.remove('active')); c.classList.add('active');
      const it=r.items[parseInt(c.dataset.i)];
      panel.innerHTML='<div class="rv-def"><h5>'+it.label+'</h5><p>'+it.body+'</p></div>';
    }));
    m.replaceWith(box);
  });
}

/* ---------- voiceover placeholders ---------- */
function initVoiceovers(){
  document.querySelectorAll('.vo').forEach(vo=>{
    const tog=vo.querySelector('.vo-toggle'), scr=vo.querySelector('.vo-script');
    if(tog&&scr) tog.addEventListener('click',()=>{const on=scr.classList.toggle('show');tog.textContent=on?'Hide script':'Show script';});
    const play=vo.querySelector('.vo-play'), src=vo.dataset.src||'';
    if(src){ const audio=new Audio(src); play.disabled=false;
      play.addEventListener('click',()=>{ if(audio.paused){audio.play();play.textContent='⏸';} else {audio.pause();play.textContent='🔊';} });
      audio.addEventListener('ended',()=>play.textContent='🔊');
    }
  });
}

/* ---------- screen flow ---------- */
let REG_NEXT=null;
function showScreen(id){
  if(id==='register'){ location.href='../register.php'; return; }
  if(id==='welcome') REG_NEXT=null;
  if(id==='assessment'&&!moduleOrder().every(mid=>!!STATE.completed[mid])){
    alert('Complete all course modules before starting the final assessment.');
    id='hub';
  }
  if(id==='certificate'&&!STATE.passed){id='assessment';}
  if(id!=='assessment'){ if(typeof stopAssessTimer==='function') stopAssessTimer(); }
  document.querySelectorAll('.screen').forEach(s=>s.classList.remove('active'));
  const el=document.getElementById('screen-'+id); if(!el) return;
  el.classList.add('active');
  if(id==='register'){ const rb=document.getElementById('regSubmit'); if(rb) rb.textContent='Submit'; }
  if(id==='assessment') renderTest();
  if(id==='certificate') populateCert();
  if(id==='hub') updateHub();
  if(window.parent&&window.parent!==window){
    window.parent.postMessage({type:'eacCourseScreenChanged',screen:id},location.origin);
  }
  scrollCourseToTop();
}
function goTo(id){
  return (typeof window.showScreen==='function' && window.showScreen!==showScreen)
    ? window.showScreen(id)
    : showScreen(id);
}
function bindScreenControl(b){
  if(!b||b.dataset.eacScreenBound)return;
  if(b.tagName==='BUTTON'&&!b.getAttribute('type')) b.type='button';
  b.dataset.eacScreenBound='1';
  b.addEventListener('click',e=>{e.preventDefault();goTo(b.dataset.screen);});
}
function initFlow(){
  document.querySelectorAll('[data-screen]').forEach(bindScreenControl);
  document.querySelectorAll('[data-openmod]').forEach(b=>{
    if(b.tagName==='BUTTON'&&!b.getAttribute('type')) b.type='button';
    if(b.dataset.eacModuleBound)return;
    b.dataset.eacModuleBound='1';
    b.addEventListener('click',e=>{e.preventDefault();openModule(b.dataset.openmod);});
  });
  document.querySelectorAll('.mod-bar[data-mid]').forEach(bar=>{
    const actions=bar.querySelector('.mod-go');
    if(!actions||actions.querySelector('.mod-mark-read')) return;
    const button=document.createElement('button');
    button.type='button';
    button.className='btn btn-green mod-mark-read';
    button.textContent='✓ Mark as read';
    button.addEventListener('click',event=>{
      event.preventDefault();
      event.stopPropagation();
      markModuleRead(bar.dataset.mid);
      updateHub();
    });
    actions.insertBefore(button,actions.firstChild);
  });
  const reg=document.getElementById('regSubmit'); if(reg) reg.addEventListener('click',submitRegistration);
  const cs=document.getElementById('regCountry'); if(cs) cs.addEventListener('change',()=>{const w=document.getElementById('regCountryOtherWrap'); if(w) w.style.display=cs.value==='Other'?'flex':'none';});
  const sx=document.getElementById('regSector'); if(sx) sx.addEventListener('change',()=>{const w=document.getElementById('regSectorOtherWrap'); if(w) w.style.display=sx.value==='Other'?'flex':'none';});
  const submit=document.getElementById('submitTest'); if(submit) submit.addEventListener('click',()=>submitTest(false));
  const png=document.getElementById('certPng'); if(png){ png.textContent='⬇ Download certificate (PDF)'; png.addEventListener('click',downloadOfficialCertificatePdf); }
  const prn=document.getElementById('certPrint'); if(prn) prn.addEventListener('click',()=>window.print());
  const ps=document.getElementById('prevSlide'); if(ps) ps.addEventListener('click',prevSlide);
  const ns=document.getElementById('nextSlide'); if(ns) ns.addEventListener('click',nextSlide);
  document.addEventListener('keydown',e=>{ if(!document.getElementById('screen-module').classList.contains('active'))return;
    if(e.key==='ArrowRight')nextSlide(); if(e.key==='ArrowLeft')prevSlide(); });
}

/* ---------- module slide player ---------- */
const CUR={mid:null,i:0,n:0};
function getDeckSlides(deck){
  return deck ? [...deck.children].filter(el=>el.classList&&el.classList.contains('slide')) : [];
}
function moduleOrder(){
  return [...document.querySelectorAll('.mod-bar[data-mid]')].map(bar=>bar.dataset.mid).filter(Boolean);
}
function firstIncompleteModule(){
  return moduleOrder().find(mid=>!STATE.completed[mid])||null;
}
function canOpenModule(mid){
  return moduleOrder().includes(mid);
}
function openModule(mid){
  if(!canOpenModule(mid)) return;
  document.querySelectorAll('.deck').forEach(d=>d.style.display='none');
  const deck=document.getElementById('deck-'+mid);
  if(!deck){ console.warn('Course module not found:',mid); return; }
  const slides=getDeckSlides(deck);
  if(!slides.length){ console.warn('Course module has no slides:',mid); return; }
  deck.style.display='block';
  CUR.mid=mid;
  // Use the DOM as the source of truth. data-n is retained as metadata only, so
  // a future content edit cannot make the Next button stop early.
  CUR.n=slides.length;
  CUR.i=0;
  deck.dataset.n=String(CUR.n);
  const pt=document.getElementById('playerTitle'); if(pt) pt.textContent=MODNAME[mid]||'';
  goTo('module');
  gotoSlide(0);
}
function gotoSlide(i){
  const deck=document.getElementById('deck-'+CUR.mid); if(!deck) return;
  const slides=getDeckSlides(deck);
  if(!slides.length) return;
  CUR.n=slides.length;
  i=Math.max(0,Math.min(CUR.n-1,Number(i)||0)); CUR.i=i;
  slides.forEach((slide,index)=>slide.classList.toggle('active',index===i));
  const sc=document.getElementById('slideCount'); if(sc) sc.textContent=(i+1)+' / '+CUR.n;
  const sb=document.getElementById('slideBar'); if(sb) sb.style.width=((i+1)/CUR.n*100)+'%';
  const prev=document.getElementById('prevSlide'),next=document.getElementById('nextSlide');
  if(prev){prev.type='button';prev.disabled=i===0;prev.style.visibility=i===0?'hidden':'visible';}
  if(next){next.type='button';next.disabled=false;next.textContent=i===CUR.n-1?'Finish module ✓':'Next →';}
  STATE.pos={mid:CUR.mid,i:i}; saveState();
  scrollCourseToTop();
}
function nextSlide(){
  if(!CUR.mid) return;
  if(CUR.i>=CUR.n-1){ markComplete(CUR.mid); goTo('hub'); }
  else gotoSlide(CUR.i+1);
}
function prevSlide(){ if(CUR.mid) gotoSlide(CUR.i-1); }
function markComplete(mid){ STATE.completed[mid]=true; STATE.pos=null; saveState(); if(window.eacQueueModuleCompletion) window.eacQueueModuleCompletion(mid); }
function markModuleRead(mid){
  mid=String(mid||'');
  if(!moduleOrder().includes(mid)||STATE.completed[mid]) return;
  markComplete(mid);
}
function markCurrentModuleRead(){
  if(!CUR.mid) return;
  // Guests may complete modules one at a time. Their progress is retained in
  // this browser and replayed to the database when they sign in for assessment.
  markModuleRead(CUR.mid);
  goTo('hub');
}
function updateHub(){
  let done=0,total=0,changed=false,gapSeen=false;
  const bars=[...document.querySelectorAll('.mod-bar[data-mid]')];
  // Completion is sequential on the server. Remove stale/out-of-order local
  // completion flags left by older builds so the UI cannot disagree with the DB.
  bars.forEach(bar=>{
    const mid=bar.dataset.mid;
    if(false&&gapSeen&&STATE.completed[mid]){delete STATE.completed[mid];changed=true;}
    if(!STATE.completed[mid]) gapSeen=true;
  });
  const first=firstIncompleteModule();
  if(false&&STATE.pos&&STATE.pos.mid&&!STATE.completed[STATE.pos.mid]&&first&&STATE.pos.mid!==first){
    STATE.pos=null;changed=true;
  }
  bars.forEach(bar=>{
    total++;
    const mid=bar.dataset.mid;
    const st=bar.querySelector('.mod-status');
    const markRead=bar.querySelector('.mod-mark-read');
    const completed=!!STATE.completed[mid];
    const current=!!(STATE.pos&&STATE.pos.mid===mid);
    const locked=false;
    bar.classList.toggle('locked',locked);
    bar.setAttribute('aria-disabled',locked?'true':'false');
    if(completed){done++;if(st){st.textContent='✓ Completed';st.classList.add('done');}}
    else if(current){if(st){st.textContent='Resume →';st.classList.remove('done');}}
    else if(locked){if(st){st.textContent='🔒 Complete previous module';st.classList.remove('done');}}
    else if(st){st.textContent='Start →';st.classList.remove('done');}
    if(markRead){
      markRead.disabled=completed;
      markRead.textContent=completed?'✓ Read':'✓ Mark as read';
    }
  });
  if(changed) saveState();
  const hp=document.getElementById('hubDone'); if(hp) hp.textContent=done;
  const ht=document.getElementById('hubTotal'); if(ht) ht.textContent=total;
  document.querySelectorAll('[data-screen="assessment"]').forEach(button=>{
    const assessmentLocked=total===0||done<total;
    button.disabled=assessmentLocked;
    button.setAttribute('aria-disabled',assessmentLocked?'true':'false');
    button.title=assessmentLocked?'Complete all modules to unlock the final assessment.':'';
  });
  buildResumeBanner();
}
function buildResumeBanner(){
  const b=document.getElementById('resumeBanner'); if(!b) return;
  if(!STATE.learner){
    b.className='resume-banner guest';
    b.innerHTML='<div class="rb-txt"><b>Guest learning</b> — open each module and use <b>Mark as read</b> to complete it. Your module-by-module progress stays in this browser. Sign in when you are ready for the final assessment, cloud progress and certificate.</div>'+      '<div class="rb-actions"><button class="btn btn-blue" id="guestSignIn">Sign in</button><a class="rb-reset" href="../register.php">Create account</a></div>';
    b.style.display='flex';
    const gs=document.getElementById('guestSignIn'); if(gs) gs.addEventListener('click',()=>{if(window.parent&&window.parent!==window&&typeof window.parent.openModal==='function')window.parent.openModal('loginModal');else location.href='../login.php';});
    return;
  }
  b.className='resume-banner';
  const name=[STATE.learner.first,STATE.learner.middle,STATE.learner.surname]
    .filter(Boolean).map(String).join(' ').trim()||'Learner';
  b.replaceChildren();
  const message=document.createElement('div');
  message.className='rb-txt';
  message.append('Signed in as ');
  const learnerName=document.createElement('b');
  learnerName.textContent=name;
  message.append(learnerName,' — your progress is saved on this device.');
  const actions=document.createElement('div');
  actions.className='rb-actions';
  if(STATE.pos&&STATE.pos.mid&&!STATE.completed[STATE.pos.mid]){
    const m=(MODNAME[STATE.pos.mid]||'').match(/Module\s+(\d+)/);
    const resume=document.createElement('button');
    resume.type='button';
    resume.className='btn btn-green';
    resume.textContent='Resume Module '+(m?m[1]:'');
    resume.addEventListener('click',resumeProgress);
    actions.appendChild(resume);
  }
  if(STATE.passed){
    const certificate=document.createElement('button');
    certificate.type='button';
    certificate.className='btn btn-blue';
    certificate.textContent='View certificate';
    certificate.addEventListener('click',()=>goTo('certificate'));
    actions.appendChild(certificate);
  }
  b.append(message,actions);
  b.style.display='flex';
}
function resumeProgress(){ if(STATE.pos&&STATE.pos.mid){ const mid=STATE.pos.mid,tgt=STATE.pos.i; openModule(mid); gotoSlide(tgt); return; } if(!Object.keys(STATE.completed||{}).length) return; const next=[...document.querySelectorAll(".mod-bar[data-mid]")].find(b=>!STATE.completed[b.dataset.mid]); if(next&&next.dataset.mid) openModule(next.dataset.mid); }

/* ---------- registration ---------- */
function submitRegistration(){
  const f=id=>document.getElementById(id);
  const req=['regFirst','regSurname','regSex','regEmail','regOrg','regSector','regCountry']; let ok=true;
  req.forEach(k=>{const el=f(k); if(!(el.value||'').trim()){el.classList.add('err');ok=false;}else el.classList.remove('err');});
  const em=f('regEmail'); if((em.value||'').trim() && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(em.value.trim())){em.classList.add('err');ok=false;}
  if(f('regCountry').value==='Other'){const o=f('regCountryOther');if(!(o.value||'').trim()){o.classList.add('err');ok=false;}else o.classList.remove('err');}
  if(f('regSector').value==='Other'){const o=f('regSectorOther');if(!(o.value||'').trim()){o.classList.add('err');ok=false;}else o.classList.remove('err');}
  const err=f('regError');
  if(!ok){err.style.display='block';err.textContent='Please complete the required fields marked with an asterisk (*), including a valid email address.';err.scrollIntoView({behavior:'smooth',block:'center'});return;}
  err.style.display='none';
  const country=f('regCountry').value==='Other'?f('regCountryOther').value.trim():f('regCountry').value;
  const sector=f('regSector').value==='Other'?f('regSectorOther').value.trim():f('regSector').value;
  STATE.learner={first:f('regFirst').value.trim(),middle:(f('regMiddle').value||'').trim(),surname:f('regSurname').value.trim(),sex:f('regSex').value,email:f('regEmail').value.trim(),org:f('regOrg').value.trim(),sector:sector,country:country,role:(f('regRole').value||'').trim(),started:new Date().toISOString()};
  saveState();
  const nx=REG_NEXT||'hub'; REG_NEXT=null; goTo(nx);
}

/* ---------- final assessment ---------- */
let TESTQ=[]; let answers={};
function shuffle(a){a=a.slice();for(let i=a.length-1;i>0;i--){const j=Math.floor(Math.random()*(i+1));[a[i],a[j]]=[a[j],a[i]];}return a;}
function updateTestProgress(){const n=TESTQ.length,done=Object.keys(answers).length;const f=document.getElementById('tpFill'),t=document.getElementById('tpTxt');if(f)f.style.width=(n?done/n*100:0)+'%';if(t)t.textContent=done+' of '+n+' answered';}
function renderTest(){
  const box=document.getElementById('testQs');
  if(!box){return;}
  if(typeof token!=='function' || !token() || typeof apiFetch!=='function'){
    box.innerHTML='<div class="result-card fail"><div class="result-text"><h3>Sign in required</h3><p>Please sign in before starting the final assessment.</p></div></div>';
    return;
  }
  box.innerHTML='<div class="result-card"><div class="result-text"><h3>Loading assessment…</h3><p>Questions are being selected securely by the server.</p></div></div>';
  apiFetch('/quizzes/start',{method:'POST',body:JSON.stringify({courseId:COURSE_ID})}).then(function(server){
    window.__assessmentToken=server.token||'';
    window.__assessmentPassMark=Number(server.passMark!=null?server.passMark:FINAL.pass_mark||75);
    window.__assessmentMinutes=Number(server.minutes||FINAL.minutes||20);
    answers={};
    const qs=Array.isArray(server.questions)?server.questions:[];
    if(!qs.length) throw new Error('No assessment questions were returned.');
    TESTQ=qs.map(q=>({q:q.q,explain:q.explain||'',opts:shuffle(q.options||[])}));
    let h='';
    TESTQ.forEach((q,qi)=>{h+='<div class="test-q"><div class="tq"><span class="n">'+(qi+1)+'</span>'+q.q+'</div>';
      q.opts.forEach((o,oi)=>{h+='<button class="test-opt" data-q="'+qi+'" data-o="'+oi+'">'+o.text+'</button>';});
      h+='</div>';});
    box.innerHTML=h;
    box.querySelectorAll('.test-opt').forEach(b=>b.addEventListener('click',()=>{
      const qi=b.dataset.q; box.querySelectorAll('.test-opt[data-q="'+qi+'"]').forEach(x=>x.classList.remove('sel'));
      b.classList.add('sel'); answers[qi]=parseInt(b.dataset.o); updateTestProgress();
    }));
    document.getElementById('testResult').className=''; document.getElementById('testResult').innerHTML='';
    updateTestProgress(); startAssessTimer(); scrollCourseToTop();
  }).catch(function(e){
    box.innerHTML='<div class="result-card fail"><div class="result-text"><h3>Assessment unavailable</h3><p>'+String(e.message||'Unable to start the assessment.').replace(/[<>]/g,'')+'</p></div></div>';
  });
}
let ASSESS_T=null;
function startAssessTimer(){
  clearInterval(ASSESS_T);
  let secs=Math.round((window.__assessmentMinutes||FINAL.minutes||20)*60);
  const disp=document.getElementById('assessTimer');
  const render=()=>{const m=Math.floor(secs/60),s=secs%60; if(disp){disp.textContent='⏱️ '+m+':'+String(s).padStart(2,'0'); disp.classList.toggle('low',secs<=60);}};
  render();
  ASSESS_T=setInterval(()=>{ secs--; if(secs<0){clearInterval(ASSESS_T); const d=document.getElementById('assessTimer'); if(d)d.textContent='⏱️ 0:00'; submitTest(true); return;} render(); },1000);
}
function stopAssessTimer(){ clearInterval(ASSESS_T); }
function submitTest(auto){
  if(typeof token!=='function' || !token()){ alert('Please sign in before submitting the final assessment.'); return; }
  const n=TESTQ.length; if(!n || !window.__assessmentToken){ alert('Assessment session is not ready. Please start the assessment again.'); return; }
  if(!auto && Object.keys(answers).length<n){ if(!confirm('You have answered '+Object.keys(answers).length+' of '+n+' questions. Submit anyway?')) return; }
  stopAssessTimer();
  if(!window.__serverAssessmentResult){
    var payload=TESTQ.map(function(q,qi){var s=answers[qi];return {question:q.q,answer:s!=null&&q.opts[s]?q.opts[s].text:''};});
    apiFetch('/quizzes/submit',{method:'POST',body:JSON.stringify({courseId:COURSE_ID,assessmentToken:window.__assessmentToken,answers:payload})}).then(function(server){window.__serverAssessmentResult=server;submitTest(auto);}).catch(function(e){alert(e.message||'Assessment could not be verified.');});
    return;
  }
  var serverAssessment=window.__serverAssessmentResult; window.__serverAssessmentResult=null;
  const pct=Number(serverAssessment.score||0); const correct=Number(serverAssessment.correctAnswers||0); const passed=!!serverAssessment.passed; const review=Array.isArray(serverAssessment.review)?serverAssessment.review:[];
  STATE.testScore=pct; STATE.passed=passed; STATE.correct=correct; STATE.total=n; saveState();
  const box=document.getElementById('testResult');
  let h='<div class="result-card '+(passed?'pass':'fail')+'">';
  h+='<div class="score-ring '+(passed?'pass':'fail')+'"><b>'+pct+'%</b><small>'+correct+' / '+n+'</small></div>';
  h+='<div class="result-text"><h3>'+(passed?'🎉 Congratulations — you passed!':'Almost there')+'</h3>';
  if(auto) h+='<p style="color:var(--eac-red);font-weight:700;margin-bottom:6px">⏱️ Time expired — your assessment was submitted automatically.</p>';
  const passMark=Number(window.__assessmentPassMark||FINAL.pass_mark||75);
  h+='<p>'+(passed?('You scored '+pct+'%, at or above the '+passMark+'% pass mark. Your certificate is ready.'):('You scored '+pct+'%. The pass mark is '+passMark+'%. Review the explanations below and retake — the questions reshuffle each time.'))+'</p>';
  h+='<div class="result-actions">';
  h+=passed?'<button class="btn btn-green btn-lg" id="goCert">Get your certificate →</button>':'<button class="btn btn-blue" id="retakeTest">↻ Retake the assessment</button> <button class="btn btn-ghost" data-screen="hub">Back to modules</button>';
  h+='</div></div></div>';
  h+='<details class="ans-review"><summary>Review all questions &amp; correct answers</summary><div>';
  review.forEach(function(r,qi){
    h+='<div class="ans-item '+(r.correct?'ok':'no')+'"><div class="ai-q">'+(qi+1)+'. '+r.question+'</div>';
    h+='<div class="ai-a">'+(r.correct?'✅ Correct':'❌ Your answer: '+(r.selected||'(no answer)'))+'</div>';
    if(!r.correct)h+='<div class="ai-c">✔ Correct answer: '+(r.correctAnswer||'Unavailable')+'</div>';
    h+='<div class="ai-e">'+(r.explain||'')+'</div></div>';
  });
  h+='</div></details>';
  box.innerHTML=h; box.className='show';
  box.querySelectorAll('[data-screen]').forEach(bindScreenControl);
  const gc=document.getElementById('goCert'); if(gc) gc.addEventListener('click',()=>goTo('certificate'));
  const rt=document.getElementById('retakeTest'); if(rt) rt.addEventListener('click',()=>{window.__assessmentToken='';renderTest();});
}

/* ---------- certificate (no score) ---------- */
function genCertId(){const c='ABCDEFGHJKLMNPQRSTUVWXYZ23456789';let s='';for(let i=0;i<6;i++)s+=c[Math.floor(Math.random()*c.length)];return 'EAC-'+(COURSE.code||'CRS')+'-'+new Date().getFullYear()+'-'+s;}
function configureCertificatePreview(){
  const svg=document.getElementById('certSVG');
  if(!svg||svg.dataset.eacStyled==='1') return;
  svg.dataset.eacStyled='1';
  svg.setAttribute('font-family',"'Times New Roman',Times,serif");
  const texts=[...svg.querySelectorAll('text')];
  const find=text=>texts.find(node=>node.textContent.trim()===text);
  const community=find('EAST AFRICAN COMMUNITY');
  if(community){community.setAttribute('font-family',"'Times New Roman',Times,serif");community.setAttribute('fill','#063f78');}
  const title=find('Certificate of Completion');
  if(title){title.setAttribute('font-family',"Georgia,'Times New Roman',serif");title.setAttribute('font-style','italic');title.setAttribute('font-weight','normal');title.setAttribute('font-size','38');}
  ['This is to certify that','has successfully completed the online course on'].forEach(text=>{
    const node=find(text);if(node){node.setAttribute('font-family',"Georgia,'Times New Roman',serif");node.setAttribute('font-style','italic');node.setAttribute('fill','#063f78');}
  });
  const offered=find('offered under the EAC Statistics E-Learning Programme');
  if(offered){offered.setAttribute('font-family',"Georgia,'Times New Roman',serif");offered.setAttribute('font-style','italic');offered.setAttribute('fill','#063f78');}
  const name=document.getElementById('cert-name');
  if(name){name.setAttribute('font-family',"'Kunstler Script','Monotype Corsiva','Edwardian Script ITC',cursive");name.setAttribute('font-style','italic');name.setAttribute('font-weight','normal');name.setAttribute('fill','#063f78');}
  const course=document.getElementById('cert-course');
  if(course){course.setAttribute('font-family',"Georgia,'Times New Roman',serif");course.setAttribute('font-weight','bold');}
  const date=document.getElementById('cert-date');
  if(date){date.setAttribute('font-family',"Georgia,'Times New Roman',serif");date.setAttribute('font-style','italic');}
  const signature=find('East African Community');
  if(signature){signature.setAttribute('font-family',"Georgia,'Times New Roman',serif");signature.setAttribute('font-style','italic');}
  const seal=document.createElementNS('http://www.w3.org/2000/svg','g');
  seal.setAttribute('id','certificate-achievement-seal');
  seal.setAttribute('transform','translate(500 555)');
  seal.innerHTML='<circle r="54" fill="#d69200" stroke="#7b4800" stroke-width="2"/>'+
    '<circle r="47" fill="#f7bd20" stroke="#fff07a" stroke-width="2"/>'+
    '<circle r="39" fill="#d99100" stroke="#704000" stroke-width="1.5"/>'+
    '<circle r="31" fill="#f3b719" stroke="#ffe780" stroke-width="1.5"/>'+
    '<path d="M0-23 6.8-7.4 23.8-7.4 10 2.8 15 19-0 9.5-15 19-10 2.8-23.8-7.4-6.8-7.4Z" fill="#ffd95a" stroke="#754300" stroke-width="1.3"/>'+
    '<text x="0" y="-39" text-anchor="middle" font-family="Times New Roman,serif" font-size="7" font-weight="bold" fill="#2c1a00">EAST AFRICAN COMMUNITY</text>'+
    '<text x="0" y="44" text-anchor="middle" font-family="Times New Roman,serif" font-size="6.5" font-weight="bold" fill="#2c1a00">EXCELLENCE • HONOUR • ACHIEVEMENT</text>';
  const certId=document.getElementById('cert-id');
  if(certId) svg.insertBefore(seal,certId); else svg.appendChild(seal);
}
function updateCertificatePreview(certificate){
  configureCertificatePreview();
  const L=STATE.learner||{};
  const name=[L.first,L.middle,L.surname].filter(Boolean).join(' ').trim()||'Participant';
  const nm=document.getElementById('cert-name'); if(nm){nm.textContent=name.toUpperCase(); nm.setAttribute('font-size',name.length>30?38:(name.length>20?48:58));}
  const set=(id,t)=>{const e=document.getElementById(id);if(e)e.textContent=t;};
  set('cert-course',COURSE.title);
  const issued=certificate&&certificate.issuedAt?new Date(String(certificate.issuedAt).replace(' ','T')):new Date();
  set('cert-date','Issued '+issued.toLocaleDateString(undefined,{year:'numeric',month:'long',day:'numeric'}));
  const number=(certificate&&certificate.certificateNumber)||STATE.certId||genCertId();
  STATE.certId=number;
  set('cert-id','Certificate ID: '+number);
  saveState();
}
function ensureOfficialCertificate(){
  if(window.__eacOfficialCertificate) return Promise.resolve(window.__eacOfficialCertificate);
  if(typeof token!=='function' || !token() || typeof apiFetch!=='function') return Promise.reject(new Error('Please sign in to download your official certificate.'));
  return apiFetch('/certificates/issue',{method:'POST',body:JSON.stringify({courseId:COURSE_ID})}).then(function(result){
    const certificate=result&&result.certificate;
    if(!certificate||!certificate.id) throw new Error('Certificate could not be issued.');
    window.__eacOfficialCertificate=certificate;
    updateCertificatePreview(certificate);
    return certificate;
  });
}
function populateCert(){
  if(!STATE.certId) STATE.certId=genCertId();
  updateCertificatePreview(null);
  ensureOfficialCertificate().catch(function(error){ console.warn('Official certificate:',error.message); });
}
function downloadOfficialCertificatePdf(){
  const btn=document.getElementById('certPng');
  const original=btn?btn.textContent:'';
  if(btn){btn.disabled=true;btn.textContent='Preparing PDF…';}
  ensureOfficialCertificate().then(function(certificate){
    return fetch(API_ROOT+'/certificates/'+encodeURIComponent(certificate.id)+'/download',{
      headers:{Accept:'application/pdf',Authorization:'Bearer '+token()}
    }).then(function(response){
      if(!response.ok) return response.json().catch(function(){return {};}).then(function(data){throw new Error(data.error||'Could not download certificate.');});
      return response.blob().then(function(blob){return {blob:blob,certificate:certificate};});
    });
  }).then(function(result){
    const url=URL.createObjectURL(result.blob);
    const a=document.createElement('a');
    a.href=url;
    a.download='EAC_Certificate_'+String(result.certificate.certificateNumber||COURSE.code||'certificate').replace(/[^a-z0-9._-]+/gi,'_')+'.pdf';
    document.body.appendChild(a);a.click();a.remove();
    setTimeout(function(){URL.revokeObjectURL(url);},2000);
  }).catch(function(error){
    alert(error.message||'Could not download the certificate.');
  }).finally(function(){if(btn){btn.disabled=false;btn.textContent=original||'⬇ Download certificate (PDF)';}});
}

function initialiseStandaloneHeaderCourseNav(){
  if(window.parent!==window) return;
  const dropdown=document.getElementById('courseNavDropdown');
  const toggle=document.getElementById('courseNavToggle');
  if(dropdown&&toggle&&!toggle.dataset.bound){
    toggle.dataset.bound='1';
    toggle.addEventListener('click',function(event){event.preventDefault();const open=dropdown.classList.toggle('open');toggle.setAttribute('aria-expanded',open?'true':'false');});
    document.addEventListener('click',function(event){if(!dropdown.contains(event.target)){dropdown.classList.remove('open');toggle.setAttribute('aria-expanded','false');}});
  }
  document.querySelectorAll('.course-context-item').forEach(function(item){item.disabled=false;item.setAttribute('aria-disabled','false');});
  document.querySelectorAll('[data-course-action]').forEach(function(item){
    if(item.dataset.courseStandaloneBound)return;
    item.dataset.courseStandaloneBound='1';
    item.addEventListener('click',function(event){
      const action=item.dataset.courseAction;
      if(action==='catalogue')return;
      event.preventDefault();
      if(action==='modules')goTo('hub');
      if(action==='assessment')goTo('assessment');
      if(action==='resources'){
        goTo('hub');
        setTimeout(function(){document.querySelector('.resources')?.scrollIntoView({behavior:'smooth',block:'start'});},80);
      }
      dropdown?.classList.remove('open');toggle?.setAttribute('aria-expanded','false');
    });
  });
}

window.addEventListener('DOMContentLoaded',async()=>{
  await loadDatabaseQuizzes();
  renderQuizzes(); /* bindStaticQuizzes() is legacy-only and intentionally disabled. */ renderDragdrops(); bindStaticDragdrops(); renderReveals(); initVoiceovers(); initFlow();
  initialiseStandaloneHeaderCourseNav();
  const returning=loadState();
  if(returning){ goTo('hub'); } else { goTo('welcome'); }
});

window.saveState=saveState;
window.showScreen=showScreen;
window.updateHub=updateHub;
window.resumeProgress=resumeProgress;
// Expose the navigation primitives for the parent shell, diagnostics and
// backwards compatibility with older embedded course controls.
window.openModule=openModule;
window.gotoSlide=gotoSlide;
window.nextSlide=nextSlide;
window.prevSlide=prevSlide;
window.eacCurrentModuleId=function(){
  return document.getElementById('screen-module')?.classList.contains('active')?(CUR.mid||null):null;
};
window.eacCurrentModuleIsRead=function(){return !!(CUR.mid&&STATE.completed[CUR.mid]);};
window.eacMarkCurrentModuleAsRead=markCurrentModuleRead;

(function(){
  'use strict';
  var syncTimer=null;
  var syncInFlight=null;
  var syncRequested=false;
  var completionQueue=[];
  var coreShowScreen=window.showScreen;
  function user(){ try{return JSON.parse(localStorage.getItem('user')||'null')}catch(e){return null;} }
  function queueModuleCompletion(mid){
    mid=String(mid||'').trim();
    if(!mid||completionQueue.indexOf(mid)!==-1)return;
    completionQueue.push(mid);
  }
  function syncNow(){
    if(!token() || !window.STATE) return Promise.resolve({skipped:true});
    if(syncInFlight){syncRequested=true;return syncInFlight;}
    syncRequested=false;
    var pending=completionQueue.length?completionQueue[0]:null;
    var body={currentPosition:window.STATE.pos||null};
    if(pending) body.completedModuleId=pending;
    syncInFlight=apiFetch('/courses/'+COURSE_ID+'/learning-state',{method:'PUT',keepalive:true,body:JSON.stringify(body)}).then(function(result){
      if(pending && completionQueue[0]===pending) completionQueue.shift();
      if(result && result.completedModules) { window.STATE.completed=result.completedModules; }
      if(result && result.progress!=null) window.STATE.serverProgress=Number(result.progress)||0;
      if(window.parent&&window.parent!==window)window.parent.postMessage({type:'eacProgress',courseId:COURSE_ID,progress:Number(result&&result.progress||0)},location.origin);
      return result;
    }).finally(function(){
      syncInFlight=null;
      if(syncRequested||completionQueue.length) scheduleSync();
    });
    return syncInFlight;
  }
  function syncAllQueued(){
    return syncNow().then(function(){return completionQueue.length?syncAllQueued():null;});
  }
  function markAllModulesAsRead(){
    if(!token()) return Promise.reject(new Error('Please sign in before marking modules as read.'));
    var moduleIds=moduleOrder();
    if(!moduleIds.length || !window.STATE) return Promise.reject(new Error('Course modules are not ready yet.'));
    clearTimeout(syncTimer);
    // Drain normal progress writes first, then submit every remaining module in
    // page order. The API keeps the database completion record sequential.
    return syncAllQueued().then(loadBackendState).then(function(){
      if(!window.STATE.completed) window.STATE.completed={};
      var remaining=moduleIds.filter(function(mid){return !window.STATE.completed[mid];});
      return remaining.reduce(function(chain,mid){
        return chain.then(function(){
          return apiFetch('/courses/'+COURSE_ID+'/learning-state',{
            method:'PUT',
            body:JSON.stringify({completedModuleId:mid,currentPosition:null})
          }).then(function(result){
            if(result&&result.completedModules) window.STATE.completed=result.completedModules;
            else window.STATE.completed[mid]=true;
            if(result&&result.progress!=null) window.STATE.serverProgress=Number(result.progress)||0;
          });
        });
      },Promise.resolve());
    }).then(function(){
      window.STATE.pos=null;
      if(typeof window.saveState==='function') window.saveState();
      if(typeof window.updateHub==='function') window.updateHub();
      if(window.parent&&window.parent!==window){
        window.parent.postMessage({type:'eacProgress',courseId:COURSE_ID,progress:100},location.origin);
      }
      // This only opens the final assessment. The certificate still requires a
      // passed assessment and remains protected by the server.
      window.showScreen('assessment');
    }).catch(function(error){
      if(typeof window.updateHub==='function') window.updateHub();
      throw error;
    });
  }
  // The parent course toolbar owns the visible shortcut so it stays available
  // while the learner is inside a module as well as on the course hub.
  window.eacMarkAllModulesAsRead=markAllModulesAsRead;
  window.eacQueueModuleCompletion=function(mid){
    queueModuleCompletion(mid);
    syncNow().catch(function(e){ console.warn('Module completion sync:',e.message); });
  };
  window.eacFlushProgress=syncNow;

  // Dashboard -> Continue can explicitly provide the server-saved position.
  // Restore it only for this course and only after the authenticated state is
  // available, preventing a fresh login from reopening slide 1.
  window.addEventListener('message',function(event){
    var data=event.data||{};
    if(data.type!=='eacResume' || Number(data.courseId)!==COURSE_ID) return;
    if(event.origin!==location.origin || !window.STATE) return;
    var pos=data.currentPosition;
    if(!pos || !pos.mid || !Number.isFinite(Number(pos.i))) return;
    loadBackendState().then(function(){
      if(window.STATE.completed && window.STATE.completed[pos.mid]) return;
      window.STATE.pos={mid:String(pos.mid),i:Number(pos.i)};
      if(typeof window.saveState==='function') window.saveState();
      if(typeof window.updateHub==='function') window.updateHub();
      if(typeof window.resumeProgress==='function') window.resumeProgress();
    }).catch(function(e){console.warn('Explicit resume failed:',e.message);});
  });
  window.saveCourseProgress=function(){
    if(typeof window.saveState==='function') window.saveState();
    var btn=document.getElementById('saveProgressBtn');
    if(!token()){if(btn){btn.textContent='⚠ Login required';setTimeout(function(){btn.textContent='💾 Save progress';btn.disabled=false;},2200);}return;}
    if(btn){btn.textContent='Saving...';btn.disabled=true;}
    syncNow().then(function(){if(btn){btn.textContent='✓ Saved to database';setTimeout(function(){btn.textContent='💾 Save progress';btn.disabled=false;},1800);}}).catch(function(e){if(btn){btn.textContent='⚠ Login required';setTimeout(function(){btn.textContent='💾 Save progress';btn.disabled=false;},2200);}else alert(e.message);});
  };
  function scheduleSync(){ clearTimeout(syncTimer); syncTimer=setTimeout(syncNow,350); }
  window.__eacScheduleProgressSync=scheduleSync;
  document.addEventListener('visibilitychange',function(){
    if(document.visibilityState==='hidden'){
      if(typeof window.saveState==='function') window.saveState();
      syncNow().catch(function(e){console.warn('Progress save on hide:',e.message);});
    }
  });
  window.addEventListener('pagehide',function(){
    if(typeof window.saveState==='function') window.saveState();
    syncNow().catch(function(e){console.warn('Progress save on pagehide:',e.message);});
  });
  window.addEventListener('beforeunload',function(){
    if(typeof window.saveState==='function') window.saveState();
    syncNow().catch(function(){});
  });
  function ensureEnrollment(){
    if(!token()) return Promise.resolve();
    return apiFetch('/courses/'+COURSE_ID+'/enroll',{method:'POST'}).catch(function(e){console.warn('Enrollment sync:',e.message);});
  }
  function mergeBackendState(server){
    if(!server || !window.STATE) return;
    var localDone=window.STATE.completed||{};
    var serverDone=server.completedModules||{};
    Object.keys(serverDone).forEach(function(k){if(serverDone[k]) localDone[k]=true;});
    // Replay every locally completed module that is missing from the server.
    // Modules are intentionally open in any order; the final assessment still
    // requires the complete set.
    moduleOrder().forEach(function(mid){
      if(serverDone[mid])return;
      if(localDone[mid]) queueModuleCompletion(mid);
    });
    window.STATE.completed=localDone;
    // Do not let an older database snapshot overwrite a newer local position.
    // A refresh/navigation can happen before a debounced API request finishes.
    // The local copy is therefore retained when it is newer, then synced again.
    var serverUpdatedAt=server.updatedAt?new Date(String(server.updatedAt).replace(' ','T')).getTime():0;
    var localSavedAt=Number(window.STATE.localSavedAt||0);
    var keepNewerLocal=!!(window.STATE.pos && localSavedAt && (!serverUpdatedAt || localSavedAt>serverUpdatedAt+500));
    if(server.currentPosition && !keepNewerLocal) window.STATE.pos=server.currentPosition;
    window.STATE.passed=!!server.assessmentPassed;
    if(server.progress!=null) window.STATE.serverProgress=Number(server.progress)||0;
    window.STATE.testScore=server.assessmentScore!=null?Number(server.assessmentScore):null;
    if(typeof window.saveState==='function') window.saveState();
    if(keepNewerLocal && typeof scheduleSync==='function') scheduleSync();
  }
  function loadBackendState(){
    if(!token()) return Promise.resolve();
    return apiFetch('/courses/'+COURSE_ID+'/learning-state').then(function(d){return d.state||null;}).then(mergeBackendState).catch(function(e){console.warn('Learning state load:',e.message);});
  }
  function syncLearner(overrideUser){
    try{
      var u=(overrideUser!==undefined)?overrideUser:user();
      if(u && window.STATE){
        var parts=String(u.fullName||'Learner').trim().split(/\s+/);
        window.STATE.learner={};
        window.STATE.learner.first=parts[0]||'';
        window.STATE.learner.surname=parts.slice(1).join(' ');
        window.STATE.learner.email=u.email||'';
        window.STATE.learner.org=u.organization||'';
        if(typeof window.saveState==='function') window.saveState();
      }else if(window.STATE && !token()){
        // A real logout must not leave the previous learner visible as a guest.
        window.STATE.learner=null;
        if(typeof window.saveState==='function') window.saveState();
      }
    }catch(e){console.warn('Learner auth sync skipped',e);}
  }
  window.eacSyncAuth=function(pending,authUser){
    syncLearner(authUser);
    ensureEnrollment().then(loadBackendState).then(syncAllQueued).then(function(){
      if(pending){
        if(typeof coreShowScreen==='function') coreShowScreen(pending);
      }
      if(typeof window.updateHub==='function') window.updateHub();
      // Parent-page auth sync happens after the iframe finishes loading. Resume
      // from the database here as well, so Continue Learning never drops the
      // learner back at the course start screen.
      if(!pending && typeof window.resumeProgress==='function') window.resumeProgress();
    });
  };
  window.eacCourseId=COURSE_ID;
  window.__eacOriginalShowScreen=coreShowScreen;
  function refreshNav(id){
    var active=id==='welcome'?'welcome':(id==='hub'||id==='module'?'hub':(id==='assessment'||id==='certificate'?'assessment':null));
    document.querySelectorAll('.topbar .tb-link[data-screen]').forEach(function(b){b.classList.toggle('active',b.dataset.screen===active);});
  }
  window.showScreen=function(id){
    syncLearner();
    if(!token() && ['assessment','certificate'].indexOf(String(id)) !== -1){
      window.__eacPendingScreen=String(id);
      if(window.parent && window.parent !== window){
        window.parent.postMessage({type:'eacAuthRequired', target:String(id)}, location.origin);
      }
      if(typeof coreShowScreen==='function') coreShowScreen('welcome');
      return;
    }
    if(typeof coreShowScreen==='function') coreShowScreen(id);
    refreshNav(id);
    if(id==='hub') setTimeout(function(){var r=document.querySelector('.resources');if(window.__eacScrollResources){window.__eacScrollResources=false;if(r)r.scrollIntoView({behavior:'smooth',block:'start'});}},40);
    scheduleSync();
  };
  var oldSave=window.saveState;
  if(typeof oldSave==='function'){
    window.saveState=function(){oldSave.apply(this,arguments);scheduleSync();};
  }
  function configureTopbar(){
    var top=document.querySelector('.topbar'); if(!top) return;
    var brand=top.querySelector('.tb-brand');
    if(brand){brand.setAttribute('title','Back to EAC Statistics course catalogue'); brand.removeAttribute('data-screen');}
    var img=top.querySelector('img'); if(img){img.src='../images/eac-crest.png'; img.alt='East African Community'; img.removeAttribute('width');img.removeAttribute('height');}
    var sp=top.querySelector('.tb-sp');
    var cat=top.querySelector('.tb-catalogue');
    if(!cat && sp){
      cat=document.createElement('button');cat.type='button';cat.className='tb-link tb-catalogue';cat.textContent='Course Catalogue';
      top.insertBefore(cat,sp);
    }
    if(cat && !cat.dataset.bound){cat.dataset.bound='1';cat.addEventListener('click',function(){if(window.parent&&window.parent!==window){window.parent.postMessage({type:'eacCatalogue'},location.origin);}else location.href='../index.php';});}
    var resourceBtn=top.querySelector('[data-course-resources]');
    if(resourceBtn && !resourceBtn.dataset.bound){resourceBtn.dataset.bound='1';resourceBtn.addEventListener('click',function(){var old=window.__eacOriginalShowScreen;if(typeof old==='function')old('hub');window.__eacScrollResources=true;setTimeout(function(){var r=document.querySelector('.resources');if(r)r.scrollIntoView({behavior:'smooth',block:'start'});},80);});}
    var res=top.querySelector('a[href*="opendataforafrica"]');
    if(res){res.removeAttribute('href');res.removeAttribute('target');res.removeAttribute('rel');res.textContent='Resources';res.addEventListener('click',function(e){e.preventDefault();var old=window.__eacOriginalShowScreen;if(typeof old==='function')old('hub');window.__eacScrollResources=true;setTimeout(function(){var r=document.querySelector('.resources');if(r)r.scrollIntoView({behavior:'smooth',block:'start'});},80);});}
    var home=top.querySelector('[data-screen="welcome"]'); if(home){home.dataset.screen='hub';home.textContent='Home';}
    top.querySelectorAll('.tb-link[data-screen="hub"]').forEach(function(b){b.classList.add('active');});
  }
  function boot(){
    var reg=document.getElementById('screen-register'); if(reg) reg.style.display='none';
    configureTopbar();
    syncLearner();
    if(typeof coreShowScreen==='function') {
      if(user()) coreShowScreen('hub');
      else coreShowScreen('welcome');
    }
    refreshNav(user() ? 'hub' : 'welcome');
    ensureEnrollment().then(loadBackendState).then(function(){if(typeof window.updateHub==='function')window.updateHub();if(typeof window.resumeProgress==='function')window.resumeProgress();});
    var pending=window.__eacPendingScreen; if(pending && user()){window.__eacPendingScreen=null;window.eacSyncAuth(pending);}
  }
  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',boot,{once:true}); else boot();
})();

document.addEventListener('DOMContentLoaded',function(){
  // initFlow owns all data-screen navigation. Do not attach a second assessment
  // handler here: duplicate handlers can start two server assessment sessions
  // and invalidate the first assessment token.
  var save=document.getElementById('saveProgressBtn');
  if(save) save.addEventListener('click',function(){if(typeof window.saveCourseProgress==='function')window.saveCourseProgress();});
});
})();
