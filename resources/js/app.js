import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus';

import flatpickr from 'flatpickr';
import TomSelect from 'tom-select';

Alpine.plugin(collapse);
Alpine.plugin(focus);

/*
 | x-datepicker: bootstrap-datepicker replacement (yyyy-mm-dd, readonly input).
 | x-datepicker="'#EndDate'" links this field as the start of a range.
 */
Alpine.directive('datepicker', (el, { expression }, { evaluate }) => {
    el.readOnly = true;
    const linked = expression ? evaluate(expression) : null;
    const fp = flatpickr(el, {
        dateFormat: 'Y-m-d',
        allowInput: false,
        onChange: (dates, str) => {
            const other = linked && document.querySelector(linked);
            if (other?._flatpickr) other._flatpickr.set('minDate', str);
            el.dispatchEvent(new Event('input', { bubbles: true }));
        },
    });
    el._flatpickr = fp;
});

/*
 | x-select2: searchable select (select2 replacement). Keeps the native
 | <select> in sync so x-model / FormData keep working.
 */
Alpine.directive('select2', (el, {}, { cleanup }) => {
    queueMicrotask(() => {
        if (el.tomselect) return;
        const ts = new TomSelect(el, { allowEmptyOption: true, maxOptions: null, controlInput: '<input>' });
        el.addEventListener('ts-refresh', () => {
            ts.clear(true);
            ts.clearOptions();
            ts.sync();
        });
        cleanup(() => ts.destroy());
    });
});

/*
 | toastr replacement: window.toast('success', 'Saved', 'Success Alert')
 */
Alpine.store('toasts', {
    items: [],
    nextId: 1,
    add(type, message, title = '', url = null) {
        const id = this.nextId++;
        this.items.push({ id, type, message, title, url, visible: true });
        setTimeout(() => this.remove(id), url ? 10000 : 5000);
    },
    remove(id) {
        const t = this.items.find(i => i.id === id);
        if (t) t.visible = false;
        setTimeout(() => (this.items = this.items.filter(i => i.id !== id)), 300);
    },
});
window.toast = (type, message, title = '', url = null) => Alpine.store('toasts').add(type, message, title, url);

/*
 | Real-time header: polls /user/live, updates the Tickets / Messages /
 | Notifications badges and pops a toast (plus a desktop notification when the
 | tab is in the background) for anything new.
 */
Alpine.store('live', {
    counts: { tickets: 0, messages: 0, notifications: 0 },
    since: Math.floor(Date.now() / 1000),
    timer: null,
    start(url, counts) {
        this.counts = { ...this.counts, ...counts };
        if (this.timer) return;
        const tick = async () => {
            try {
                const { data } = await window.axios.get(url, { params: { since: this.since } });
                this.since = data.now;
                this.counts = data.counts;
                // The QM approval queue refreshes itself when a request or decision arrives.
                if (data.events.some(e => e.approval)) window.dispatchEvent(new CustomEvent('approvals-changed'));
                data.events.forEach(e => {
                    window.toast(e.type, e.message, e.title, e.url);
                    if (document.hidden && 'Notification' in window && Notification.permission === 'granted') {
                        const n = new Notification(e.title, { body: e.message, icon: document.querySelector('link[rel=icon]')?.href });
                        n.onclick = () => { window.focus(); window.location.href = e.url; };
                    }
                });
            } catch (err) {
                if (err.response?.status === 401) window.location.reload(); // session expired
            }
        };
        this.timer = setInterval(tick, 10000);
        // Ask once for desktop-notification permission, on the first click anywhere.
        if ('Notification' in window && Notification.permission === 'default') {
            document.addEventListener('click', () => Notification.requestPermission(), { once: true });
        }
    },
});

/*
 | Page shell: sidebar collapse (remembered) + fullscreen toggle.
 */
Alpine.data('layout', () => ({
    collapsed: false,
    mobileOpen: false,
    fullscreen: false,
    ready: false, // transitions switch on after the first paint, so nothing slides on page load
    init() {
        try {
            this.collapsed = localStorage.getItem('sidebar-collapsed') === '1';
        } catch (e) {}
        requestAnimationFrame(() => requestAnimationFrame(() => (this.ready = true)));
        document.addEventListener('fullscreenchange', () => (this.fullscreen = !!document.fullscreenElement));
    },
    toggleSidebar() {
        if (window.innerWidth < 992) {
            this.mobileOpen = !this.mobileOpen;
            return;
        }
        this.collapsed = !this.collapsed;
        try {
            localStorage.setItem('sidebar-collapsed', this.collapsed ? '1' : '0');
        } catch (e) {}
    },
    toggleFullscreen() {
        document.fullscreenElement ? document.exitFullscreen() : document.documentElement.requestFullscreen();
    },
}));

/*
 | AJAX form submit with the same response contract as the reference app:
 | { success: bool, message: string, redirect?: string, errors?: {field: [msg]} }
 */
// url/method default to the form's own action / data-method, so they can be bound dynamically.
Alpine.data('ajaxForm', (url = null, method = null) => ({
    busy: false,
    async submit(event) {
        this.busy = true;
        const form = event.target;
        const data = new FormData(form);
        method = method ?? form.dataset.method ?? 'POST';
        if (method !== 'POST') data.append('_method', method);
        try {
            const { data: res } = await window.axios.post(url ?? form.getAttribute('action'), data);
            if (res.success) {
                window.toast('success', res.message, 'Success Alert');
                this.$dispatch('close-modal', '*');
                setTimeout(() => (res.redirect ? (window.location.href = res.redirect) : window.location.reload()), 500);
            } else {
                showErrors(res);
            }
        } catch (err) {
            if (err.response?.status === 422) {
                showErrors(err.response.data);
            } else {
                window.toast('error', 'Something went wrong! Try again.', 'Error Alert');
            }
        } finally {
            this.busy = false;
        }
    },
}));

