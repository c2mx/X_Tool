//output python scripts
function output_py() {

    //写出python文件
    //8工况====================================================
    if (casenum == 8) {

        let py8 = `
${pyhead}
print('通用8工况ANSYS有限元结果汇总')
print('使用前自行确认可用性')
$docformat
titlist = input('输入上级二级标题编号[例如4.1，4.2，4.3等]: ')
while True:
    try:
        jobname = input('输入Job Name工作名[例如：850，L1250，ZSL1500，file等]：')
        break
    except ValueError:
        print('请输入正确的Job Name工作名')

picnum = 1000

`
        let ttl = ysnum + af * afnum + (ztnum + zjnum) * 2;
        let skip = new Array(0, 1, 2, ttl + 3, ttl + 4, ttl * 2 + 5, ttl * 2 + 6, ttl * 3 + 7, ttl * 3 + 8, ttl * 4 + 9, ttl * 4 + 10, ttl * 5 + 11, ttl * 5 + 12, ttl * 6 + 13, ttl * 6 + 14, ttl * 7 + 15, ttl * 7 + 16, ttl * 8 + 17, ttl * 8 + 18, ttl * 8 + 19, ttl * 9 + 20, ttl * 9 + 21, ttl * 10 + 22, ttl * 10 + 23, ttl * 11 + 24);
        let temp8 = 'skiplist = [' + skip[0];
        for (var n = 1; n < 25; n++) {
            temp8 += ',' + skip[n];
        }
        temp8 += ']';
        py8 += `
${temp8}
try:
    ansys = pd.read_table('TheResult.txt', sep='|', skiprows=skiplist, header=None)
except ValueError:
    print('目录下没有结果文件TheResult.txt')
    sys.exit(0)

`
        let tabi = ysnum + af * afnum;
        py8 += `
tabindex = ${tabi}

`
        if (ztnum + zjnum > 0) {
            py8 += `
for i in range(1, 9):
    calc_book.add_heading(f'{titlist}.{i}.工况{i}', level=3)

`
        }

        let temp1 = 0;
        let temp2 = 1;
        if (ztnum > 0) {
            if (dfx == 1) {
                py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'整体X向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                temp1 += 2;
                temp2 += 2;
            }
            if (dfy == 1) {
                py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'整体Y向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                temp1 += 2;
                temp2 += 2;
            }
            if (dfz == 1) {
                py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'整体Z向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                temp1 += 2;
                temp2 += 2;
            }
            if (dftotal == 1) {
                py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'整体合位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                temp1 += 2;
                temp2 += 2;
            }
            if (stotal == 1) {
                py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'整体合应力{ceil(outnum)}MPa:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                temp1 += 2;
                temp2 += 2;
            }
        }
        if (cpnum > 0) {
            for (var cpn = 1; cpn <= cpnum; cpn++) {
                if (cpnx == 1) {
                    py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'部件${cpn} X向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                    temp1 += 2;
                    temp2 += 2;
                }
                if (cpny == 1) {
                    py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'部件${cpn} Y向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                    temp1 += 2;
                    temp2 += 2;
                }
                if (cpnz == 1) {
                    py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'部件${cpn} Z向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                    temp1 += 2;
                    temp2 += 2;
                }
                if (cpnt == 1) {
                    py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'部件${cpn} 合向位移{ceil(outnum)}mm:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                    temp1 += 2;
                    temp2 += 2;
                }
                if (cpnst == 1) {
                    py8 += `
    maxn = ansys.iloc[tabindex + ${temp1}, 1]
    maxn = abs(maxn)
    minn = ansys.iloc[tabindex + ${temp2}, 1]
    minn = abs(minn)
    outnum = max(maxn, minn)
    calc_book.add_paragraph(f'部件${cpn} 合应力{ceil(outnum)}MPa:',style='Normal')
    calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
    picnum = picnum + 1

`
                    temp1 += 2;
                    temp2 += 2;
                }
            }
        }
        if (ztnum + zjnum > 0) {
            py8 += `
    tabindex = tabindex + ${ttl}

`
        }
        let temprow = 9 * (2 + ysnum);
        py8 += `
calc_book.add_heading(f'{titlist}.9.节点反力汇总', level=3)
rows_num = ${temprow}

`
        if (rm == 1) {
            py8 += `
cols_num = 7

`
        } else {
            py8 += `
cols_num = 4

`
        }
        py8 += `
mytable = calc_book.add_table(rows=rows_num, cols=cols_num, style='Table Grid')
mytable.alignment = WD_TABLE_ALIGNMENT.CENTER
mytable.allow_autofit = False
for r in range(8):
    mytable.cell(0 + r * (2+${ysnum}), 0).text = f'工况-{r + 1}'
    mytable.cell(1 + r * (2+${ysnum}), 0).text = '节点'
    mytable.cell(1 + r * (2+${ysnum}), 1).text = 'F_x(t)'
    mytable.cell(1 + r * (2+${ysnum}), 2).text = 'F_y(t)'
    mytable.cell(1 + r * (2+${ysnum}), 3).text = 'F_z(t)'

`
        if (rm == 1) {
            py8 += `
    mytable.cell(1 + r * (2+${ysnum}), 4).text = 'M_x(t.m)'
    mytable.cell(1 + r * (2+${ysnum}), 5).text = 'M_y(t.m)'
    mytable.cell(1 + r * (2+${ysnum}), 6).text = 'M_z(t.m)'

`
        }
        py8 += `
    for i in range(${ysnum}):
        mytable.cell(2 + i + r * (2+${ysnum}), 0).text = str(int(ansys.iloc[i + r * ${ttl}, 0]))

`
        if (rm == 1) {
            py8 += `
        for j in range(1, 7):
            mytable.cell(2 + i + r * (2+${ysnum}), j).text = str(ansys.iloc[i + r * ${ttl}, j])

`
        } else {
            py8 += `
        for j in range(1, 4):
            mytable.cell(2 + i + r * (2+${ysnum}), j).text = str(ansys.iloc[i + r * ${ttl}, j])

`
        }
        py8 += `
mytable.cell(0 + 8 * (2 + ${ysnum}), 0).text = '包络值'
mytable.cell(1 + 8 * (2 + ${ysnum}), 0).text = '节点'
mytable.cell(1 + 8 * (2 + ${ysnum}), 1).text = 'F_x(t)'
mytable.cell(1 + 8 * (2 + ${ysnum}), 2).text = 'F_y(t)'
mytable.cell(1 + 8 * (2 + ${ysnum}), 3).text = 'F_z(t)'

`
        if (rm == 1) {
            py8 += `
mytable.cell(1 + 8 * (2 + ${ysnum}), 4).text = 'M_x(t.m)'
mytable.cell(1 + 8 * (2 + ${ysnum}), 5).text = 'M_y(t.m)'
mytable.cell(1 + 8 * (2 + ${ysnum}), 6).text = 'M_z(t.m)'

`
        }
        py8 += `
for i in range(${ysnum}):
    mytable.cell(2 + i + 8 * (2 + ${ysnum}), 0).text = str(int(ansys.iloc[i + 10 * ${ttl}, 0]))

`
        if (rm == 1) {
            py8 += `
    for j in range(1, 7):
        mytable.cell(2 + i + 8 * (2 + ${ysnum}), j).text = str(ansys.iloc[i + 10 * ${ttl}, j])

`
        } else {
            py8 += `
    for j in range(1, 4):
        mytable.cell(2 + i + 8 * (2 + ${ysnum}), j).text = str(ansys.iloc[i + 10 * ${ttl}, j])

`
        }
        py8 += `
for c in range(cols_num): 
    for cell in mytable.columns[c].cells:

`
        if (rm == 1) {
            py8 += `
        cell.width = Cm(2.5)

`
        } else {
            py8 += `
        cell.width = Cm(3.5)

`
        }
        py8 += `
        cell.paragraphs[0].paragraph_format.line_spacing_rule = WD_LINE_SPACING.SINGLE
        cell.paragraphs[0].paragraph_format.first_line_indent = Mm(0)
        cell.paragraphs[0].paragraph_format.alignment = WD_PARAGRAPH_ALIGNMENT.CENTER
        cell.vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
for row in mytable.rows:
    row.height = Cm(0.8)

`
        if (af * afnum > 0) {
            py8 += `
calc_book.add_paragraph('', style='Normal')
calc_book.add_paragraph('杆件轴力包络值', style='Normal')
mytable2 = calc_book.add_table(rows=(${af}*${afnum}+1), cols=2, style='Table Grid')
mytable2.alignment = WD_TABLE_ALIGNMENT.CENTER
mytable2.autofit = False
mytable2.cell(0, 0).text = '名称'
mytable2.cell(0, 1).text = '轴向力/t'

`
            for (var n = 1; n <= af * afnum; n++) {
                py8 += `
mytable2.cell(${n}, 0).text = '杆件${n}'
mytable2.cell(${n}, 1).text = str(ceil(ansys.iloc[(${ysnum}+${n}-1) + 10 * ${ttl}, 1]))

`
            }
            py8 += `
for c in range(2):
    for cell in mytable2.columns[c].cells:
        cell.width = Cm(3.5)
        cell.paragraphs[0].paragraph_format.line_spacing_rule = WD_LINE_SPACING.SINGLE
        cell.paragraphs[0].paragraph_format.first_line_indent = Mm(0)
        cell.paragraphs[0].paragraph_format.alignment = WD_PARAGRAPH_ALIGNMENT.CENTER
        cell.vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
for row in mytable2.rows:
    row.height = Cm(0.8)

`
        }
        py8 += `
filename = f'{jobname}计算结果' + strftime('%Y-%m-%d-%H%M%S', localtime())
calc_book.save(f'{filename}.docx')
print(f'计算书生成结束，保存在程序目录下，文件名为{filename}.docx')

`
        //输出py脚本

        let pyfilename = macname + '.py';
        const blob = new Blob([py8], { type: "text/plain;charset=utf-8" });
        saveAs(blob, pyfilename);

    }//8工况结束



    //360工况====================================================
    //输出两个文件：节点反力处理脚本，杆件轴力处理脚本
    if (loadkpnum == 1 && casenum == 360) {
        if (rf == 1) {//反力
            if (rm == 0) {//无反弯矩的工况
                pyn360 = `
import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
from time import strftime
from time import localtime
from time import sleep
from os import chdir
from os.path import dirname
import sys
chdir(dirname(__file__))
try:
    my_data = pd.read_table('NodeRes.txt', sep='|', index_col=[0, 1])
except:
    print('NodeRes.txt不在同目录下')
    sys.exit()
print('开始输出反力图')
for k in range(0, ${ysnum}):
    x = range(0, 360)
    yfx = []
    yfy = []
    yfz = []
    for i in range(0, 360):
        yfx.append(my_data.iloc[i * ${ysnum} + k, 1])
        yfy.append(my_data.iloc[i * ${ysnum} + k, 2])
        yfz.append(my_data.iloc[i * ${ysnum} + k, 3])
    nodenum = int(my_data.iloc[k, 0])
    plt.title(f'Force Reaction of Node {nodenum}')
    print(f'节点{nodenum}反力图绘制完成')
    plt.plot(x,yfx,label='Fx')
    plt.plot(x,yfy,label='Fy')
    plt.plot(x,yfz,label='Fz')
    plt.legend()
    y_min = np.argmin(yfx)
    y_max = np.argmax(yfx)
    show_min = '[' + str(y_min) + ' ' + str(yfx[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfx[y_max]) + ']'
    plt.plot(y_min, yfx[y_min], 'ko')
    plt.plot(y_max, yfx[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfx[y_min]), xytext=(y_min, yfx[y_min]))
    plt.annotate(show_max, xy=(y_max, yfx[y_max]), xytext=(y_max, yfx[y_max]))
    y_min = np.argmin(yfy)
    y_max = np.argmax(yfy)
    show_min = '[' + str(y_min) + ' ' + str(yfy[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfy[y_max]) + ']'
    plt.plot(y_min, yfy[y_min], 'ko')
    plt.plot(y_max, yfy[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfy[y_min]), xytext=(y_min, yfy[y_min]))
    plt.annotate(show_max, xy=(y_max, yfy[y_max]), xytext=(y_max, yfy[y_max]))
    y_min = np.argmin(yfz)
    y_max = np.argmax(yfz)
    show_min = '[' + str(y_min) + ' ' + str(yfz[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfz[y_max]) + ']'
    plt.plot(y_min, yfz[y_min], 'ko')
    plt.plot(y_max, yfz[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfz[y_min]), xytext=(y_min, yfz[y_min]))
    plt.annotate(show_max, xy=(y_max, yfz[y_max]), xytext=(y_max, yfz[y_max]))
    time = strftime('%Y-%m-%d-%H%M%S', localtime())
    plt.savefig(f'Node-{nodenum}-{time}.jpg')
    sleep(2)
    plt.cla()
    plt.close('all')
print('反力图输出结束')

`
                //节点反力图脚本输出文件下载
                let pyfilename = 'NS360.py';
                const blob = new Blob([pyn360], { type: "text/plain;charset=utf-8" });
                saveAs(blob, pyfilename);



            }
            else {//有反弯矩的情况
                pyn360 = `
import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
from time import strftime
from time import localtime
from time import sleep
from os import chdir
from os.path import dirname
import sys
chdir(dirname(__file__))
try:
    my_data = pd.read_table('NodeRes.txt', sep='|', index_col=[0, 1])
except:
    print('NodeRes.txt不在同目录下')
    sys.exit()
print('开始输出反力图')
for k in range(0, ${ysnum}):
    x = range(0, 360)
    yfx = []
    yfy = []
    yfz = []
    for i in range(0, 360):
        yfx.append(my_data.iloc[i * ${ysnum} + k, 1])
        yfy.append(my_data.iloc[i * ${ysnum} + k, 2])
        yfz.append(my_data.iloc[i * ${ysnum} + k, 3])
    nodenum = int(my_data.iloc[k, 0])
    plt.title(f'Force Reaction of Node {nodenum}')
    print(f'节点{nodenum}反力图绘制完成')
    plt.plot(x,yfx,label='Fx')
    plt.plot(x,yfy,label='Fy')
    plt.plot(x,yfz,label='Fz')
    plt.legend()
    y_min = np.argmin(yfx)
    y_max = np.argmax(yfx)
    show_min = '[' + str(y_min) + ' ' + str(yfx[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfx[y_max]) + ']'
    plt.plot(y_min, yfx[y_min], 'ko')
    plt.plot(y_max, yfx[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfx[y_min]), xytext=(y_min, yfx[y_min]))
    plt.annotate(show_max, xy=(y_max, yfx[y_max]), xytext=(y_max, yfx[y_max]))
    y_min = np.argmin(yfy)
    y_max = np.argmax(yfy)
    show_min = '[' + str(y_min) + ' ' + str(yfy[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfy[y_max]) + ']'
    plt.plot(y_min, yfy[y_min], 'ko')
    plt.plot(y_max, yfy[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfy[y_min]), xytext=(y_min, yfy[y_min]))
    plt.annotate(show_max, xy=(y_max, yfy[y_max]), xytext=(y_max, yfy[y_max]))
    y_min = np.argmin(yfz)
    y_max = np.argmax(yfz)
    show_min = '[' + str(y_min) + ' ' + str(yfz[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfz[y_max]) + ']'
    plt.plot(y_min, yfz[y_min], 'ko')
    plt.plot(y_max, yfz[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfz[y_min]), xytext=(y_min, yfz[y_min]))
    plt.annotate(show_max, xy=(y_max, yfz[y_max]), xytext=(y_max, yfz[y_max]))
    time = strftime('%Y-%m-%d-%H%M%S', localtime())
    plt.savefig(f'Force-Reaction-{nodenum}-{time}.jpg')
    sleep(2)
    plt.cla()
    plt.close('all')
print('反力图输出结束')
print('开始输出反弯矩图')
for k in range(0, ${ysnum}):
    x = range(0, 360)
    yfx = []
    yfy = []
    yfz = []
    for i in range(0, 360):
        yfx.append(my_data.iloc[i * ${ysnum} + k, 4])
        yfy.append(my_data.iloc[i * ${ysnum} + k, 5])
        yfz.append(my_data.iloc[i * ${ysnum} + k, 6])
    nodenum = int(my_data.iloc[k, 0])
    plt.title(f'Moment Reaction of Node {nodenum}')
    print(f'节点{nodenum}反弯矩图绘制完成')
    plt.plot(x,yfx,label='Mx')
    plt.plot(x,yfy,label='My')
    plt.plot(x,yfz,label='Mz')
    plt.legend()
    y_min = np.argmin(yfx)
    y_max = np.argmax(yfx)
    show_min = '[' + str(y_min) + ' ' + str(yfx[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfx[y_max]) + ']'
    plt.plot(y_min, yfx[y_min], 'ko')
    plt.plot(y_max, yfx[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfx[y_min]), xytext=(y_min, yfx[y_min]))
    plt.annotate(show_max, xy=(y_max, yfx[y_max]), xytext=(y_max, yfx[y_max]))
    y_min = np.argmin(yfy)
    y_max = np.argmax(yfy)
    show_min = '[' + str(y_min) + ' ' + str(yfy[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfy[y_max]) + ']'
    plt.plot(y_min, yfy[y_min], 'ko')
    plt.plot(y_max, yfy[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfy[y_min]), xytext=(y_min, yfy[y_min]))
    plt.annotate(show_max, xy=(y_max, yfy[y_max]), xytext=(y_max, yfy[y_max]))
    y_min = np.argmin(yfz)
    y_max = np.argmax(yfz)
    show_min = '[' + str(y_min) + ' ' + str(yfz[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(yfz[y_max]) + ']'
    plt.plot(y_min, yfz[y_min], 'ko')
    plt.plot(y_max, yfz[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, yfz[y_min]), xytext=(y_min, yfz[y_min]))
    plt.annotate(show_max, xy=(y_max, yfz[y_max]), xytext=(y_max, yfz[y_max]))
    time = strftime('%Y-%m-%d-%H%M%S', localtime())
    plt.savefig(f'Moment-Reaction-{nodenum}-{time}.jpg')
    sleep(2)
    plt.cla()
    plt.close('all')
print('反弯矩图输出结束')

`
                //节点反力图脚本输出文件下载
                let pyfilename = 'NS360.py';
                const blob = new Blob([pyn360], { type: "text/plain;charset=utf-8" });
                saveAs(blob, pyfilename);

            }
        }
        if (af == 1) {//轴力
            pys360 = `
import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
from time import strftime
from time import localtime
from time import sleep
from os import chdir
from os.path import dirname
import sys
chdir(dirname(__file__))
try:
    my_data = pd.read_table('ElemRes.txt', sep='|', index_col=[0, 1])
except:
    print('ElemRes.txt不在同目录下')
    sys.exit()
print('开始')
for k in range(0, ${afnum}):
    x = range(0, 360)
    y = []
    for i in range(0, 360):
        y.append(my_data.iloc[i * ${afnum} + k, 1])
    elemnum = int(my_data.iloc[k, 0])
    plt.title(f'Axial Force of Element {elemnum}')
    print(f'单元{elemnum}轴力图绘制完成')
    plt.plot(x, y)
    y_min = np.argmin(y)
    y_max = np.argmax(y)
    show_min = '[' + str(y_min) + ' ' + str(y[y_min]) + ']'
    show_max = '[' + str(y_max) + ' ' + str(y[y_max]) + ']'
    plt.plot(y_min, y[y_min], 'ko')
    plt.plot(y_max, y[y_max], 'ko')
    plt.annotate(show_min, xy=(y_min, y[y_min]), xytext=(y_min, y[y_min]))
    plt.annotate(show_max, xy=(y_max, y[y_max]), xytext=(y_max, y[y_max]))
    time = strftime('%Y-%m-%d-%H%M%S', localtime())
    plt.savefig(f'Axial-Force-{elemnum}-{time}.jpg')
    sleep(2)
    plt.cla()
    plt.close('all')
print('结束')

`
            //杆件轴力图脚本输出文件下载
            let pyfilename = 'ES360.py';
            const blob = new Blob([pys360], { type: "text/plain;charset=utf-8" });
            saveAs(blob, pyfilename);


        }//轴力图输出脚本--结束
    }//360工况输出脚本--结束


}


