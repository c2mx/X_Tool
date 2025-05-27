const pipd = document.querySelector('input[name="pipd"]'); //圆管直径
const pipt = document.querySelector('input[name="pipt"]'); //圆管壁厚
const reca = document.querySelector('input[name="reca"]'); //方管边长
const rect = document.querySelector('input[name="rect"]'); //方管壁厚
const len = document.querySelector('input[name="len"]'); //计算长度
const fz = document.querySelector('input[name="fz"]'); //轴向压力

const calc = document.getElementById("calc"); //计算
const clear = document.getElementById("clear"); //清空
const rst = document.getElementById("result"); //结果输出区域
const out_docx = document.getElementById("out_docx"); //输出docx

const out_ix = document.getElementById("ix"); //
const out_rx = document.getElementById("rx"); //
const out_area = document.getElementById("area"); //
const out_kgm = document.getElementById("kgm"); //
const out_lambda = document.getElementById("lambda"); //
const out_sigma = document.getElementById("sigma"); //
const out_phi = document.getElementById("phi"); //
const out_st = document.getElementById("st"); //

const jiemian = document.getElementById("jiemian"); //截面类型选择
const steel = document.getElementById("steel"); //钢材类型选择
const pipeclass = document.getElementById("pipeclass"); //圆管参数输入区域
const rectclass = document.getElementById("rectclass"); //方管参数输入区域

//计算参数
let d = 0; //圆管直径
let pt = 0; //圆管壁厚
let a = 0; //方管边长
let t = 0; //方管壁厚
let l = 0; //计算长度
let f = 0; //轴向压力

let gxj = 0; //轴惯性矩
let hzbj = 0; //回转半径
let mj = 0; //截面面积
let mass = 0; //单位重量
let lambda = 0; //长细比
let sigma = 0; //轴向应力
let wdx = 0; //稳定性应力
let psi_val = 0; //稳定性系数
let xishu = 0;//钢号修正系数,Q235=1, Q345=0.825, Q420=0.748
let fp = 0;//钢材的抗拉，抗压，抗弯强度设计值

let psi_table = [1, 1, 1, 0.999, 0.999, 0.998, 0.997, 0.996, 0.995, 0.994,
    0.992, 0.991, 0.989, 0.987, 0.985, 0.983, 0.981, 0.978, 0.976, 0.973,
    0.970, 0.967, 0.963, 0.960, 0.957, 0.953, 0.950, 0.946, 0.943, 0.939,
    0.936, 0.932, 0.929, 0.925, 0.921, 0.918, 0.914, 0.910, 0.906, 0.903,
    0.899, 0.895, 0.891, 0.886, 0.882, 0.878, 0.874, 0.870, 0.865, 0.861,
    0.856, 0.852, 0.847, 0.842, 0.837, 0.833, 0.828, 0.823, 0.818, 0.812,
    0.807, 0.802, 0.796, 0.791, 0.785, 0.780, 0.774, 0.768, 0.762, 0.757,
    0.751, 0.745, 0.738, 0.732, 0.726, 0.720, 0.713, 0.707, 0.701, 0.694,
    0.687, 0.681, 0.674, 0.668, 0.661, 0.654, 0.648, 0.641, 0.634, 0.628,
    0.621, 0.614, 0.607, 0.601, 0.594, 0.587, 0.581, 0.574, 0.568, 0.561,
    0.555, 0.548, 0.542, 0.535, 0.529, 0.523, 0.517, 0.511, 0.504, 0.498,
    0.492, 0.487, 0.481, 0.475, 0.469, 0.464, 0.458, 0.453, 0.447, 0.442,
    0.436, 0.431, 0.426, 0.421, 0.416, 0.411, 0.406, 0.401, 0.396, 0.392,
    0.387, 0.383, 0.378, 0.374, 0.369, 0.365, 0.361, 0.357, 0.352, 0.348,
    0.344, 0.340, 0.337, 0.333, 0.329, 0.325, 0.322, 0.318, 0.314, 0.311,
    0.308, 0.304, 0.301, 0.297, 0.294, 0.291, 0.288, 0.285, 0.282, 0.279,
    0.276, 0.273, 0.270, 0.267, 0.264, 0.262, 0.259, 0.256, 0.253, 0.251,
    0.248, 0.246, 0.243, 0.241, 0.238, 0.236, 0.234, 0.231, 0.229, 0.227,
    0.225, 0.222, 0.220, 0.218, 0.216, 0.214, 0.212, 0.210, 0.208, 0.206,
    0.204, 0.202, 0.200, 0.198, 0.196, 0.195, 0.193, 0.191, 0.189, 0.188,
    0.186, 0.184, 0.183, 0.181, 0.179, 0.178, 0.176, 0.175, 0.173, 0.172,
    0.170, 0.169, 0.167, 0.166, 0.164, 0.163, 0.162, 0.160, 0.159, 0.158,
    0.156, 0.155, 0.154, 0.152, 0.151, 0.150, 0.149, 0.147, 0.146, 0.145,
    0.144, 0.143, 0.142, 0.141, 0.139, 0.138, 0.137, 0.136, 0.135, 0.134,
    0.133, 0.132, 0.131, 0.130, 0.129, 0.128, 0.127, 0.126, 0.125, 0.124,
    0.123
]

