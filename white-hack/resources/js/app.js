// Thème
const themeBtn = document.getElementById('themeToggle');
if (themeBtn) themeBtn.onclick = () => {
  const r = document.documentElement;
  r.classList.toggle('dark');
  localStorage.setItem('wh_theme', r.classList.contains('dark') ? 'dark' : 'light');
};
if (localStorage.getItem('wh_theme') === 'light') document.documentElement.classList.remove('dark');

// Barre de progression
const progress = document.getElementById('read-progress');
if (progress) {
  const onScroll = () => {
    const el = document.getElementById('lessonContent');
    if (!el) return;
    const h = el.scrollHeight - window.innerHeight;
    const p = Math.min(100, Math.max(0, (window.scrollY - el.offsetTop) / h * 100));
    progress.style.width = `${p}%`;
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

// TOC + scrollspy
const toc = document.getElementById('toc');
const content = document.getElementById('lessonContent');
if (toc && content) {
  const hs = content.querySelectorAll('h2, h3');
  const list = document.createElement('ul');
  hs.forEach(h => {
    if (!h.id) h.id = h.textContent.trim().toLowerCase().replace(/[^\w]+/g,'-');
    const li = document.createElement('li');
    li.className = h.tagName === 'H2' ? 'mt-2' : 'ml-3';
    li.innerHTML = `<a class="text-base-muted hover:text-white" href="#${h.id}">${h.textContent}</a>`;
    list.appendChild(li);
  });
  toc.appendChild(list);

  const obs = new IntersectionObserver(
    entries => entries.forEach(e => {
      const link = toc.querySelector(`a[href="#${e.target.id}"]`);
      if (!link) return;
      if (e.isIntersecting) link.classList.add('text-white');
      else link.classList.remove('text-white');
    }), { rootMargin: "0px 0px -70% 0px", threshold: 0.1 }
  );
  hs.forEach(h=>obs.observe(h));
}

// Outillage lecture
const root = document.getElementById('lessonContent');
const fPlus = document.getElementById('fontPlus');
const fMinus = document.getElementById('fontMinus');
const focus = document.getElementById('focusToggle');
const narrow = document.getElementById('narrowToggle');
let size = 1, narrowOn=false, focusOn=false;

const applyReadPrefs = () => {
  if (!root) return;
  root.style.fontSize = `${size}rem`;
  document.body.classList.toggle('!max-w-3xl', narrowOn);
  document.querySelector('main').classList.toggle('max-w-3xl', narrowOn);
  document.querySelector('header').classList.toggle('opacity-20', focusOn);
};
if (fPlus) fPlus.onclick = () => { size = Math.min(1.4, size+0.05); applyReadPrefs(); };
if (fMinus) fMinus.onclick = () => { size = Math.max(0.9, size-0.05); applyReadPrefs(); };
if (focus) focus.onclick = () => { focusOn = !focusOn; applyReadPrefs(); };
if (narrow) narrow.onclick = () => { narrowOn = !narrowOn; applyReadPrefs(); };

// Copie des blocs code
if (content) {
  content.querySelectorAll('pre').forEach(pre => {
    const btn = document.createElement('button');
    btn.className = 'absolute right-3 top-3 text-xs px-2 py-1 bg-slate-800/70 border border-slate-700 rounded';
    btn.innerText = 'Copier';
    btn.onclick = () => {
      navigator.clipboard.writeText(pre.innerText);
      btn.innerText = 'Copié !'; setTimeout(()=>btn.innerText='Copier',1200);
    };
    pre.classList.add('relative');
    pre.appendChild(btn);
  });
}

// Raccourcis clavier
document.addEventListener('keydown', e => {
  if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
  if (e.key === 'f') { focusOn = !focusOn; applyReadPrefs(); }
  if (e.key === '+') { size = Math.min(1.4, size+0.05); applyReadPrefs(); }
  if (e.key === '-') { size = Math.max(0.9, size-0.05); applyReadPrefs(); }
});
