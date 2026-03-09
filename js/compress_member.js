const pipd = document.querySelector('input[name="pipd"]'); //圆管直径
const pipt = document.querySelector('input[name="pipt"]'); //圆管壁厚
const reca = document.querySelector('input[name="reca"]'); //方管边长
const rect = document.querySelector('input[name="rect"]'); //方管壁厚
const len = document.querySelector('input[name="len"]'); //计算长度
const fz = document.querySelector('input[name="fz"]'); //轴向压力
const considerSelfWeight = document.getElementById('consider-self-weight'); //考虑自重弯矩复选框

const calc = document.getElementById("calc"); //计算
const clear = document.getElementById("clear"); //清空
const rst = document.getElementById("result"); //结果输出区域
const out_docx = document.getElementById("out_docx"); //输出docx

const out_ix = document.getElementById("ix"); //
const out_rx = document.getElementById("rx"); //
const out_area = document.getElementById("area"); //
const out_kgm = document.getElementById("kgm"); //
const out_total_weight = document.getElementById("total-weight"); // 杆件重量
const out_w = document.getElementById("w"); // 抗弯截面模量
const out_lambda = document.getElementById("lambda"); //
const out_sigma = document.getElementById("sigma"); //
const out_self_weight_moment = document.getElementById("self-weight-moment"); //
const out_self_weight_stress = document.getElementById("self-weight-stress"); //
const out_total_stress = document.getElementById("total-stress"); //
const out_phi = document.getElementById("phi"); //
const out_st = document.getElementById("st"); //

const jiemian = document.getElementById("jiemian"); //截面形状选择
const steel = document.getElementById("steel"); //钢材类型选择
const pipeclass = document.getElementById("pipeclass"); //圆管参数输入区域
const rectclass = document.getElementById("rectclass"); //方管参数输入区域
const area_type = document.getElementById('area-type'); //截面类别选择下拉框

const E = 206000;         // 弹性模量
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
let self_weight_moment = 0; //自重弯矩
let self_weight_stress = 0; //自重应力
let W = 0; //抗弯模量
let total_weight = 0; //杆件自重

let fy = 235; //钢材屈服强度，默认Q235
let psi_val = 0; //稳定性系数
let xishu = 0;//钢号修正系数,Q235=1, Q345=0.825, Q420=0.748
let fp = 0;//钢材的抗拉，抗压，抗弯强度设计值