/*
 | QM approval queue: tabs switch instantly; approve / reject (with a reason) /
 | mark read go over AJAX, then the queue re-renders from the server.
 | It also reloads itself when the header poll brings a new request.
 */
Alpine.data('approvalQueue', (url, tab = 'unread') => {
    let root; // the queue element ($root would be the reject modal when called from inside it)

    return {
        tab,
        busy: false,
        reject: { url: '', reference: '', reason: '' },
        init() {
            root = this.$el;
            window.addEventListener('approvals-changed', () => this.refresh());
        },
        async refresh(force = false) {
            if (!force && root.querySelector('#RejectReason')?.offsetParent) return; // don't swap the list under an open reject form
            try {
                const { data: html } = await window.axios.get(url, { params: { partial: 1, tab: this.tab } });
                const fresh = new DOMParser().parseFromString(html, 'text/html').querySelector('[data-queue-body]');
                if (fresh) root.querySelector('[data-queue-body]').innerHTML = fresh.innerHTML;
            } catch (e) {}
        },
        async post(actionUrl, data = {}, method = 'POST') {
            this.busy = true;
            try {
                const { data: res } = await window.axios.post(actionUrl, { ...data, _method: method });
                if (res.success) {
                    window.toast('success', res.message, 'Success Alert');
                    this.reject = { url: '', reference: '', reason: '' };
                    this.$dispatch('close-modal', '*');
                    await this.refresh(true);
                } else {
                    showErrors(res);
                }
            } catch (err) {
                err.response?.status === 422 ? showErrors(err.response.data) : window.toast('error', 'Something went wrong! Try again.', 'Error Alert');
            } finally {
                this.busy = false;
            }
        },
        openReject(rejectUrl, reference) {
            this.reject = { url: rejectUrl, reference, reason: '' };
            this.$dispatch('open-modal', 'rejectModal');
        },
    };
});

/*
 | Role permission tree: a parent box is ticked when any child is, and
 | toggling it ticks/unticks every permission below it.
 */
Alpine.data('permTree', (initial = []) => ({
    selected: [...initial],
    any(keys) {
        return keys.some(k => this.selected.includes(k));
    },
    setAll(keys, on) {
        this.selected = on
            ? [...new Set([...this.selected, ...keys])]
            : this.selected.filter(k => !keys.includes(k));
    },
}));

/*
 | Cascading item selectors used by Items, Purchase Orders, reports...
 | Parent Category > Category > Brand > Model > Port / Layer / Capacity (> Item).
 | base = url('inventory'); initial = currently selected ids.
 */
Alpine.data('cascade', (base, initial = {}, withItems = false) => ({
    sel: { ParentCatID: '', CategoryID: '', BrandID: '', ModelID: '', PortID: '', LayerID: '', CapacityID: '', ItemID: '', ...initial },
    opts: { categories: [], brands: [], models: [], ports: [], layers: [], capacities: [], items: [] },
    async init() {
        // Restore the chain for edit forms without clearing the saved values.
        const s = { ...this.sel };
        if (s.ParentCatID) await this.load('categories', `getcategorylist/${s.ParentCatID}`);
        if (s.CategoryID) await this.load('brands', `getbrandlist/${s.CategoryID}`);
        if (s.BrandID) await this.load('models', `getmodellist/${s.BrandID}`);
        if (s.ModelID) await this.loadModelDetails(s.ModelID);
        if (withItems) await this.loadItems();
        this.sel = s;
    },
    async load(key, path) {
        try {
            const { data } = await window.axios.get(`${base}/${path}`);
            this.opts[key] = data.data;
        } catch (e) {
            this.opts[key] = [];
        }
    },
    async loadModelDetails(id) {
        const { data } = await window.axios.get(`${base}/getmodeldetails/${id}`);
        this.opts.ports = data.port;
        this.opts.layers = data.layer;
        this.opts.capacities = data.capacity;
    },
    async loadItems() {
        const params = Object.fromEntries(Object.entries(this.sel).filter(([k, v]) => v && k !== 'ItemID'));
        const { data } = await window.axios.get(`${base}/getitemlist`, { params });
        this.opts.items = data.data;
    },
    reset(...keys) {
        keys.forEach(k => {
            this.sel[{ categories: 'CategoryID', brands: 'BrandID', models: 'ModelID', ports: 'PortID', layers: 'LayerID', capacities: 'CapacityID', items: 'ItemID' }[k]] = '';
            this.opts[k] = [];
        });
    },
    async changed(level) {
        if (level === 'ItemID') return; // picking the item itself must not reset it
        const chain = ['categories', 'brands', 'models', 'ports', 'layers', 'capacities'];
        const from = { ParentCatID: 0, CategoryID: 1, BrandID: 2, ModelID: 3 }[level];
        if (from !== undefined) this.reset(...chain.slice(from));
        const v = this.sel[level];
        if (v) {
            if (level === 'ParentCatID') await this.load('categories', `getcategorylist/${v}`);
            if (level === 'CategoryID') await this.load('brands', `getbrandlist/${v}`);
            if (level === 'BrandID') await this.load('models', `getmodellist/${v}`);
            if (level === 'ModelID') await this.loadModelDetails(v);
        }
        if (withItems) {
            this.sel.ItemID = '';
            await this.loadItems();
        }
    },
}));

function showErrors(res) {
    Object.entries(res.errors ?? {}).forEach(([field, messages]) => window.toast('error', messages[0], field));
    if (res.message) window.toast('error', res.message, 'Error Alert');
}

window.Alpine = Alpine;
Alpine.start();
