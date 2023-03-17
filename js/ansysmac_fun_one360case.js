//一点加载360工况
function one360case() {
    mac += `
X4=10000
X7=10000000
*DIM,NONUM,ARRAY,${ysnum}

`
    if (rm == 1) {
        mac += `
*DIM,FANLI,ARRAY,${ysnum},9

`
    } else {
        mac += `
*DIM,FANLI,ARRAY,${ysnum},6

`
    }
    if (af == 1) {
        mac += `
*DIM,ELNUM,ARRAY,${afnum}
*DIM,ZHOULI,ARRAY,${afnum},4

`
    }
    for (var k = 1; k <= ysnum; k++) {
        mac += `
NONUM(${k})=node0${k}

`
    }
    if (af == 1) {
        for (var k = 1; k <= afnum; k++) {
            mac += `
ELNUM(${k})=elem0${k}

`
        }
    }
    mac += `
/PREP7
*AFUN,DEG
*CFOPEN,NodeRes,txt,,Append

`
    if (rm == 1) {
        mac += `
*VWRITE,'Case','No','Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A8,'|',A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*CFCLOS

`
    } else {
        mac += `
*VWRITE,'Case','No','Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A8,'|',A8,'|',A12,'|',A12,'|',A12)
*CFCLOS

`
    }
    if (af == 1) {
        mac += `
*CFOPEN,ElemRes,txt,,Append
*VWRITE,'Case','No','Elem','F_A(t)'
(A8,'|',A8,'|',A8,'|',A12)
*CFCLOS

`
    }
    mac += `
*DO,JJ,0,359,1
/SOLU

`
    if (fv) {
        mac += `
FK,a,FZ,-f_v

`
    }
    if (fs) {
        mac += `
FK,a,FX,f_h*SIN(JJ)
FK,a,FY,-f_h*COS(JJ)

`
    }
    if (m) {
        mac += `
FK,a,MX,f_m*COS(JJ)
FK,a,MY,f_m*SIN(JJ)

`
    }
    if (mk) {
        mac += `
FK,a,MZ,f_mk

`
    }
    mac += `
SOLVE
/POST1
*DO,I,1,${ysnum}
FANLI(I,1) = JJ + 1
FANLI(I,2) = I
FANLI(I,3) = NONUM(I)
*GET,FANLI(I,4),NODE,NONUM(I),RF,FX
*GET,FANLI(I,5),NODE,NONUM(I),RF,FY
*GET,FANLI(I,6),NODE,NONUM(I),RF,FZ

`
    if (rm == 1) {
        mac += `
*GET,FANLI(I,7),NODE,NONUM(I),RF,MX
*GET,FANLI(I,8),NODE,NONUM(I),RF,MY
*GET,FANLI(I,9),NODE,NONUM(I),RF,MZ

`
    }
    mac += `
*ENDDO
*CFOPEN,NodeRes,txt,,Append
*DO,J,1,${ysnum}

`
    if (rm == 1) {
        mac += `
*VWRITE,FANLI(J,1)/1,FANLI(J,2)/1,FANLI(J,3)/1,FANLI(J,4)/X4,FANLI(J,5)/X4,FANLI(J,6)/X4,FANLI(J,7)/X7,FANLI(J,8)/X7,FANLI(J,9)/X7
(F8.0,'|',F8.0,'|',F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)

`
    } else {
        mac += `
*VWRITE,FANLI(J,1)/1,FANLI(J,2)/1,FANLI(J,3)/1,FANLI(J,4)/X4,FANLI(J,5)/X4,FANLI(J,6)/X4
(F8.0,'|',F8.0,'|',F8.0,'|',F12.2,'|',F12.2,'|',F12.2)

`
    }
    mac += `
*ENDDO
*CFCLOS

`
    if (af == 1) {
        mac += `
*DO,I,1,${afnum}
ZHOULI(I,1) = JJ + 1
ZHOULI(I,2) = I
ZHOULI(I,3) = ELNUM(I)
*GET,ZHOULI(I,4),ELEM,ELNUM(I),SMISC,1
*ENDDO
*CFOPEN,ElemRes,txt,,Append
*DO,J,1,${afnum}
*VWRITE,ZHOULI(J,1)/1,ZHOULI(J,2)/1,ZHOULI(J,3)/1,ZHOULI(J,4)/X4
(F8.0,'|',F8.0,'|',F8.0,'|',F12.2)
*ENDDO
*CFCLOS

`
    }
    mac += `
*ENDDO

`
}