function changejiemian() {
    //截面改变
    if (jiemian.value === "pipe") {
        pipeclass.style.display = "";
        rectclass.style.display = "none";
        rst.style.display = "none";
        out_docx.style.display = "none";
    } else {
        pipeclass.style.display = "none";
        rectclass.style.display = "";
        rst.style.display = "none";
        out_docx.style.display = "none";
    }
}
function cleardata() {
    //清空
    pipd.value = "";
    pipt.value = "";
    reca.value = "";
    rect.value = "";
    len.value = "";
    fz.value = "";
    rst.style.display = "none";
}

function jisuan() {
    //计算参数赋值
    d = Number(pipd.value); //圆管直径
    pt = Number(pipt.value); //圆管壁厚
    a = Number(reca.value); //方管边长
    t = Number(rect.value); //方管壁厚
    l = Number(len.value); //计算长度
    f = Number(fz.value); //轴向压力

    if (steel.value === "Q345B") {
        xishu = 0.825;
    } 
    else if (steel.value === "Q420B") {
        xishu = 0.748;
    }
    else {
        xishu = 1;
    }


    if (jiemian.value === "pipe") {
        //圆管计算
        gxj = (Math.PI * (d ** 4 - (d - 2 * pt) ** 4)) / 64;
        mj = (Math.PI * (d ** 2 - (d - 2 * pt) ** 2)) / 4;
        hzbj = (gxj / mj) ** 0.5;
        mass = mj * 1000 * 7850 * 10 ** -9;
        lambda = l / hzbj;
        sigma = f / mj;
        //长细比超过250则查表无数据
        if (Math.ceil(lambda / xishu) > 250) {
            document.getElementById("result").style.display = "none";
            document.getElementById("nowork").style.display = "";
            document.getElementById("toolong").style.display = "";
            document.getElementById("out_docx").style.display = "none";
            document.getElementById("work").style.display = "none";
        }
        else {
            psi_val = psi_table[Math.ceil(lambda / xishu)];
            wdx = sigma / Number(psi_val);

            if (steel.value === "Q345B") {
                if (pt <= 16) { fp = 305 }
                else if (pt > 16 && pt <= 40) { fp = 295 }
                else if (pt > 40 && pt <= 63) { fp = 290 }
                else if (pt > 63 && pt <= 80) { fp = 280 }
                else if (pt > 80 && pt <= 100) { fp = 270 }
                else { fp = 250 }
            }
            else if (steel.value === "Q420B") {
                if (pt <= 16) { fp = 375 }
                else if (pt > 16 && pt <= 40) { fp = 355 }
                else if (pt > 40 && pt <= 63) { fp = 320 }
                else { fp = 305 }
            }
            else {
                if (pt <= 16) { fp = 215 }
                else if (pt > 16 && pt <= 40) { fp = 205 }
                else if (pt > 40 && pt <= 100) { fp = 200 }
                else { fp = 190 }
            }

            out_ix.textContent = gxj.toFixed(1);
            out_rx.textContent = hzbj.toFixed(1);
            out_area.textContent = mj.toFixed(1);
            out_kgm.textContent = mass.toFixed(1);
            out_lambda.textContent = lambda.toFixed(1);
            out_sigma.textContent = sigma.toFixed(1);
            out_phi.textContent = psi_val;
            out_st.textContent = wdx.toFixed(1);
            if (wdx <= fp) {//满足规范
                document.getElementById("result").style.display = "";
                document.getElementById("out_docx").style.display = "";
                document.getElementById("work").style.display = "";
                document.getElementById("nowork").style.display = "none";
                document.getElementById("toolong").style.display = "none";

            } else {//不满足规范
                document.getElementById("result").style.display = "";
                document.getElementById("nowork").style.display = "";
                document.getElementById("out_docx").style.display = "none";
                document.getElementById("work").style.display = "none";
                document.getElementById("toolong").style.display = "none";
            }

        }


    } else {
        //方管计算
        gxj = (a ** 4 - (a - 2 * t) ** 4) / 12;
        mj = a ** 2 - (a - 2 * t) ** 2;
        hzbj = (gxj / mj) ** 0.5;
        mass = mj * 1000 * 7850 * 10 ** -9;
        lambda = l / hzbj;
        sigma = f / mj;
        //长细比超过250则查表无数据
        if (Math.ceil(lambda / xishu) > 250) {
            document.getElementById("result").style.display = "none";
            document.getElementById("nowork").style.display = "";
            document.getElementById("out_docx").style.display = "none";
            document.getElementById("work").style.display = "none";
            document.getElementById("toolong").style.display = "";
        }
        else {
            psi_val = psi_table[Math.ceil(lambda / xishu)];
            wdx = sigma / Number(psi_val);

            if (steel.value === "Q345B") {
                if (pt <= 16) { fp = 305 }
                else if (pt > 16 && pt <= 40) { fp = 295 }
                else if (pt > 40 && pt <= 63) { fp = 290 }
                else if (pt > 63 && pt <= 80) { fp = 280 }
                else if (pt > 80 && pt <= 100) { fp = 270 }
                else { fp = 250 }
            }
            else if (steel.value === "Q420B") {
                if (pt <= 16) { fp = 375 }
                else if (pt > 16 && pt <= 40) { fp = 355 }
                else if (pt > 40 && pt <= 63) { fp = 320 }
                else { fp = 305 }
            }
            else {
                if (pt <= 16) { fp = 215 }
                else if (pt > 16 && pt <= 40) { fp = 205 }
                else if (pt > 40 && pt <= 100) { fp = 200 }
                else { fp = 190 }
            }

            out_ix.textContent = gxj.toFixed(1);
            out_rx.textContent = hzbj.toFixed(1);
            out_area.textContent = mj.toFixed(1);
            out_kgm.textContent = mass.toFixed(1);
            out_lambda.textContent = lambda.toFixed(1);
            out_sigma.textContent = sigma.toFixed(1);
            out_phi.textContent = psi_val;
            out_st.textContent = wdx.toFixed(1);
            if (wdx <= fp) {//满足规范
                document.getElementById("result").style.display = "";
                document.getElementById("out_docx").style.display = "";
                document.getElementById("work").style.display = "";
                document.getElementById("nowork").style.display = "none";
                document.getElementById("toolong").style.display = "none";
        
            } else {//不满足规范
                document.getElementById("result").style.display = "";
                document.getElementById("nowork").style.display = "";
                document.getElementById("out_docx").style.display = "none";
                document.getElementById("work").style.display = "none";
                document.getElementById("toolong").style.display = "none";
            }
        }


    }


    MathJax.Hub.Queue(["Typeset", MathJax.Hub]); //刷新公式显示
}

