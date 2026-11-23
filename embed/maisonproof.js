/* MaisonProof universal badge: add data-maisonproof-id to a positioned product media wrapper. */
(function () {
  'use strict';
  const base = 'https://maisonproof.org'; // Replace with your verified HTTPS domain.
  document.querySelectorAll('[data-maisonproof-id]').forEach(el => {
    const id = el.getAttribute('data-maisonproof-id');
    if (!/^[A-Za-z0-9_-]{1,80}$/.test(id)) return;
    if (el.querySelector('.maisonproof-universal-badge')) return;
    if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
    const a = document.createElement('a');
    a.className = 'maisonproof-universal-badge';
    a.href = `${base}/verify/${encodeURIComponent(id)}`;
    a.target = '_blank'; a.rel = 'noopener noreferrer';
    a.textContent = '✓ View verification';
    a.setAttribute('aria-label', 'View MaisonProof verification record');
    a.title = 'View MaisonProof verification record';
    Object.assign(a.style, {position:'absolute',bottom:'12px',right:'12px',zIndex:'5',background:'#152d4c',color:'#fff',border:'1px solid #d6ad66',borderRadius:'20px',padding:'7px 11px',font:'600 12px system-ui',textDecoration:'none'});
    // Fail closed: no badge unless MaisonProof's own API reports active approval.
    fetch(`${base}/v1/records/${encodeURIComponent(id)}`, {mode:'cors', credentials:'omit', cache:'no-store'})
      .then(r => { if (!r.ok) throw new Error('verification unavailable'); return r.json(); })
      .then(data => { if (data.id === id && data.status === 'authenticated' && data.badge_active === true) { a.textContent = '✓ Vetted by MaisonProof'; el.appendChild(a); } })
      .catch(() => {});
  });
})();
