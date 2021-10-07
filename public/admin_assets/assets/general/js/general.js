Vue.use(VeeValidate);
var get_url = $("#get_url").val(), time_to_hide_success_msg = 1100;
const pluck_ = e => s => Array.from(new Set(s.map(s => s[e])));

function sort_number(s, e) {
    return s - e
}

function read_url(s, e) {
    var r = new FileReader;
    r.onload = function (s) {
        $(e).attr("src", s.target.result)
    }, r.readAsDataURL(s.files[0])
}

function get_file_name(s) {
    return s.replace(get_url + "/uploads/", "")
}

function read_mul_url(s, e) {
    var r = new FileReader;
    r.onload = function (s) {
        $(e).attr("src", s.target.result)
    }, r.readAsDataURL(s)
}

function cartesian(o) {
    var n = [];
    return function e(r, d) {
        var a = Object.keys(o[d])[0];
        o[d][a].forEach(function (s) {
            s = Object.assign({}, r, {[a]: s}), d + 1 !== o.length ? e(s, d + 1) : n.push(s)
        })
    }({}, 0), n
}

function handle_response(s) {
    var e = s.status, r = s.auth, d = s.success_msg, a = s.error_msg;
    s.errors;
    return r ? e ? (vm.msg.success = d, $(".success_msg").removeClass("hidden"), $(".error_msg").addClass("hidden"), setTimeout(function () {
        $(".success_msg").addClass("hidden")
    }, 1300), !0) : (vm.msg.error = a, $(".success_msg").addClass("hidden"), $(".error_msg").removeClass("hidden"), setTimeout(function () {
        $(".success_msg").addClass("hidden")
    }, 1300), !1) : (swal("Error", a, "error"), !1)
}

function handle_response_order_details_1(s) {
    var e = s.status, r = s.auth, d = s.success_msg, a = s.error_msg;
    s.errors;
    return r ? e ? (order_details_1.msg.success = d, $(".success_msg").removeClass("hidden"), $(".error_msg").addClass("hidden"), setTimeout(function () {
        $(".success_msg").addClass("hidden"), $(".error_msg").addClass("hidden")
    }, 2e3), !0) : (order_details_1.msg.error = a, $(".success_msg").addClass("hidden"), $(".error_msg").removeClass("hidden"), setTimeout(function () {
        $(".success_msg").addClass("hidden"), $(".error_msg").addClass("hidden")
    }, 2e3), !1) : (swal("Error", a, "error"), !1)
}

function general_handle_response(s, e, r) {
    var d = s.status, a = s.auth, o = s.success_msg, n = s.error_msg;
    s.errors;
    return a ? d ? (vm.msg.success = o, $(e).removeClass("hidden"), $(r).addClass("hidden"), setTimeout(function () {
        $(e).addClass("hidden"), $(r).addClass("hidden")
    }, 1300), !0) : (vm.msg.error = n, $(e).addClass("hidden"), $(r).removeClass("hidden"), setTimeout(function () {
        $(e).addClass("hidden"), $(r).addClass("hidden")
    }, 1300), !1) : (swal("Error", n, "error"), !1)
}

function general_handle_response__(s, e, r) {
    var d = s.status, a = s.auth, o = s.success_msg, n = s.error_msg;
    s.errors;
    return a ? d ? (vue_select_product.msg.success = o, $(e).removeClass("hidden"), $(r).addClass("hidden"), setTimeout(function () {
        $(e).addClass("hidden"), $(r).addClass("hidden")
    }, 1300), !0) : (vue_select_product.msg.error = n, $(e).addClass("hidden"), $(r).removeClass("hidden"), setTimeout(function () {
        $(e).addClass("hidden"), $(r).addClass("hidden")
    }, 1300), !1) : (swal("Error", n, "error"), !1)
}

function full_general_handle_response(s, e, r = !1) {
    var d = s.status, a = s.auth, o = s.success_msg, n = s.error_msg;
    s.errors;
    return a ? d ? (r && (e.msg.success = o, $(".success_msg").removeClass("hidden"), $(".error_msg").addClass("hidden"), setTimeout(function () {
        $(".success_msg").addClass("hidden")
    }, 1300)), !0) : (r && (e.msg.error = n, $(".success_msg").addClass("hidden"), $(".error_msg").removeClass("hidden"), setTimeout(function () {
        $(".success_msg").addClass("hidden")
    }, 1500)), !1) : (swal("Error", n, "error"), !1)
}

function handle_product_response(s) {
    var e = s.status, r = s.auth, d = s.success_msg, a = s.error_msg, s = (s.errors, s.data);
    if (r) {
        if (e) return vm.msg.success = d, $(".success_msg").removeClass("hidden"), $(".error_msg").addClass("hidden"), setTimeout(function () {
            $(".success_msg").addClass("hidden")
        }, 1300), !0;
        vm.msg.error = a, $(".success_msg").addClass("hidden"), $(".error_msg").removeClass("hidden");
        e = "#a" + s.error_tab_id, d = "#m" + s.error_tab_id, s = s.random_id;
        return s && (s = ".get_m_accordion" + s, $(".m-accordion__item-head").addClass("collapsed"), $(".m-accordion__item-head").prop("aria-expanded", "false"), $(".m-accordion__item-head").addClass("collapsed"), $(".m-accordion__item-body").removeClass("show"), $(s).find(".m-accordion__item-head").removeClass("collapsed"), $(s).find(".m-accordion__item-head").prop("aria-expanded", "true"), $(s).find(".m-accordion__item-body").addClass("show")), $(".m-tabs__link").removeClass("active"), $(".m-tabs__link").removeClass("show"), $(".tab-pane").removeClass("active"), $(".tab-pane").removeClass("show"), $(e).addClass("active"), $(e).addClass("show"), $(d).addClass("active"), $(d).addClass("show"), setTimeout(function () {
            $(".success_msg").addClass("hidden")
        }, 2e3), !1
    }
    return swal("Error", a, "error"), !1
}

function hide_success_message(s) {
    $(s).addClass("hidden")
}

function scroll_to_div(s) {
    $("html, body").animate({scrollTop: $(s).offset().top}, 700)
}

function makeid(s) {
    for (var e = "", r = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", d = r.length, a = 0; a < s; a++) e += r.charAt(Math.floor(Math.random() * d));
    return e
}

$(document).ready(function () {
    try {
        $(".multi_select_").select2()
    } catch (s) {
    }
});
