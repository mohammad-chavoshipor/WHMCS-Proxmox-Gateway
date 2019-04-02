/*
 * noVNC: HTML5 VNC client
 * Copyright (C) 2012 Joel Martin
 * Copyright (C) 2015 Samuel Mannehed for Cendio AB
 * Licensed under MPL 2.0 (see LICENSE.txt)
 *
 * See README.md for usage and integration instructions.
 */

/* jslint white: false, browser: true */
/* global window, $D, Util, WebUtil, RFB, Display */
var UI;

(function () {
    "use strict";

    // Load supporting scripts
    window.onscriptsload = function () {
        UI.load();
    };
    Util.load_scripts(["webutil.js"]);
    
    UI = {
        load: function (callback) {
            var token = WebUtil.getQueryVar('token', null);
            var console = WebUtil.getQueryVar('console', null);
            if (token) {
                WebUtil.createCookie('PVEAuthCookie', token, 1);
            }
            var error = WebUtil.getQueryVar('error', null);
            if (error && error !== undefined && error !== null) {
                UI.updateState(null, 'failed', 'loaded',
                        error);
                return;
            }
            var consoleType = "";
            if (WebUtil.getQueryVar('virtualization') == "qemu") {
                consoleType = "kvm";
            } else {
                consoleType = WebUtil.getQueryVar('virtualization');
            }

            if (console === "novnc") {
                console = "novnc=1"
            } else {
                console = "xtermjs=1"
            }

            window.location = "../?console=" + consoleType + "&" + console + "&vmid=" + WebUtil.getQueryVar('vmid') + "&vmname=" + WebUtil.getQueryVar('vmid') + "&node=" + WebUtil.getQueryVar('node') + "";
        },
        updateState: function (rfb, state, oldstate, msg) {
            var klass;
            switch (state) {
                case 'failed':
                case 'fatal':
                    klass = "noVNC_status_error";
                    break;
                case 'normal':
                    klass = "noVNC_status_normal";
                    UI.pveAllowMigratedVMTest = true;
                    break;
                case 'disconnected':
                    $D('noVNC_logo').style.display = "block";
                    $D('noVNC_container').style.display = "none";
                    /* falls through */
                case 'loaded':
                    klass = "noVNC_status_normal";
                    break;
                default:
                    klass = "noVNC_status_warn";
                    break;
            }
            if (typeof (msg) !== 'undefined') {
                $D('noVNC-control-bar').setAttribute("class", klass);
                $D('noVNC_status').innerHTML = msg;
            }

        },
    };
})();
