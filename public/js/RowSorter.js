/**
 *
 * https://www.jqueryscript.net/table/touch-table-row-sorter.html
 */
! function(a, b) {
    "use strict";
    "function" == typeof define && define.amd ? define("RowSorter", b) : "object" == typeof exports ? module.exports = b() : a.RowSorter = b()
}(this, function() {
    "use strict";

    function a(h, k) {
        if (!(this instanceof a)) return new a(h, k);
        if ("string" == typeof h && (h = i(h)), j(h, "table") === !1) throw new Error("Table not found.");
        return h[A] instanceof a ? h[A] : (this._options = t(B, k), this._table = h, this._tbody = h, this._rows = [], this._lastY = !1, this._draggingRow = null, this._firstTouch = !0, this._lastSort = null, this._ended = !0, this._mousedown = s(b, this), this._mousemove = s(d, this), this._mouseup = s(f, this), this._touchstart = s(c, this), this._touchmove = s(e, this), this._touchend = s(g, this), this._touchId = null, this._table[A] = this, void this.init())
    }

    function b(a) {
        return a = a || window.event, this._start(a.target || a.srcElement, a.clientY) ? (a.preventDefault ? a.preventDefault() : a.returnValue = !1, !1) : !0
    }

    function c(a) {
        if (1 === a.touches.length) {
            var b = a.touches[0],
                c = document.elementFromPoint(b.clientX, b.clientY);
            if (this._touchId = b.identifier, this._start(c, b.clientY)) return a.preventDefault ? a.preventDefault() : a.returnValue = !1, !1
        }
        return !0
    }

    function d(a) {
        return a = a || window.event, this._move(a.target || a.srcElement, a.clientY), !0
    }

    function e(a) {
        if (1 === a.touches.length) {
            var b = a.touches[0],
                c = document.elementFromPoint(b.clientX, b.clientY);
            this._touchId === b.identifier && this._move(c, b.clientY)
        }
        return !0
    }

    function f() {
        this._end()
    }

    function g(a) {
        a.changedTouches.length > 0 && this._touchId === a.changedTouches[0].identifier && this._end()
    }

    function h(b) {
        return b instanceof a ? b : ("string" == typeof b && (b = i(b)), j(b, "table") && A in b && b[A] instanceof a ? b[A] : null)
    }

    function i(a) {
        var b = u(document, a);
        return b.length > 0 && j(b[0], "table") ? b[0] : null
    }

    function j(a, b) {
        return a && "object" == typeof a && "nodeName" in a && a.nodeName === b.toUpperCase()
    }

    function k(a, b, c) {
        var d = a.parentNode;
        1 === c ? b.nextSibling ? d.insertBefore(a, b.nextSibling) : d.appendChild(a) : -1 === c && d.insertBefore(a, b)
    }

    function l(a, b) {
        for (var c = a.rows, d = c.length, e = 0; d > e; e++)
            if (b === c[e]) return e;
        return -1
    }

    function m(a, b, c) {
        a.attachEvent ? a.attachEvent("on" + b, c) : a.addEventListener(b, c, !1)
    }

    function n(a, b, c) {
        a.detachEvent ? a.detachEvent("on" + b, c) : a.removeEventListener(b, c, !1)
    }

    function o(a) {
        return a.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "")
    }

    function p(a, b) {
        if (b = o(b), "" === b) return !1;
        if (-1 !== b.indexOf(" ")) {
            for (var c = b.replace(/\s+/g, " ").split(" "), d = 0, e = c.length; e > d; d++)
                if (p(a, c[d]) === !1) return !1;
            return !0
        }
        return a.classList ? !!a.classList.contains(b) : !!a.className.match(new RegExp("(\\s|^)" + b + "(\\s|$)"))
    }

    function q(a, b) {
        if (b = o(b), "" !== b)
            if (-1 === b.indexOf(" ")) p(a, b) === !1 && (a.classList ? a.classList.add(b) : a.className += " " + b);
            else
                for (var c = b.replace(/\s+/g, " ").split(" "), d = 0, e = c.length; e > d; d++) q(a, c[d])
    }

    function r(a, b) {
        if (b = o(b), "" !== b)
            if (-1 === b.indexOf(" ")) p(a, b) && (a.classList ? a.classList.remove(b) : a.className = a.className.replace(new RegExp("(\\s|^)" + b + "(\\s|$)"), " "));
            else
                for (var c = b.replace(/\s+/g, " ").split(" "), d = 0, e = c.length; e > d; d++) r(a, c[d])
    }

    function s(a, b) {
        return Function.prototype.bind ? a.bind(b) : function() {
            a.apply(b, y.slice.call(arguments))
        }
    }

    function t(a, b) {
        if (x) return x.extend({}, a, b);
        var c, d = {};
        for (c in a) a.hasOwnProperty(c) && (d[c] = a[c]);
        if (b && "[object Object]" === Object.prototype.toString.call(b))
            for (c in b) b.hasOwnProperty(c) && (d[c] = b[c]);
        return d
    }

    function u(a, b) {
        return x ? x.makeArray(x(a).find(b)) : a.querySelectorAll(b)
    }

    function v(a, b) {
        var c = 1,
            d = 20,
            e = a;
        for (b = b.toLowerCase(); e.tagName && e.tagName.toLowerCase() !== b;) {
            if (c > d || !e.parentNode) return null;
            e = e.parentNode, c++
        }
        return e
    }

    function w(a, b) {
        if (y.indexOf) return y.indexOf.call(a, b);
        for (var c = 0, d = a.length; d > c; c++)
            if (b === a[c]) return c;
        return -1
    }
    var x = window.jQuery || !1,
        y = Array.prototype,
        z = !!("ontouchstart" in document),
        A = "data-rowsorter",
        B = {
            handler: null,
            tbody: !0,
            tableClass: "sorting-table",
            dragClass: "sorting-row",
            stickTopRows: 0,
            stickBottomRows: 0,
            onDragStart: null,
            onDragEnd: null,
            onDrop: null
        };
    return a.prototype.init = function() {
        if (this._options.tbody) {
            var a = this._table.getElementsByTagName("tbody");
            a.length > 0 && (this._tbody = a[0])
        }
        if ("function" != typeof this._options.onDragStart && (this._options.onDragStart = null), "function" != typeof this._options.onDrop && (this._options.onDrop = null), "function" != typeof this._options.onDragEnd && (this._options.onDragEnd = null), ("number" != typeof this._options.stickTopRows || this._options.stickTopRows < 0) && (this._options.stickTopRows = 0), ("number" != typeof this._options.stickBottomRows || this._options.stickBottomRows < 0) && (this._options.stickBottomRows = 0), m(this._table, "mousedown", this._mousedown), m(document, "mouseup", this._mouseup), z && (m(this._table, "touchstart", this._touchstart), m(this._table, "touchend", this._touchend)), "onselectstart" in document) {
            var b = this;
            m(document, "selectstart", function(a) {
                var c = a || window.event;
                return null !== b._draggingRow ? (c.preventDefault ? c.preventDefault() : c.returnValue = !1, !1) : void 0
            })
        }
    }, a.prototype._start = function(a, b) {
        if (this._draggingRow && this._end(), this._rows = this._tbody.rows, this._rows.length < 2) return !1;
        if (this._options.handler) {
            var c = u(this._table, this._options.handler);
            if (!c || -1 === w(c, a)) return !1
        }
        var d = v(a, "tr"),
            e = l(this._tbody, d);
        return -1 === e || this._options.stickTopRows > 0 && e < this._options.stickTopRows || this._options.stickBottomRows > 0 && e >= this._rows.length - this._options.stickBottomRows ? !1 : (this._draggingRow = d, this._options.tableClass && q(this._table, this._options.tableClass), this._options.dragClass && q(this._draggingRow, this._options.dragClass), this._oldIndex = e, this._options.onDragStart && this._options.onDragStart(this._tbody, this._draggingRow, this._oldIndex), this._lastY = b, this._ended = !1, m(this._table, "mousemove", this._mousemove), z && m(this._table, "touchmove", this._touchmove), !0)
    }, a.prototype._move = function(a, b) {
        if (this._draggingRow) {
            var c = b > this._lastY ? 1 : b < this._lastY ? -1 : 0;
            if (0 !== c) {
                var d = v(a, "tr");
                if (d && d !== this._draggingRow && -1 !== w(this._rows, d)) {
                    var e = !0;
                    if (this._options.stickTopRows > 0 || this._options.stickBottomRows > 0) {
                        var f = l(this._tbody, d);
                        (this._options.stickTopRows > 0 && f < this._options.stickTopRows || this._options.stickBottomRows > 0 && f >= this._rows.length - this._options.stickBottomRows) && (e = !1)
                    }
                    e && k(this._draggingRow, d, c), this._lastY = b
                }
            }
        }
    }, a.prototype._end = function() {
        if (!this._draggingRow) return !0;
        this._options.tableClass && r(this._table, this._options.tableClass), this._options.dragClass && r(this._draggingRow, this._options.dragClass);
        var a = l(this._tbody, this._draggingRow);
        if (a !== this._oldIndex) {
            var b = this._lastSort;
            this._lastSort = {
                previous: b,
                newIndex: a,
                oldIndex: this._oldIndex
            }, this._options.onDrop && this._options.onDrop(this._tbody, this._draggingRow, a, this._oldIndex)
        } else this._options.onDragEnd && this._options.onDragEnd(this._tbody, this._draggingRow, this._oldIndex);
        this._draggingRow = null, this._lastY = !1, this._touchId = null, this._ended = !0, n(this._table, "mousemove", this._mousemove), z && n(this._table, "touchmove", this._touchmove)
    }, a.prototype.revert = function() {
        if (null !== this._lastSort) {
            var a = this._lastSort,
                b = a.oldIndex,
                c = a.newIndex,
                d = this._tbody.rows,
                e = d.length - 1;
            d.length > 1 && (e > b ? this._tbody.insertBefore(d[c], d[b + (c > b ? 0 : 1)]) : this._tbody.appendChild(d[c])), this._lastSort = a.previous
        }
    }, a.prototype.undo = a.prototype.revert, a.prototype.destroy = function() {
        this._table[A] = null, this._ended === !1 && this._end(), n(this._table, "mousedown", this._mousedown), n(document, "mouseup", this._mouseup), z && (n(this._table, "touchstart", this._touchstart), n(this._table, "touchend", this._touchend))
    }, a.revert = function(a, b) {
        var c = h(a);
        if (null === c && b === !1) throw new Error("Table not found.");
        c && c.revert()
    }, a.undo = a.revert, a.destroy = function(a, b) {
        var c = h(a);
        if (null === c && b === !1) throw new Error("Table not found.");
        c && c.destroy()
    }, x && (x.fn.extend({
        rowSorter: function(b) {
            var c = [];
            return this.each(function(d, e) {
                c.push(new a(e, b))
            }), 1 === c.length ? c[0] : c
        }
    }), x.rowSorter = {
        undo: a.undo,
        revert: a.revert,
        destroy: a.destroy
    }), a
});