function changejiemian() {
    //截面改变
    if (jiemian.value === "pipe") {
        pipeclass.style.display = "";
        rectclass.style.display = "none";
        rst.style.display = "none";
        out_docx.style.display = "none";
        area_type.value = "type-a"; //重置截面类别选择
    } else {
        pipeclass.style.display = "none";
        rectclass.style.display = "";
        rst.style.display = "none";
        out_docx.style.display = "none";
        area_type.value = "type-b"; //重置截面类别选择
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


function Coef(lambda, sectionType, fy, E = 206000) {
    // 正则化长细比λn = (λ/π) * sqrt(fy/E)
    const lambda_n = (lambda / Math.PI) * Math.sqrt(fy / E);
    
    // 根据截面类别和λn确定系数
    let alpha1, alpha2, alpha3;
    switch(sectionType) {
        case 'type-a':
            alpha1 = 0.41;
            alpha2 = 0.986;
            alpha3 = 0.152;
            break;
        case 'type-b':
            alpha1 = 0.65;
            alpha2 = 0.965;
            alpha3 = 0.300;
            break;
        case 'type-c':
            if (lambda_n <= 1.05) {
                alpha1 = 0.73;
                alpha2 = 0.906;
                alpha3 = 0.595;
                break;
            } else {
                alpha1 = 0.73;
                alpha2 = 1.216;
                alpha3 = 0.302;
                break;
            }
        case 'type-d':
            if (lambda_n <= 1.05) {
                alpha1 = 1.35;
                alpha2 = 0.868;
                alpha3 = 0.915;
                break;
            } else {
                alpha1 = 1.35;
                alpha2 = 1.375;
                alpha3 = 0.432;
                break;
            }
        default:
            throw new Error('无效截面类型');
    }
    let phi;

    // 根据λn选择计算公式
    if (lambda_n <= 0.215) {
        phi = 1 - alpha1 * Math.pow(lambda_n, 2);
    } else {
        const term1 = alpha2 + alpha3 * lambda_n + Math.pow(lambda_n, 2);
        const term2 = Math.sqrt(Math.pow(term1, 2) - 4 * Math.pow(lambda_n, 2));
        phi = (term1 - term2) / (2 * Math.pow(lambda_n, 2));
    }
    // 将结果保留三位小数
    return parseFloat(phi.toFixed(3));
}


function jisuan() {
    //计算参数赋值
    d = Number(pipd.value); //圆管直径
    pt = Number(pipt.value); //圆管壁厚
    a = Number(reca.value); //方管边长
    t = Number(rect.value); //方管壁厚
    l = Number(len.value); //计算长度
    f = Number(fz.value); //轴向压力


    const paramDisplayNames = {
        d: '圆管直径',
        pt: '圆管壁厚', 
        a: '方管边长',
        t: '方管壁厚',
        l: '计算长度',
        f: '轴向压力',
    };

    if (steel.value === "Q345B") {
        fy = 345;
    } 
    else if (steel.value === "Q420B") {
        fy = 420;
    }
    else {
        fy = 235;
    }


    if (jiemian.value === "pipe") {
        //圆管计算
        // Parameters that must be greater than 0
        const greaterThanZeroParams = { d, pt, l, f };
        for (const [name, value] of Object.entries(greaterThanZeroParams)) {
            const displayName = paramDisplayNames[name] || name; 
            if (value <= 0) {
                alert(`参数 "${displayName}" 必须大于 0。当前值为: ${value}`);
                return false;
            }
        }
        // 圆管壁厚不能大于直径的一半，否则提示错误警告
        if (pt >= d / 2) {
            alert("圆管壁厚不能大于直径的一半。");
            return false;
        }
        gxj = (Math.PI * (d ** 4 - (d - 2 * pt) ** 4)) / 64;
        mj = (Math.PI * (d ** 2 - (d - 2 * pt) ** 2)) / 4;
        hzbj = (gxj / mj) ** 0.5;
        mass = mj * 1000 * 7850 * 10 ** -9;
        // 计算抗弯截面模量
        W = (Math.PI * (d ** 4 - (d - 2 * pt) ** 4)) / (32 * d);
        // 计算杆件重量
        total_weight = mass * (l / 1000); // 转换为kg
        lambda = l / hzbj;
        
        // 计算轴向应力
        const axial_stress = f / mj;
        self_weight_moment = 0;
        self_weight_stress = 0;
        
        // 如果考虑自重弯矩，计算弯曲应力并叠加
        if (considerSelfWeight.checked) {
            // 计算单位长度重量（N/m）
            const q = mass * 9.81;
            // 计算自重产生的最大弯矩（N·mm）
            self_weight_moment = (q * (l / 1000) ** 2) * 1000 / 8; // 转换为N·mm
            // 计算抗弯截面系数
            // 计算弯曲应力
            self_weight_stress = self_weight_moment / W;
            // 叠加应力
            sigma = axial_stress + self_weight_stress;
        } else {
            sigma = axial_stress;
        }
        
        psi_val = Coef(lambda, area_type.value, fy, E);
        // 计算稳定性：轴向应力除以稳定系数，弯曲应力直接叠加
        wdx = (axial_stress / Number(psi_val)) + self_weight_stress;


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
            out_total_weight.textContent = total_weight.toFixed(1);
            out_w.textContent = W.toFixed(1);
            out_lambda.textContent = lambda.toFixed(1);
            out_sigma.textContent = axial_stress.toFixed(1);
            
            // 控制自重相关项的显示和隐藏
            if (considerSelfWeight.checked) {
                out_self_weight_moment.parentNode.style.display = "";
                out_self_weight_stress.parentNode.style.display = "";
                out_total_stress.parentNode.style.display = "";
                out_self_weight_moment.textContent = self_weight_moment.toFixed(1);
                out_self_weight_stress.textContent = self_weight_stress.toFixed(1);
                out_total_stress.textContent = sigma.toFixed(1);
            } else {
                out_self_weight_moment.parentNode.style.display = "none";
                out_self_weight_stress.parentNode.style.display = "none";
                out_total_stress.parentNode.style.display = "none";
            }
            
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

      


    } else {
        //方管计算
        // Parameters that must be greater than 0
        const greaterThanZeroParams = { a, t, l, f };
        for (const [name, value] of Object.entries(greaterThanZeroParams)) {
            const displayName = paramDisplayNames[name] || name; 
            if (value <= 0) {
                alert(`参数 "${displayName}" 必须大于 0。当前值为: ${value}`);
                return false;
            }
        }
        // 方管壁厚不能大于边长的一半，否则提示错误警告
        if (t >= a / 2) {
            alert("方管壁厚不能大于边长的一半。");
            return false;
        }
        gxj = (a ** 4 - (a - 2 * t) ** 4) / 12;
        mj = a ** 2 - (a - 2 * t) ** 2;
        hzbj = (gxj / mj) ** 0.5;
        mass = mj * 1000 * 7850 * 10 ** -9;
        // 计算抗弯截面模量
        W = (a ** 4 - (a - 2 * t) ** 4) / (6 * a);
        // 计算杆件重量
        total_weight = mass * (l / 1000); // 转换为kg
        lambda = l / hzbj;
        
        // 计算轴向应力
        const axial_stress = f / mj;
        self_weight_moment = 0;
        self_weight_stress = 0;
        
        // 如果考虑自重弯矩，计算弯曲应力并叠加
        if (considerSelfWeight.checked) {
            // 计算单位长度重量（N/m）
            const q = mass * 9.81;
            // 计算自重产生的最大弯矩（N·mm）
            self_weight_moment = (q * (l / 1000) ** 2) * 1000 / 8; // 转换为N·mm
            // 计算弯曲应力
            self_weight_stress = self_weight_moment / W;
            // 叠加应力
            sigma = axial_stress + self_weight_stress;
        } else {
            sigma = axial_stress;
        }
        
        psi_val = Coef(lambda, area_type.value, fy, E);
        // 计算稳定性：轴向应力除以稳定系数，弯曲应力直接叠加
        wdx = (axial_stress / Number(psi_val)) + self_weight_stress;


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
            out_total_weight.textContent = total_weight.toFixed(1);
            out_w.textContent = W.toFixed(1);
            out_lambda.textContent = lambda.toFixed(1);
            out_sigma.textContent = axial_stress.toFixed(1);
            
            // 控制自重相关项的显示和隐藏
            if (considerSelfWeight.checked) {
                out_self_weight_moment.parentNode.style.display = "";
                out_self_weight_stress.parentNode.style.display = "";
                out_total_stress.parentNode.style.display = "";
                out_self_weight_moment.textContent = self_weight_moment.toFixed(1);
                out_self_weight_stress.textContent = self_weight_stress.toFixed(1);
                out_total_stress.textContent = sigma.toFixed(1);
            } else {
                out_self_weight_moment.parentNode.style.display = "none";
                out_self_weight_stress.parentNode.style.display = "none";
                out_total_stress.parentNode.style.display = "none";
            }
            
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
                            new docx.Math({
                                children: [
                                    new docx.MathRun("W=" + W.toFixed(1)),
                                    new docx.MathSuperScript({
                                        children: [new docx.MathRun("mm")],
                                        superScript: [new docx.MathRun("3")],
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
                            new docx.TextRun("杆件自重："),
                            new docx.Math({
                                children: [
                                    new docx.MathRun("G=" + total_weight.toFixed(1) + "kg"),
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
                            new docx.TextRun("截面强度："),
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
                                    new docx.MathRun("+"),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("GL/8")],
                                        denominator: [new docx.MathRun("W")],
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
                                    new docx.MathRun("+"),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("GL/8")],
                                        denominator: [new docx.MathRun("W")],
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
                            new docx.Math({
                                children: [
                                    new docx.MathRun("W=" + W.toFixed(1)),
                                    new docx.MathSuperScript({
                                        children: [new docx.MathRun("mm")],
                                        superScript: [new docx.MathRun("3")],
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
                            new docx.TextRun("杆件自重："),
                            new docx.Math({
                                children: [
                                    new docx.MathRun("G=" + total_weight.toFixed(1) + "kg"),
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
                            new docx.TextRun("截面强度："),
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
                                    new docx.MathRun("+"),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("GL/8")],
                                        denominator: [new docx.MathRun("W")],
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
                                    new docx.MathRun("+"),
                                    new docx.MathFraction({
                                        numerator: [new docx.MathRun("GL/8")],
                                        denominator: [new docx.MathRun("W")],
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

function gen_docx2() {//输出docx文件
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
out_docx.addEventListener("click", function() {
    if (considerSelfWeight.checked) {
        gen_docx();
    } else {
        gen_docx2();
    }
});