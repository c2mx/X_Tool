const calc = document.getElementById("calc"); //calculate button
const clear = document.getElementById("clear"); //clear button

const out_huo = document.getElementById("huo"); //
const out_wind = document.getElementById("wind"); //
const out_db = document.getElementById("db"); //
const out_f = document.getElementById("f"); //

//2. calculate
function jisuan() {
    let huo = 0;
    let wind = 0;
    let db = 0;
    let f = 0;

    const l = Number(document.querySelector('input[name="l"]').value);
    const b = Number(document.querySelector('input[name="b"]').value);
    const e = Number(document.querySelector('input[name="e"]').value);
    const gb = Number(document.querySelector('input[name="gb"]').value);
    const g = Number(document.querySelector('input[name="g"]').value);
    const r = Number(document.querySelector('input[name="r"]').value);
    const gg = Number(document.querySelector('input[name="gg"]').value);
    const tg = Number(document.querySelector('input[name="tg"]').value);
    const p = Number(document.querySelector('input[name="p"]').value);
    const n = Number(document.querySelector('input[name="n"]').value);
    const t = Number(document.querySelector('input[name="t"]').value);

    if (l * b * e * gb * g * r * gg * tg * p * n * t > 0) {
       
        huo = tg * (g + gg);
        wind = e * l * b * (1+0.59) * 1.2 * p / 9800;
        db = gb * 1000 * 2 * 3.14 * n * (r * 0.55) / (60 * t * 10000);
        f = huo + 0.55 * (wind + db);


        out_huo.textContent = huo.toFixed(2);
        out_wind.textContent = wind.toFixed(2);
        out_db.textContent = db.toFixed(2);
        out_f.textContent = f.toFixed(2);
        
        document.getElementById("result").style.display = "";
    }
}
function cleardata() {
    //clear
    document.querySelector('input[name="l"]').value = "";
    document.querySelector('input[name="b"]').value = "";
    document.querySelector('input[name="gb"]').value = "";
    document.querySelector('input[name="g"]').value = "";
    document.querySelector('input[name="r"]').value = "";
    document.querySelector('input[name="gg"]').value = "";
    document.getElementById("result").style.display = "none";
    console.log("clear");
}

calc.addEventListener("click", jisuan);
clear.addEventListener("click", cleardata);