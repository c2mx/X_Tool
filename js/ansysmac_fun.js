//全局变量
const macname_dom = document.querySelector('input[name="macname"]');//宏文件名
let macname = '';
let loadkpnum = 0; //加载点数量
let ysnum = 0;//约束点数量
let casenum = 0;//工况数量

const kp1_dom = document.querySelector('input[name="kp1"]');//关键点1编号
const kp2_dom = document.querySelector('input[name="kp2"]');//关键点2编号
const kp3_dom = document.querySelector('input[name="kp3"]');//关键点3编号
const kp4_dom = document.querySelector('input[name="kp4"]');//关键点4编号

const node1_dom = document.querySelector('input[name="node1"]');//约束点1编号
const node2_dom = document.querySelector('input[name="node2"]');//约束点2编号
const node3_dom = document.querySelector('input[name="node3"]');//约束点3编号
const node4_dom = document.querySelector('input[name="node4"]');//约束点4编号
const node5_dom = document.querySelector('input[name="node5"]');//约束点5编号
const node6_dom = document.querySelector('input[name="node6"]');//约束点6编号
const node7_dom = document.querySelector('input[name="node7"]');//约束点7编号
const node8_dom = document.querySelector('input[name="node8"]');//约束点8编号

let kp1 = 0;
let kp2 = 0;
let kp3 = 0;
let kp4 = 0;

let node1 = 0;
let node2 = 0;
let node3 = 0;
let node4 = 0;
let node5 = 0;
let node6 = 0;
let node7 = 0;
let node8 = 0;

let fix = 0;//是否约束旋转

const fv_dom = document.querySelector('input[name="fv"]');//垂直力大小
const fs_dom = document.querySelector('input[name="fs"]');//水平力大小
const m_dom = document.querySelector('input[name="m"]');//弯矩大小
const mk_dom = document.querySelector('input[name="mk"]');//扭矩大小
const fmk_dom = document.querySelector('input[name="fmk"]');//扭矩力大小
let fv = 0;
let fs = 0;
let m = 0;
let mk = 0;
let fmk = 0;

let rf = 0;//是否提取反力结果
let rm = 0;//是否提取反弯矩结果
let af = 0;//是否提取杆件轴力结果
let afnum = 0;//杆件数量
const elem1_dom = document.querySelector('input[name="elem1"]');//杆件1编号
const elem2_dom = document.querySelector('input[name="elem2"]');//杆件2编号
const elem3_dom = document.querySelector('input[name="elem3"]');//杆件3编号
const elem4_dom = document.querySelector('input[name="elem4"]');//杆件4编号
const elem5_dom = document.querySelector('input[name="elem5"]');//杆件5编号
const elem6_dom = document.querySelector('input[name="elem6"]');//杆件6编号
const elem7_dom = document.querySelector('input[name="elem7"]');//杆件7编号
const elem8_dom = document.querySelector('input[name="elem8"]');//杆件8编号

let elem1 = 0;
let elem2 = 0;
let elem3 = 0;
let elem4 = 0;
let elem5 = 0;
let elem6 = 0;
let elem7 = 0;
let elem8 = 0;

let dfx = 0;//整体X向位移
let dfy = 0;//整体y向位移
let dfz = 0;//整体z向位移
let dftotal = 0;//整体合位移
let stotal = 0;//整体合应力

let cpnum = 0;//组件CP数量

let cpnx = 0;//组件CPN X向位移
let cpny = 0;//组件CPN y向位移
let cpnz = 0;//组件CPN z向位移
let cpnt = 0;//组件CPN 合位移
let cpnst = 0;//组件CPN 合应力

//整体截图数量
let ztnum = 0;
//组件截图数量
let zjnum = 0;
//结果数组行数
let rstrow = 0;
//结果数组列数
let rstcol = 0;
//定义mac宏文件变量
let mac = '';