function gen_docx() {//输出docx文件
    const now = new Date(); // 创建一个Date对象，表示当前时间

    const year = now.getFullYear();
    const month = ('0' + (now.getMonth() + 1)).slice(-2);
    const day = ('0' + now.getDate()).slice(-2);
    const hours = ('0' + now.getHours()).slice(-2);
    const minutes = ('0' + now.getMinutes()).slice(-2);
    const seconds = ('0' + now.getSeconds()).slice(-2);

    const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

    const dateString = formattedDateTime.toString(); // 将Date对象转换为字符串

    const filename = '杆件稳定性校核-' + dateString;

    if (jiemian.value === "pipe") {//圆管
        const doc = new docx.Document({
            creator: "William Tsui",
            description: "杆件稳定性校核",
            title: "杆件稳定性校核",
            styles: {
                paragraphStyles: [
                    {
                        id: "simple",
                        name: "Simple",
                        basedOn: "Normal",
                        next: "Normal",
                        run: {
                            size: 28,
                            color: "000000",
                        },
                        paragraph: {
                            spacing: {
                                line: 276,
                            },
                        },
                    },
                ],
            },
            sections: [{
                properties: {},
                children: [
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("杆件截面为圆管：直径" + d + "mm，壁厚" + pt + "mm，材质：" + steel.value),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("截面属性："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("I=" + gxj.toFixed(1)),
                                    new docx.MathSuperScript({
                                        children: [new docx.MathRun("mm")],
                                        superScript: [new docx.MathRun("4")],
                                    }),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathSubScript({
                                        children: [new docx.MathRun("i")],
                                        subScript: [new docx.MathRun("x")],
                                    }),
                                    new docx.MathRun("=" + hzbj.toFixed(1) + "mm"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("A=" + mj.toFixed(1)),
                                    new docx.MathSuperScript({
                                        children: [new docx.MathRun("mm")],
                                        superScript: [new docx.MathRun("2")],
                                    }),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("计算长度："),
                            new docx.Math({
                                children: [
                                    new docx.MathRun("L=" + l + "mm"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("由前章节计算结果得最大轴向压力为："),
                            new docx.Math({
                                children: [
                                    new docx.MathRun("F=" + f + "N"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("长细比："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("λ="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("L")],
                                        denominator: [
                                            new docx.MathSubScript({
                                                children: [new docx.MathRun("i")],
                                                subScript: [new docx.MathRun("x")],
                                            }),
                                        ],
                                    }),
                                    new docx.MathRun("="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun(l)],
                                        denominator: [new docx.MathRun(hzbj.toFixed(1))
                                        ],
                                    }),
                                    new docx.MathRun("=" + lambda.toFixed(1) + "<[λ]=150"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        alignment: docx.AlignmentType.RIGHT,
                        children: [
                            new docx.TextRun("满足规范。"),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("查表得稳定系数："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("φ=" + psi_val),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("轴向应力："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("σ="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("F")],
                                        denominator: [new docx.MathRun("A")],
                                    }),
                                    new docx.MathRun("="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun(f)],
                                        denominator: [new docx.MathRun(mj.toFixed(1))
                                        ],
                                    }),
                                    new docx.MathRun("=" + sigma.toFixed(1) + "MPa"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("稳定性："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("F")],
                                        denominator: [new docx.MathRun("φA")],
                                    }),
                                    new docx.MathRun("="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun(f)],
                                        denominator: [new docx.MathRun(psi_val + "×" + mj.toFixed(1))
                                        ],
                                    }),
                                    new docx.MathRun("=" + wdx.toFixed(1) + "MPa<f=" + fp + "MPa"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        alignment: docx.AlignmentType.RIGHT,
                        children: [
                            new docx.TextRun("满足规范。"),
                        ],
                    }),
                ],//section.children
            }]
        });

        docx.Packer.toBlob(doc).then(blob => {
            saveAs(blob, filename);
        });

    } else {//方管
        const doc = new docx.Document({
            creator: "William Tsui",
            description: "杆件稳定性校核",
            title: "杆件稳定性校核",
            styles: {
                paragraphStyles: [
                    {
                        id: "simple",
                        name: "Simple",
                        basedOn: "Normal",
                        next: "Normal",
                        run: {
                            size: 28,
                            color: "000000",
                        },
                        paragraph: {
                            spacing: {
                                line: 276,
                            },
                        },
                    },
                ],
            },
            sections: [{
                properties: {},
                children: [
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("杆件截面为方管：边长" + a + "mm，壁厚" + t + "mm，材质：" + steel.value),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("截面属性："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("I=" + gxj.toFixed(1)),
                                    new docx.MathSuperScript({
                                        children: [new docx.MathRun("mm")],
                                        superScript: [new docx.MathRun("4")],
                                    }),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathSubScript({
                                        children: [new docx.MathRun("i")],
                                        subScript: [new docx.MathRun("x")],
                                    }),
                                    new docx.MathRun("=" + hzbj.toFixed(1) + "mm"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("A=" + mj.toFixed(1)),
                                    new docx.MathSuperScript({
                                        children: [new docx.MathRun("mm")],
                                        superScript: [new docx.MathRun("2")],
                                    }),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("计算长度："),
                            new docx.Math({
                                children: [
                                    new docx.MathRun("L=" + l + "mm"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("由前章节计算结果得最大轴向压力为："),
                            new docx.Math({
                                children: [
                                    new docx.MathRun("F=" + f + "N"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("长细比："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("λ="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("L")],
                                        denominator: [
                                            new docx.MathSubScript({
                                                children: [new docx.MathRun("i")],
                                                subScript: [new docx.MathRun("x")],
                                            }),
                                        ],
                                    }),
                                    new docx.MathRun("="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun(l)],
                                        denominator: [new docx.MathRun(hzbj.toFixed(1))
                                        ],
                                    }),
                                    new docx.MathRun("=" + lambda.toFixed(1) + "<[λ]=150"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        alignment: docx.AlignmentType.RIGHT,
                        children: [
                            new docx.TextRun("满足规范。"),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("查表得稳定系数："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("φ=" + psi_val),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("轴向应力："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathRun("σ="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("F")],
                                        denominator: [new docx.MathRun("A")],
                                    }),
                                    new docx.MathRun("="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun(f)],
                                        denominator: [new docx.MathRun(mj.toFixed(1))
                                        ],
                                    }),
                                    new docx.MathRun("=" + sigma.toFixed(1) + "MPa"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.TextRun("稳定性："),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        children: [
                            new docx.Math({
                                children: [
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("F")],
                                        denominator: [new docx.MathRun("φA")],
                                    }),
                                    new docx.MathRun("="),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun(f)],
                                        denominator: [new docx.MathRun(psi_val + "×" + mj.toFixed(1))
                                        ],
                                    }),
                                    new docx.MathRun("=" + wdx.toFixed(1) + "MPa<f=" + fp + "MPa"),
                                ],
                            }),
                        ],
                    }),
                    new docx.Paragraph({
                        style: "simple",
                        alignment: docx.AlignmentType.RIGHT,
                        children: [
                            new docx.TextRun("满足规范。"),
                        ],
                    }),
                ],//section.children
            }]
        });

        docx.Packer.toBlob(doc).then(blob => {
            saveAs(blob, filename);
        });
    }

}

calc.addEventListener("click", jisuan);
jiemian.addEventListener("change", changejiemian);
clear.addEventListener("click", cleardata);
out_docx.addEventListener("click", gen_docx);