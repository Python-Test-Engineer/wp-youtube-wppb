var app = (function () {
	'use strict';
	function t() {}
	function e(t) {
		return t();
	}
	function n() {
		return Object.create(null);
	}
	function o(t) {
		t.forEach(e);
	}
	function r(t) {
		return 'function' == typeof t;
	}
	function s(t, e) {
		return t != t ? e == e : t !== e || (t && 'object' == typeof t) || 'function' == typeof t;
	}
	let i, c;
	function u(t, e) {
		return i || (i = document.createElement('a')), (i.href = e), t === i.href;
	}
	function l(t, e) {
		t.appendChild(e);
	}
	function a(t, e, n) {
		t.insertBefore(e, n || null);
	}
	function f(t) {
		t.parentNode.removeChild(t);
	}
	function d(t) {
		return document.createElement(t);
	}
	function p(t) {
		return document.createTextNode(t);
	}
	function m() {
		return p(' ');
	}
	function h(t, e, n, o) {
		return t.addEventListener(e, n, o), () => t.removeEventListener(e, n, o);
	}
	function v(t, e, n) {
		null == n ? t.removeAttribute(e) : t.getAttribute(e) !== n && t.setAttribute(e, n);
	}
	function g(t, e) {
		(e = '' + e), t.wholeText !== e && (t.data = e);
	}
	function $(t, e) {
		t.value = null == e ? '' : e;
	}
	function b(t, e, n) {
		t.classList[n ? 'add' : 'remove'](e);
	}
	function x(t) {
		c = t;
	}
	const y = [],
		_ = [],
		w = [],
		j = [],
		N = Promise.resolve();
	let T = !1;
	function k(t) {
		w.push(t);
	}
	let E = !1;
	const C = new Set();
	function I() {
		if (!E) {
			E = !0;
			do {
				for (let t = 0; t < y.length; t += 1) {
					const e = y[t];
					x(e), A(e.$$);
				}
				for (x(null), y.length = 0; _.length; ) _.pop()();
				for (let t = 0; t < w.length; t += 1) {
					const e = w[t];
					C.has(e) || (C.add(e), e());
				}
				w.length = 0;
			} while (y.length);
			for (; j.length; ) j.pop()();
			(T = !1), (E = !1), C.clear();
		}
	}
	function A(t) {
		if (null !== t.fragment) {
			t.update(), o(t.before_update);
			const e = t.dirty;
			(t.dirty = [-1]), t.fragment && t.fragment.p(t.ctx, e), t.after_update.forEach(k);
		}
	}
	const L = new Set();
	function B(t, e) {
		t && t.i && (L.delete(t), t.i(e));
	}
	function D(t, n, s, i) {
		const { fragment: c, on_mount: u, on_destroy: l, after_update: a } = t.$$;
		c && c.m(n, s),
			i ||
				k(() => {
					const n = u.map(e).filter(r);
					l ? l.push(...n) : o(n), (t.$$.on_mount = []);
				}),
			a.forEach(k);
	}
	function H(t, e) {
		const n = t.$$;
		null !== n.fragment &&
			(o(n.on_destroy), n.fragment && n.fragment.d(e), (n.on_destroy = n.fragment = null), (n.ctx = []));
	}
	function O(t, e) {
		-1 === t.$$.dirty[0] && (y.push(t), T || ((T = !0), N.then(I)), t.$$.dirty.fill(0)),
			(t.$$.dirty[(e / 31) | 0] |= 1 << e % 31);
	}
	function P(e, r, s, i, u, l, a, d = [-1]) {
		const p = c;
		x(e);
		const m = (e.$$ = {
			fragment: null,
			ctx: null,
			props: l,
			update: t,
			not_equal: u,
			bound: n(),
			on_mount: [],
			on_destroy: [],
			on_disconnect: [],
			before_update: [],
			after_update: [],
			context: new Map(r.context || (p ? p.$$.context : [])),
			callbacks: n(),
			dirty: d,
			skip_bound: !1,
			root: r.target || p.$$.root,
		});
		a && a(m.root);
		let h = !1;
		if (
			((m.ctx = s
				? s(e, r.props || {}, (t, n, ...o) => {
						const r = o.length ? o[0] : n;
						return (
							m.ctx &&
								u(m.ctx[t], (m.ctx[t] = r)) &&
								(!m.skip_bound && m.bound[t] && m.bound[t](r), h && O(e, t)),
							n
						);
				  })
				: []),
			m.update(),
			(h = !0),
			o(m.before_update),
			(m.fragment = !!i && i(m.ctx)),
			r.target)
		) {
			if (r.hydrate) {
				const t = (function (t) {
					return Array.from(t.childNodes);
				})(r.target);
				m.fragment && m.fragment.l(t), t.forEach(f);
			} else m.fragment && m.fragment.c();
			r.intro && B(e.$$.fragment), D(e, r.target, r.anchor, r.customElement), I();
		}
		x(p);
	}
	class S {
		$destroy() {
			H(this, 1), (this.$destroy = t);
		}
		$on(t, e) {
			const n = this.$$.callbacks[t] || (this.$$.callbacks[t] = []);
			return (
				n.push(e),
				() => {
					const t = n.indexOf(e);
					-1 !== t && n.splice(t, 1);
				}
			);
		}
		$set(t) {
			var e;
			this.$$set &&
				((e = t), 0 !== Object.keys(e).length) &&
				((this.$$.skip_bound = !0), this.$$set(t), (this.$$.skip_bound = !1));
		}
	}
	function U(e) {
		let n, o, r, s, i, c, h, $, x, y, _, w, j, N, T, k;
		return {
			c() {
				(n = d('div')),
					(o = d('header')),
					(r = d('div')),
					(s = d('img')),
					(c = m()),
					(h = d('div')),
					($ = d('h1')),
					(x = p(e[0])),
					(y = m()),
					(_ = d('h2')),
					(w = p(e[1])),
					(j = m()),
					(N = d('div')),
					(T = d('p')),
					(k = p(e[2])),
					u(s.src, (i = e[3])) || v(s, 'src', i),
					v(s, 'alt', e[0]),
					v(s, 'class', 'svelte-w9fe6u'),
					v(r, 'class', 'thumb svelte-w9fe6u'),
					b(r, 'thumb-placeholder', !e[3]),
					v(h, 'class', 'user-data svelte-w9fe6u'),
					v(o, 'class', 'svelte-w9fe6u'),
					v(N, 'class', 'description svelte-w9fe6u'),
					v(n, 'class', 'contact-card svelte-w9fe6u');
			},
			m(t, e) {
				a(t, n, e),
					l(n, o),
					l(o, r),
					l(r, s),
					l(o, c),
					l(o, h),
					l(h, $),
					l($, x),
					l(h, y),
					l(h, _),
					l(_, w),
					l(n, j),
					l(n, N),
					l(N, T),
					l(T, k);
			},
			p(t, [e]) {
				8 & e && !u(s.src, (i = t[3])) && v(s, 'src', i),
					1 & e && v(s, 'alt', t[0]),
					8 & e && b(r, 'thumb-placeholder', !t[3]),
					1 & e && g(x, t[0]),
					2 & e && g(w, t[1]),
					4 & e && g(k, t[2]);
			},
			i: t,
			o: t,
			d(t) {
				t && f(n);
			},
		};
	}
	function q(t, e, n) {
		let { userName: o } = e,
			{ jobTitle: r } = e,
			{ description: s } = e,
			{ userImage: i } = e;
		return (
			(t.$$set = (t) => {
				'userName' in t && n(0, (o = t.userName)),
					'jobTitle' in t && n(1, (r = t.jobTitle)),
					'description' in t && n(2, (s = t.description)),
					'userImage' in t && n(3, (i = t.userImage));
			}),
			[o, r, s, i]
		);
	}
	class J extends S {
		constructor(t) {
			super(), P(this, t, q, U, s, { userName: 0, jobTitle: 1, description: 2, userImage: 3 });
		}
	}
	function K(t) {
		let e, n, r, s, i, c, u, p, g, b, x, y, _, w, j, N, T, k, E, C, I, A, O, P, S, U;
		return (
			(O = new J({ props: { userName: t[0], jobTitle: t[1], description: t[3], userImage: t[2] } })),
			{
				c() {
					var t;
					(e = d('div')),
						(n = d('div')),
						(r = d('label')),
						(r.textContent = 'User Name'),
						(s = m()),
						(i = d('input')),
						(c = m()),
						(u = d('div')),
						(p = d('label')),
						(p.textContent = 'Job Title'),
						(g = m()),
						(b = d('input')),
						(x = m()),
						(y = d('div')),
						(_ = d('label')),
						(_.textContent = 'Image URL'),
						(w = m()),
						(j = d('input')),
						(N = m()),
						(T = d('div')),
						(k = d('label')),
						(k.textContent = 'Description'),
						(E = m()),
						(C = d('textarea')),
						(I = m()),
						(A = d('div')),
						(t = O.$$.fragment) && t.c(),
						v(r, 'for', 'userName'),
						v(r, 'class', 'svelte-1p2to6r'),
						v(i, 'type', 'text'),
						v(i, 'id', 'userName'),
						v(i, 'class', 'svelte-1p2to6r'),
						v(n, 'class', 'form-control svelte-1p2to6r'),
						v(p, 'for', 'jobTitle'),
						v(p, 'class', 'svelte-1p2to6r'),
						v(b, 'type', 'text'),
						v(b, 'id', 'jobTitle'),
						v(b, 'class', 'svelte-1p2to6r'),
						v(u, 'class', 'form-control svelte-1p2to6r'),
						v(_, 'for', 'image'),
						v(_, 'class', 'svelte-1p2to6r'),
						v(j, 'type', 'text'),
						v(j, 'id', 'image'),
						v(j, 'class', 'svelte-1p2to6r'),
						v(y, 'class', 'form-control svelte-1p2to6r'),
						v(k, 'for', 'desc'),
						v(k, 'class', 'svelte-1p2to6r'),
						v(C, 'rows', '3'),
						v(C, 'id', 'desc'),
						v(C, 'class', 'svelte-1p2to6r'),
						v(T, 'class', 'form-control svelte-1p2to6r'),
						v(e, 'id', 'webform'),
						v(e, 'class', 'svelte-1p2to6r');
				},
				m(o, f) {
					a(o, e, f),
						l(e, n),
						l(n, r),
						l(n, s),
						l(n, i),
						$(i, t[0]),
						l(e, c),
						l(e, u),
						l(u, p),
						l(u, g),
						l(u, b),
						$(b, t[1]),
						l(e, x),
						l(e, y),
						l(y, _),
						l(y, w),
						l(y, j),
						$(j, t[2]),
						l(e, N),
						l(e, T),
						l(T, k),
						l(T, E),
						l(T, C),
						$(C, t[3]),
						l(e, I),
						l(e, A),
						D(O, A, null),
						(P = !0),
						S ||
							((U = [h(i, 'input', t[4]), h(b, 'input', t[5]), h(j, 'input', t[6]), h(C, 'input', t[7])]),
							(S = !0));
				},
				p(t, [e]) {
					1 & e && i.value !== t[0] && $(i, t[0]),
						2 & e && b.value !== t[1] && $(b, t[1]),
						4 & e && j.value !== t[2] && $(j, t[2]),
						8 & e && $(C, t[3]);
					const n = {};
					1 & e && (n.userName = t[0]),
						2 & e && (n.jobTitle = t[1]),
						8 & e && (n.description = t[3]),
						4 & e && (n.userImage = t[2]),
						O.$set(n);
				},
				i(t) {
					P || (B(O.$$.fragment, t), (P = !0));
				},
				o(t) {
					!(function (t, e, n, o) {
						if (t && t.o) {
							if (L.has(t)) return;
							L.add(t),
								(void 0).c.push(() => {
									L.delete(t), o && (n && t.d(1), o());
								}),
								t.o(e);
						}
					})(O.$$.fragment, t),
						(P = !1);
				},
				d(t) {
					t && f(e), H(O), (S = !1), o(U);
				},
			}
		);
	}
	function M(t, e, n) {
		let o = 'Craig West',
			r = 'WordPress and JS Developer',
			s = 'https://i.picsum.photos/id/1/200/300.jpg?hmac=jH5bDkLr6Tgy3oAg5khKCHeunZMHq0ehBZr6vGifPLY',
			i = 'A web developer in Brighton, UK';
		return [
			o,
			r,
			s,
			i,
			function () {
				(o = this.value), n(0, o);
			},
			function () {
				(r = this.value), n(1, r);
			},
			function () {
				(s = this.value), n(2, s);
			},
			function () {
				(i = this.value), n(3, i);
			},
		];
	}
	return new (class extends S {
		constructor(t) {
			super(), P(this, t, M, K, s, {});
		}
	})({ target: document.getElementById('svelte') });
})();
//# sourceMappingURL=bundle.js.map
