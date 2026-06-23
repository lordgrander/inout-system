<x-app-layout>

<style>
    /* ================= Murphy Dark Theme ================= */
:root {
  --murphy-bg: #0e1116;
  --murphy-elev: #141a22;
  --murphy-surface: #192231;
  --murphy-border: #2b3647;
  --murphy-text: #e8ecf1;
  --murphy-muted: #9aa6b2;
  --murphy-accent: #6ea8fe;
  --murphy-accent-2: #8b9dff;
  --murphy-danger: #ff6b6b;
  --murphy-ok: #34d399;
  --murphy-radius-lg: 16px;
  --murphy-radius: 12px;
  --murphy-shadow: 0 10px 30px rgba(0,0,0,.35);
}

/* Scoped dark area so the rest of your site can stay light if needed */
.murphy_scope {
   color: var(--murphy-text);
}

/* Container */
.murphy_container {
  width: 100%;
  max-width: 980px;
  margin-inline: auto;
  padding: 16px;
}

/* Card */
.murphy_card {
  background: linear-gradient(180deg, var(--murphy-elev), var(--murphy-surface));
  border: 1px solid var(--murphy-border);
  border-radius: var(--murphy-radius-lg);
  box-shadow: var(--murphy-shadow);
  overflow: hidden;
}

.murphy_card__header {
  padding: 16px 18px;
  border-bottom: 1px solid var(--murphy-border);
  display: flex; align-items: center; justify-content: space-between;
}
.murphy_title {
  font-size: clamp(1.1rem, 1.4vw + .6rem, 1.35rem);
  font-weight: 700;
  letter-spacing: .2px;
  margin: 0;
}
.murphy_card__body { padding: 18px; }
.murphy_card__footer {
  padding: 14px 18px; border-top: 1px solid var(--murphy-border);
  display: flex; justify-content: flex-end; gap: 10px;
}

/* Field + inputs */
.murphy_field { margin-bottom: 14px; }
.murphy_label {
  display: block; margin-bottom: 6px; font-size: .95rem; color: var(--murphy-text);
}
.murphy_input, .murphy_select, .murphy_textarea {
  width: 100%;
  border-radius: 12px;
  border: 1px solid var(--murphy-border);
  background: #121826;
  color: var(--murphy-text);
  padding: 12px 14px;
  transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
}
.murphy_input::placeholder, .murphy_textarea::placeholder { color: var(--murphy-muted); }
.murphy_input:focus, .murphy_select:focus, .murphy_textarea:focus {
  border-color: var(--murphy-accent);
  box-shadow: 0 0 0 3px rgba(110,168,254,.18);
  outline: none;
}

.murphy_help { margin-top: 6px; font-size: .85rem; color: var(--murphy-muted); }
.murphy_invalid .murphy_input { border-color: var(--murphy-danger); box-shadow: 0 0 0 3px rgba(255,107,107,.16); }

/* Drag & drop zone */
.murphy_dropzone {
  position: relative;
  border: 1px dashed var(--murphy-border);
  background: #111622;
  border-radius: var(--murphy-radius);
  padding: 14px;
  display: grid; gap: 10px;
  transition: border-color .15s ease, background .15s ease;
}
.murphy_dropzone:hover { border-color: var(--murphy-accent-2); background: #121a29; }
.murphy_dropzone input[type="file"] { width: 100%; }
.murphy_dropzone--active { border-color: var(--murphy-accent); background: #152031; }

/* Badges */
.murphy_badge {
  display: inline-flex; align-items: center; gap: .5ch;
  font-size: .8rem; color: var(--murphy-text);
  border: 1px solid var(--murphy-border);
  border-radius: 4px; padding: 4px 10px; background: #0f1522;
}

/* Buttons */
.murphy_btn {
  display: inline-flex; align-items: center; gap: .6ch;
  padding: 10px 16px; border-radius: 4px; border: 1px solid var(--murphy-border);
  font-weight: 700; cursor: pointer; text-decoration: none;
  transition: transform .1s ease, filter .1s ease, box-shadow .12s ease;
}
.murphy_btn:active { transform: translateY(1px); }

.murphy_btn--primary {
  background: linear-gradient(180deg, var(--murphy-accent), var(--murphy-accent-2));
  color: #0a0a0a; border: none;
  box-shadow: 0 6px 16px rgba(110,168,254,.35);
}

.murphy_btn--ghost {
  background: transparent; color: var(--murphy-text);
}

/* Subtle form group spacing on mobile */
@media (min-width: 640px) {
  .murphy_grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
}

/* Smooth hover elev */
.murphy_card.murphy_hover { transition: transform .18s ease, box-shadow .18s ease; }
/* Murphy Modal (dark) */
.murphy_modal .murphy_modal__content {
  background: #121826;
  color: #e8ecf1;
  border: 1px solid #2b3647;
  border-radius: 14px;
  box-shadow: 0 10px 30px rgba(0,0,0,.35);
}
.murphy_modal__header { border-bottom: 1px solid #263043; }
.murphy_modal__footer { border-top: 1px solid #263043; }
.murphy_modal__title { font-weight: 700; letter-spacing: .2px; }
.murphy_modal__muted { color: #9aa6b2; }

.murphy_modal__list {
  margin: 0; padding-left: 1rem; list-style: disc;
}
.murphy_modal__list li {
  margin-bottom: 4px; color: #e8ecf1;
}

.murphy_check {
  display: inline-flex; width: 56px; height: 56px;
  border-radius: 50%; align-items: center; justify-content: center;
  background: linear-gradient(180deg, #34d399, #22c55e);
  color: #0a0a0a; font-weight: 900; font-size: 28px;
  box-shadow: 0 8px 20px rgba(34,197,94,.35);
  user-select: none;
} 
</style>

</x-app-layout>