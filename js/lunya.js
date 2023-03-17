//1. get data
const lunju = document.querySelector('input[name="lunju"]');
const guiju = document.querySelector('input[name="guiju"]');
const wm = document.querySelector('input[name="wm"]');
const nwm = document.querySelector('input[name="nwm"]');
const tg = document.querySelector('input[name="tg"]');
const xzg = document.querySelector('input[name="xzg"]');
const gmax = document.querySelector('input[name="gmax"]');

const calc = document.getElementById("calc"); //计算
const clear = document.getElementById("clear"); //清空

const out_lunju = document.getElementById("lunju"); //
const out_guiju = document.getElementById("guiju"); //
const out_wm = document.getElementById("wm"); //
const out_nwm = document.getElementById("nwm"); //
const out_tg = document.getElementById("tg"); //
const out_xzg = document.getElementById("xzg"); //
const out_gmax = document.getElementById("gmax"); //

const out_fwmax = document.getElementById("fwmax"); //
const out_fwmin = document.getElementById("fwmin"); //
const out_mst = document.getElementById("mst"); //
const out_ws = document.getElementById("ws"); //
const out_fnwmax = document.getElementById("fnwmax"); //
const out_fnwmin = document.getElementById("fnwmin"); //
const out_mnst = document.getElementById("mnst"); //
const out_nws = document.getElementById("nws"); //
const out_fmax = document.getElementById("fmax"); //
const out_fmin = document.getElementById("fmin"); //


//2. calculate
function jisuan() {
    let l = 0;
    let fwmax = 0;
    let fwmin = 0;
    let mst = 0;
    let ws = 0;
    let fnwmax = 0;
    let fnwmin = 0;
    let mnst = 0;
    let nws = 0;
    let fmax = 0;
    let fmin = 0;
    if (lunju * guiju > 0) {
        l = lunju * guiju / Math.sqrt(Math.pow(guiju, 2) + Math.pow(lunju, 2));
        fwmax = (tg + xzg + gmax) / 4 + wm / (2 * l);
        fwmin = (tg + xzg + gmax) / 4 - wm / (2 * l);
        mst = (tg + xzg + gmax) * Math.min(lunju, guiju) / 2;
        ws = mst / wm;
        fnwmax = (tg + xzg) / 4 + nwm / (2 * l);
        fnwmin = (tg + xzg) / 4 - nwm / (2 * l);
        mnst = (tg + $xzg) * Math.min(lunju, guiju) / 2;
        nws = mnst / nwm;
        fmax = Math.max(fwmax, fnwmax);
        fmin = Math.min(fwmin, fnwmin);

        out_lunju.textContent = lunju.toFixed(1);
        out_guiju.textContent = guiju.toFixed(1);
        out_wm.textContent = wm.toFixed(1);
        out_nwm.textContent = nwm.toFixed(1);
        out_tg.textContent = tg.toFixed(1);
        out_xzg.textContent = xzg.toFixed(1);
        out_gmax.textContent = gmax.toFixed(1);

        out_fwmax.textContent = fwmax.toFixed(1);
        out_fwmin.textContent = fwmin.toFixed(1);
        out_mst.textContent = mst.toFixed(1);
        out_ws.textContent = ws.toFixed(1);
        out_fnwmax.textContent = fnwmax.toFixed(1);
        out_fnwmin.textContent = fnwmin.toFixed(1);
        out_mnst.textContent = mnst.toFixed(1);
        out_nws.textContent = nws.toFixed(1);
        out_fmax.textContent = fmax.toFixed(1);
        out_fmin.textContent = fmin.toFixed(1);

        document.getElementById("result").style.display = "";
    }
}
function cleardata() {
    //清空
    lunju.value = "";
    guiju.value = "";
    wm.value = "";
    nwm.value = "";
    tg.value = "";
    xzg.value = "";
    gmax.value = "";
    document.getElementById("result").style.display = "none";
}

calc.addEventListener("click", jisuan);
clear.addEventListener("click", cleardata);