//读取页面输入的参数
function read_input() {
    macname = macname_dom.value;

    if (document.querySelector('input[id="load4"]').checked == true) {
        loadkpnum = 4;
    } else {
        loadkpnum = 1;
    }

    ysnum = Number(document.querySelector('select[id="sel1"]').selectedIndex) + 2;

    if (document.querySelector('input[id="case8"]').checked == true) {
        casenum = 8;
    } else {
        casenum = 360;
    }
    kp1 = Number(kp1_dom.value);
    kp2 = Number(kp2_dom.value);
    kp3 = Number(kp2_dom.value);
    kp4 = Number(kp2_dom.value);

    node1 = Number(node1_dom.value);
    node2 = Number(node2_dom.value);
    node3 = Number(node3_dom.value);
    node4 = Number(node4_dom.value);
    node5 = Number(node5_dom.value);
    node6 = Number(node6_dom.value);
    node7 = Number(node7_dom.value);
    node8 = Number(node8_dom.value);

    if (document.querySelector('input[id="fix"]').checked == false) {
        fix = 0;
    } else {
        fix = 1;
    }

    fv = Number(fv_dom.value);
    fs = Number(fs_dom.value);
    m = Number(m_dom.value);
    mk = Number(mk_dom.value);
    fmk = Number(fmk_dom.value);

    if (document.querySelector('input[id="rf"]').checked == true) {
        rf = 1;
    } else {
        rf = 0;
    }

    if (document.querySelector('input[id="rm"]').checked == true) {
        rm = 1;
    } else {
        rm = 0;
    }

    if (document.querySelector('input[id="af"]').checked == true) {
        af = 1;
    } else {
        af = 0;
    }

    afnum = Number(document.querySelector('select[id="sel2"]').selectedIndex);

    elem1 = Number(elem1_dom.value);
    elem2 = Number(elem2_dom.value);
    elem3 = Number(elem3_dom.value);
    elem4 = Number(elem4_dom.value);
    elem5 = Number(elem5_dom.value);
    elem6 = Number(elem6_dom.value);
    elem7 = Number(elem7_dom.value);
    elem8 = Number(elem8_dom.value);

    if (document.querySelector('input[name="dfx"]').checked == true) {
        dfx = 1;
    } else {
        dfx = 0;
    }
    if (document.querySelector('input[name="dfy"]').checked == true) {
        dfy = 1;
    } else {
        dfy = 0;
    }
    if (document.querySelector('input[name="dfz"]').checked == true) {
        dfz = 1;
    } else {
        dfz = 0;
    }
    if (document.querySelector('input[name="dftotal"]').checked == true) {
        dftotal = 1;
    } else {
        dftotal = 0;
    }
    if (document.querySelector('input[name="stotal"]').checked == true) {
        stotal = 1;
    } else {
        stotal = 0;
    }

    cpnum = Number(document.querySelector('select[id="sel3"]').selectedIndex);
    if (document.querySelector('input[name="cpnx"]').checked == true) {
        cpnx = 1;
    } else {
        cpnx = 0;
    }
    if (document.querySelector('input[name="cpny"]').checked == true) {
        cpny = 1;
    } else {
        cpny = 0;
    }
    if (document.querySelector('input[name="cpnz"]').checked == true) {
        cpnz = 1;
    } else {
        cpnz = 0;
    }
    if (document.querySelector('input[name="cpnt"]').checked == true) {
        cpnt = 1;
    } else {
        cpnt = 0;
    }
    if (document.querySelector('input[name="cpnst"]').checked == true) {
        cpnst = 1;
    } else {
        cpnst = 0;
    }

    //整体截图数量
    ztnum = dfx + dfy + dfz + dftotal + stotal;
    //组件截图数量
    zjnum = cpnum * (cpnx + cpny + cpnz + cpnt + cpnst);
    //结果数组行数
    rstrow = ysnum + af * afnum + (ztnum + zjnum) * 2;
    //结果数组列数
    rstcol = 4 + rm * 3;
    //定义mac宏文件变量
    mac = '';
}

//生成脚本文件并下载
function make_mac() {
    read_input();
    //加载点
    if (loadkpnum == 1) {
        mac = `
a=${kp1}
`
    } else {
        mac = `
a=${kp1}
b=${kp2}
c=${kp3}
d=${kp4}
`
    }

    //载荷
    if (fv) {
        mac += `
f_v=${fv * 10000}
`
    }
    if (fs) {
        mac += `
f_h=${fs * 10000}
`
    }
    if (m && loadkpnum == 1) {
        mac += `
    f_m=${m * 10000000}
    `
    }
    if (mk && loadkpnum == 1) {
        mac += `
f_mk=${mk * 10000000}
`
    }
    if (fmk && loadkpnum == 4) {
        mac += `
    f_mk=${fmk * 10000}
    `
    }


    //约束点
    mac += `
node01=${node1}
node02=${node2}
`

    if (ysnum >= 3) {
        mac += `
node03=${node3}
`
    }
    if (ysnum >= 4) {
        mac += `
node04=${node4}
`
    }
    if (ysnum >= 5) {
        mac += `
node05=${node5}
`
    }
    if (ysnum >= 6) {
        mac += `
node06=${node6}
`
    }
    if (ysnum >= 7) {
        mac += `
node07=${node7}
`
    }
    if (ysnum >= 8) {
        mac += `
node08=${node8}
`
    }

    //杆单元编号
    if (af == 1 && afnum >= 1) {
        mac += `
elem01=${elem1}
`
    }
    if (af == 1 && afnum >= 2) {
        mac += `
elem02=${elem2}
`
    }
    if (af == 1 && afnum >= 3) {
        mac += `
elem03=${elem3}
`
    }
    if (af == 1 && afnum >= 4) {
        mac += `
elem04=${elem4}
`
    }
    if (af == 1 && afnum >= 5) {
        mac += `
elem05=${elem5}
`
    }
    if (af == 1 && afnum >= 6) {
        mac += `
elem06=${elem6}
`
    }
    if (af == 1 && afnum >= 7) {
        mac += `
elem07=${elem7}
`
    }
    if (af == 1 && afnum >= 8) {
        mac += `
elem08=${elem8}
`
    }


    //截图云图数值临时保存变量
    if (ztnum + zjnum > 0 && casenum == 8) {
        for (var i = 1; i <= (ztnum + zjnum) * 2; i++) {
            mac += `
temp${i}=0
`
        }
    }

    if (loadkpnum == 1 && casenum == 8) {
        //一点加载8工况
        one8case();
    }

    if (loadkpnum == 1 && casenum == 360) {
        //一点加载360工况
        one360case();
    }

    if (loadkpnum == 4) {
        //四点加载8工况
        four8case();
    }

    output_mac(mac, macname);


}

function output_mac(mac_var, name_var) {
    //output mac files and download
    let macfilename = name_var + '.mac';
    console.log(macfilename);
    console.log(mac_var);
    const blob = new Blob([mac_var], { type: "text/plain;charset=utf-8" });
    saveAs(blob, macfilename);
}


document.getElementById("make_script").addEventListener("click", make_mac);

