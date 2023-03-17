//四点加载8工况
function four8case() {
    mac += `
X4 = 10000
X7 = 10000000
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('-----REACTION-SOLUTIONS-----')
*CFCLOS
`
    for (var i = 1; i <= 8; i++) {
        mac += `
/SOLU
FK,a,FZ,-f_v/4
FK,b,FZ,-f_v/4
FK,c,FZ,-f_v/4
FK,d,FZ,-f_v/4
`
        if (i == 1) {
            mac += `
FK,a,FX,0
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m
FK,a,FY,-f_h/2-f_m
FK,b,FY,-f_h/2
FK,c,FY,f_m
FK,d,FY,0
`
        }
        if (i == 2) {
            mac += `
FK,a,FX,0
FK,b,FX,f_m+f_h/2.828
FK,c,FX,f_h/2.828
FK,d,FX,-f_m
FK,a,FY,-f_h/2.828-f_m
FK,b,FY,-f_h/2.828
FK,c,FY,f_m
FK,d,FY,0
`
        }
        if (i == 3) {
            mac += `
FK,a,FX,0
FK,b,FX,f_m+f_h/2
FK,c,FX,f_h/2
FK,d,FX,-f_m
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m
FK,d,FY,0
`
        }
        if (i == 4) {
            mac += `
FK,a,FX,0
FK,b,FX,f_m+f_h/2.828
FK,c,FX,f_h/2.828
FK,d,FX,-f_m
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m+f_h/2.828
FK,d,FY,f_h/2.828
`
        }
        if (i == 5) {
            mac += `
FK,a,FX,0
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m+f_h/2
FK,d,FY,f_h/2
`
        }
        if (i == 6) {
            mac += `
FK,a,FX,-f_h/2.828
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m-f_h/2.828
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m+f_h/2.828
FK,d,FY,f_h/2.828
`
        }
        if (i == 7) {
            mac += `
FK,a,FX,-f_h/2
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m-f_h/2
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m
FK,d,FY,0
`
        }
        if (i == 8) {
            mac += `
FK,a,FX,-f_h/2.828
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m-f_h/2.828
FK,a,FY,-f_m-f_h/2.828
FK,b,FY,-f_h/2.828
FK,c,FY,f_m
FK,d,FY,0
`
        }
        mac += `
SOLVE
/POST1
`
        //截图计数辅助变量
        let shotnum1 = 1;
        let shotnum2 = 2;
        //整体截图
        if (dfx == 1) {
            mac += `
ALLSEL,ALL
PLNSOL,U,X,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
 `
            shotnum1 += 2;
            shotnum2 += 2;
        }
        if (dfy == 1) {
            mac += `
ALLSEL,ALL
PLNSOL,U,Y,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
 `
            shotnum1 += 2;
            shotnum2 += 2;
        }
        if (dfz == 1) {
            mac += `
ALLSEL,ALL
PLNSOL,U,Z,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
            shotnum1 += 2;
            shotnum2 += 2;
        }
        if (dftotal == 1) {
            mac += `
ALLSEL,ALL
PLNSOL,U,SUM,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
            shotnum1 += 2;
            shotnum2 += 2;
        }
        if (stotal == 1) {
            mac += `
ALLSEL,ALL
PLNSOL,S,EQV
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
            shotnum1 += 2;
            shotnum2 += 2;
        }
        //组件截图
        if (cpnum > 0) {
            for (var k = 1; k <= cpnum; k++) {
                if (cpnx == 1) {
                    mac += `
CMSEL,S,CP${k}
ESEL,ALL
ESLL,S
PLNSOL,U,X,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
                    shotnum1 += 2;
                    shotnum2 += 2;
                }
                if (cpny == 1) {
                    mac += `
CMSEL,S,CP${k}
ESEL,ALL
ESLL,S
PLNSOL,U,Y,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
                    shotnum1 += 2;
                    shotnum2 += 2;
                }
                if (cpnz == 1) {
                    mac += `
CMSEL,S,CP${k}
ESEL,ALL
ESLL,S
PLNSOL,U,Z,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
                    shotnum1 += 2;
                    shotnum2 += 2;
                }
                if (cpnt == 1) {
                    mac += `
CMSEL,S,CP${k}
ESEL,ALL
ESLL,S
PLNSOL,U,SUM,0,1
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
                    shotnum1 += 2;
                    shotnum2 += 2;
                }
                if (cpnst == 1) {
                    mac += `
CMSEL,S,CP${k}
ESEL,ALL
ESLL,S
PLNSOL,S,EQV
$shot
*GET,temp${shotnum1},PLNSOL,0,MAX,,,
*GET,temp${shotnum2},PLNSOL,0,MIN,,,
`
                    shotnum1 += 2;
                    shotnum2 += 2;
                }
            }
        }//组件截图结束
        mac += `
ALLSEL,ALL
/POST1
`
        //开始提取反力等数值数据
        mac += `
*DIM,FANLI0${i},ARRAY,${rstrow},${rstcol}
`
        for (var j = 1; j <= ysnum; j++) {
            mac += `
FANLI0${i}(${j},1)=node0${j}
 `
        }
        if (af == 1) {
            for (var l = ysnum + 1; l <= ysnum + afnum; l++) {
                let temp = l - ysnum;
                mac += `
FANLI0${i}(${l},1)=elem0${temp}
`
            }
        }
        if (ztnum + zjnum > 0) {
            for (var n = ysnum + af * afnum + 1; n <= rstrow; n++) {
                let temp = 10000 + n - ysnum - af * afnum;
                mac += `
FANLI0${i}(${n},1)=${temp}
`
            }
        }
        //反力提取
        for (var k = 1; k <= ysnum; k++) {
            mac += `
*GET,FANLI0${i}(${k},2),NODE,node0${k},RF,FX
*GET,FANLI0${i}(${k},3),NODE,node0${k},RF,FY
*GET,FANLI0${i}(${k},4),NODE,node0${k},RF,FZ
`
            if (rm == 1) {
                mac += `
*GET,FANLI0${i}(${k},5),NODE,node0${k},RF,MX
*GET,FANLI0${i}(${k},6),NODE,node0${k},RF,MY
*GET,FANLI0${i}(${k},7),NODE,node0${k},RF,MZ
`
            }
        }
        //轴力提取
        for (var l = ysnum + 1; l <= ysnum + af * afnum; l++) {
            let temp = l - ysnum;
            mac += `
*GET,FANLI0${i}(${l},2),ELEM,elem0${temp},SMISC,1
`
        }
        //云图数值
        if (ztnum + zjnum > 0) {
            for (var n = ysnum + af * afnum + 1; n <= rstrow; n++) {
                let temp = n - ysnum - af * afnum;
                mac += `
FANLI0${i}(${n},2)=temp${temp}*X4
`
            }
        }
        //提取反力等数值数据结束
        mac += `
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('Condition-${i}')
`
        if (rm == 1) {
            mac += `
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FANLI0${i}(J,1)/1,FANLI0${i}(J,2)/X4,FANLI0${i}(J,3)/X4,FANLI0${i}(J,4)/X4,FANLI0${i}(J,5)/X7,FANLI0${i}(J,6)/X7,FANLI0${i}(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*CFCLOS
`
        } else {
            mac += `
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FANLI0${i}(J,1)/1,FANLI0${i}(J,2)/X4,FANLI0${i}(J,3)/X4,FANLI0${i}(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*CFCLOS
`
        }

    }//8工况循环结束
    mac += `
*DIM,FMAX,ARRAY,${rstrow},${rstcol}
*DIM,FMAX1,ARRAY,${rstrow},${rstcol}
*DIM,FMAX2,ARRAY,${rstrow},${rstcol}
*DIM,FMAX3,ARRAY,${rstrow},${rstcol}
*DIM,FMAX4,ARRAY,${rstrow},${rstcol}
*DIM,FMAX5,ARRAY,${rstrow},${rstcol}
*DIM,FMAX6,ARRAY,${rstrow},${rstcol}
*DO,JJ,1,${rstcol}
*VOPER,FMAX1(1,JJ),FANLI01(1,JJ),MAX,FANLI02(1,JJ)
*VOPER,FMAX2(1,JJ),FANLI03(1,JJ),MAX,FANLI04(1,JJ)
*VOPER,FMAX3(1,JJ),FANLI05(1,JJ),MAX,FANLI06(1,JJ)
*VOPER,FMAX4(1,JJ),FANLI07(1,JJ),MAX,FANLI08(1,JJ)
*VOPER,FMAX5(1,JJ),FMAX1(1,JJ),MAX,FMAX2(1,JJ)
*VOPER,FMAX6(1,JJ),FMAX3(1,JJ),MAX,FMAX4(1,JJ)
*VOPER,FMAX(1,JJ),FMAX5(1,JJ),MAX,FMAX6(1,JJ)
*ENDDO
*DIM,FMIN,ARRAY,${rstrow},${rstcol}
*DIM,FMIN1,ARRAY,${rstrow},${rstcol}
*DIM,FMIN2,ARRAY,${rstrow},${rstcol}
*DIM,FMIN3,ARRAY,${rstrow},${rstcol}
*DIM,FMIN4,ARRAY,${rstrow},${rstcol}
*DIM,FMIN5,ARRAY,${rstrow},${rstcol}
*DIM,FMIN6,ARRAY,${rstrow},${rstcol}
*DO,NN,1,${rstcol}
*VOPER,FMIN1(1,NN),FANLI01(1,NN),MIN,FANLI02(1,NN)
*VOPER,FMIN2(1,NN),FANLI03(1,NN),MIN,FANLI04(1,NN)
*VOPER,FMIN3(1,NN),FANLI05(1,NN),MIN,FANLI06(1,NN)
*VOPER,FMIN4(1,NN),FANLI07(1,NN),MIN,FANLI08(1,NN)
*VOPER,FMIN5(1,NN),FMIN1(1,NN),MIN,FMIN2(1,NN)
*VOPER,FMIN6(1,NN),FMIN3(1,NN),MIN,FMIN4(1,NN)
*VOPER,FMIN(1,NN),FMIN5(1,NN),MIN,FMIN6(1,NN)
*ENDDO
*DIM,FABS,ARRAY,${rstrow},${rstcol}
*DO,KK,1,${rstcol}
*VABS,1,1,1
*VOPER,FABS(1,KK),FMAX(1,KK),MAX,FMIN(1,KK)
*ENDDO
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('-----MAX-MIN-SOLUTIONS-----')
`
    if (rm == 1) {
        mac += `
*VWRITE,
('F_MAX')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FMAX(J,1)/1,FMAX(J,2)/X4,FMAX(J,3)/X4,FMAX(J,4)/X4,FMAX(J,5)/X7,FMAX(J,6)/X7,FMAX(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_MIN')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FMIN(J,1)/1,FMIN(J,2)/X4,FMIN(J,3)/X4,FMIN(J,4)/X4,FMIN(J,5)/X7,FMIN(J,6)/X7,FMIN(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_ABS')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FABS(J,1)/1,FABS(J,2)/X4,FABS(J,3)/X4,FABS(J,4)/X4,FABS(J,5)/X7,FABS(J,6)/X7,FABS(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('-----------END--------------')
*CFCLOS
`
    } else {
        mac += `
*VWRITE,
('F_MAX')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FMAX(J,1)/1,FMAX(J,2)/X4,FMAX(J,3)/X4,FMAX(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_MIN')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FMIN(J,1)/1,FMIN(J,2)/X4,FMIN(J,3)/X4,FMIN(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_ABS')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,${rstrow}
*VWRITE,FABS(J,1)/1,FABS(J,2)/X4,FABS(J,3)/X4,FABS(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('-----------END--------------')
*CFCLOS
`
    }

}