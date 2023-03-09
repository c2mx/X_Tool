<?php
//接收表单传递的参数，赋值给对应的变量
$macname = strval(isset($_POST['macname'])? $_POST['macname'] : '');//宏文件名
$loadkpnum = intval(isset($_POST['loadkpnum'])? $_POST['loadkpnum'] : '');//加载点数量
$ysnum = intval(isset($_POST['ysnum'])? $_POST['ysnum'] : '');//约束点数量
$casenum = intval(isset($_POST['casenum'])? $_POST['casenum'] : '');//工况数量
$kp1 = intval(isset($_POST['kp1'])? $_POST['kp1'] : '');//关键点1编号
$kp2 = intval(isset($_POST['kp2'])? $_POST['kp2'] : '');//关键点2编号
$kp3 = intval(isset($_POST['kp3'])? $_POST['kp3'] : '');//关键点3编号
$kp4 = intval(isset($_POST['kp4'])? $_POST['kp4'] : '');//关键点4编号
$node1 = intval(isset($_POST['node1'])? $_POST['node1'] : '');//约束点1编号
$node2 = intval(isset($_POST['node2'])? $_POST['node2'] : '');//约束点2编号
$node3 = intval(isset($_POST['node3'])? $_POST['node3'] : '');//约束点3编号
$node4 = intval(isset($_POST['node4'])? $_POST['node4'] : '');//约束点4编号
$node5 = intval(isset($_POST['node5'])? $_POST['node5'] : '');//约束点5编号
$node6 = intval(isset($_POST['node6'])? $_POST['node6'] : '');//约束点6编号
$node7 = intval(isset($_POST['node7'])? $_POST['node7'] : '');//约束点7编号
$node8 = intval(isset($_POST['node8'])? $_POST['node8'] : '');//约束点8编号
$fix = intval(isset($_POST['fix'])? $_POST['fix'] : '0');//是否约束旋转
$ckfv = intval(isset($_POST['ckfv'])? $_POST['ckfv'] : '0');//是否有垂直力
$ckfs = intval(isset($_POST['ckfs'])? $_POST['ckfs'] : '0');//是否有水平力
$ckm = intval(isset($_POST['ckm'])? $_POST['ckm'] : '0');//是否有弯矩
$ckmk = intval(isset($_POST['ckmk'])? $_POST['ckmk'] : '0');//是否有扭矩
$ckfmk = intval(isset($_POST['ckfmk'])? $_POST['ckfmk'] : '0');//是否有扭矩力
$fv = floatval(isset($_POST['fv'])? $_POST['fv'] : '0');//垂直力大小
$fs = floatval(isset($_POST['fs'])? $_POST['fs'] : '0');//水平力大小
$m = floatval(isset($_POST['m'])? $_POST['m'] : '0');//弯矩大小
$mk = floatval(isset($_POST['mk'])? $_POST['mk'] : '0');//扭矩大小
$fmk = floatval(isset($_POST['fmk'])? $_POST['fmk'] : '0');//扭矩力大小
$rf = intval(isset($_POST['rf'])? $_POST['rf'] : '0');//是否提取反力结果
$rm = intval(isset($_POST['rm'])? $_POST['rm'] : '0');//是否提取反弯矩结果
$af = intval(isset($_POST['af'])? $_POST['af'] : '0');//是否提取杆件轴力结果
$afnum = intval(isset($_POST['afnum'])? $_POST['afnum'] : '0');//杆件数量
$elem1 = intval(isset($_POST['elem1'])? $_POST['elem1'] : '');//杆件1编号
$elem2 = intval(isset($_POST['elem2'])? $_POST['elem2'] : '');//杆件2编号
$elem3 = intval(isset($_POST['elem3'])? $_POST['elem3'] : '');//杆件3编号
$elem4 = intval(isset($_POST['elem4'])? $_POST['elem4'] : '');//杆件4编号
$elem5 = intval(isset($_POST['elem5'])? $_POST['elem5'] : '');//杆件5编号
$elem6 = intval(isset($_POST['elem6'])? $_POST['elem6'] : '');//杆件6编号
$elem7 = intval(isset($_POST['elem7'])? $_POST['elem7'] : '');//杆件7编号
$elem8 = intval(isset($_POST['elem8'])? $_POST['elem8'] : '');//杆件8编号
$dfx = intval(isset($_POST['dfx'])? $_POST['dfx'] : '0');//整体X向位移
$dfy = intval(isset($_POST['dfy'])? $_POST['dfy'] : '0');//整体y向位移
$dfz = intval(isset($_POST['dfz'])? $_POST['dfz'] : '0');//整体z向位移
$dftotal = intval(isset($_POST['dftotal'])? $_POST['dftotal'] : '0');//整体合位移
$stotal = intval(isset($_POST['stotal'])? $_POST['stotal'] : '0');//整体合应力
$cpnum = intval(isset($_POST['cpnum'])? $_POST['cpnum'] : '0');//组件CP数量
$cpnx = intval(isset($_POST['cpnx'])? $_POST['cpnx'] : '0');//组件CPN X向位移
$cpny = intval(isset($_POST['cpny'])? $_POST['cpny'] : '0');//组件CPN y向位移
$cpnz = intval(isset($_POST['cpnz'])? $_POST['cpnz'] : '0');//组件CPN z向位移
$cpnt = intval(isset($_POST['cpnt'])? $_POST['cpnt'] : '0');//组件CPN 合位移
$cpnst = intval(isset($_POST['cpnst'])? $_POST['cpnst'] : '0');//组件CPN 合应力
//整体截图数量
$ztnum = $dfx + $dfy + $dfz + $dftotal + $stotal;
//组件截图数量
$zjnum = $cpnum * ($cpnx + $cpny + $cpnz + $cpnt + $cpnst);
//结果数组行数
$rstrow = $ysnum + $af * $afnum + ($ztnum + $zjnum ) * 2;
//结果数组列数
$rstcol = 4 + $rm * 3;
//定义mac宏文件变量
$mac = '';
//加载点
if($loadkpnum == 1){
	$mac = <<<EOF
a=$kp1

EOF;
}else{
	$mac = <<<EOF
a=$kp1
b=$kp2
c=$kp3
d=$kp4

EOF;
}


//载荷
if($ckfv == 1){
	$mac .= <<<EOF
f_v=$fv*10000

EOF;
}
if($ckfs == 1){
	$mac .= <<<EOF
f_h=$fs*10000

EOF;
}
if($ckm == 1 and $loadkpnum == 1){
	$mac .= <<<EOF
f_m=$m*10000000

EOF;
}
if($ckmk == 1 and $loadkpnum == 1){
	$mac .= <<<EOF
f_mk=$mk*10000000

EOF;
}
if($ckfmk == 1 and $loadkpnum == 4){
	$mac .= <<<EOF
f_mk=$fmk*10000

EOF;
}


//约束点
$mac .= <<<EOF
node01=$node1
node02=$node2

EOF;
if($ysnum >= 3){
	$mac .= <<<EOF
node03=$node3

EOF;
}
if($ysnum >= 4){
	$mac .= <<<EOF
node04=$node4

EOF;
}
if($ysnum >= 5){
	$mac .= <<<EOF
node05=$node5

EOF;
}
if($ysnum >= 6){
	$mac .= <<<EOF
node06=$node6

EOF;
}
if($ysnum >= 7){
	$mac .= <<<EOF
node07=$node7

EOF;
}
if($ysnum >= 8){
	$mac .= <<<EOF
node08=$node8

EOF;
}

//杆单元编号
if($af == 1 and $afnum >= 1){
	$mac .= <<<EOF
elem01=$elem1

EOF;
}
if($af == 1 and $afnum >= 2){
	$mac .= <<<EOF
elem02=$elem2

EOF;
}
if($af == 1 and $afnum >= 3){
	$mac .= <<<EOF
elem03=$elem3

EOF;
}
if($af == 1 and $afnum >= 4){
	$mac .= <<<EOF
elem04=$elem4

EOF;
}
if($af == 1 and $afnum >= 5){
	$mac .= <<<EOF
elem05=$elem5

EOF;
}
if($af == 1 and $afnum >= 6){
	$mac .= <<<EOF
elem06=$elem6

EOF;
}
if($af == 1 and $afnum >= 7){
	$mac .= <<<EOF
elem07=$elem7

EOF;
}
if($af == 1 and $afnum >= 8){
	$mac .= <<<EOF
elem08=$elem8

EOF;
}


//截图云图数值临时保存变量
if($ztnum + $zjnum > 0 and $casenum == 8){
	for($i=1;$i<=($ztnum + $zjnum)*2;$i++){
		$mac .= <<<EOF
temp$i=0

EOF;
	}
}


//一点加载8工况=================================
if($loadkpnum == 1 and $casenum == 8){
	$mac .= <<<EOF
X4=10000
X7=10000000
/PREP7
*AFUN,DEG
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('-----REACTION-SOLUTIONS-----')
*CFCLOS

EOF;
//循环8工况===================================
for($i=1;$i<=8;$i++){
	$mac .= <<<EOF
/SOLU

EOF;
if($ckfv == 1){
	$mac .= <<<EOF
FK,a,FZ,-f_v

EOF;
}
if($ckfs == 1){
	$mac .= <<<EOF
FK,a,FX,f_h*SIN($i*45-45)
FK,a,FY,-f_h*COS($i*45-45)

EOF;
}
if($ckm == 1){
	$mac .= <<<EOF
FK,a,MX,f_m*COS($i*45-45)
FK,a,MY,f_m*SIN($i*45-45)

EOF;
}
if($ckmk == 1){
	$mac .= <<<EOF
FK,a,MZ,f_mk

EOF;
}
$mac .= <<<EOF
SOLVE
/POST1

EOF;
//截图计数辅助变量
$shotnum1 = 1;
$shotnum2 = 2;
if($dfx == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,X,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;
}
if($dfy == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,Y,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
if($dfz == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,Z,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
if($dftotal == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,SUM,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
if($stotal == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,S,EQV
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
//组件截图开始
if($cpnum > 0){
	for($k=1;$k<=$cpnum;$k++){
		if($cpnx == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,X,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpny == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,Y,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpnz == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,Z,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpnt == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,SUM,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpnst == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,S,EQV
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
	}
}//组件截图结束
$mac .= <<<EOF
ALLSEL,ALL
/POST1

EOF;
//开始提取反力等数值数据
$mac .= <<<EOF
*DIM,FANLI0$i,ARRAY,$rstrow,$rstcol

EOF;
for($j=1;$j<=$ysnum;$j++){
	$mac .= <<<EOF
FANLI0$i($j,1)=node0$j

EOF;
}
if($af == 1){
	for($l=$ysnum+1;$l<=$ysnum+$af*$afnum;$l++){
		$temp = $l - $ysnum;
		$mac .= <<<EOF
FANLI0$i($l,1)=elem0$temp

EOF;
	}
}
if($ztnum + $zjnum > 0){
	for($n=$ysnum+$af*$afnum+1;$n<=$rstrow;$n++){
		$temp = 10000 + $n - $ysnum - $af*$afnum;
		$mac .= <<<EOF
FANLI0$i($n,1)=$temp

EOF;
	}
}
//反力提取
for($k=1;$k<=$ysnum;$k++){
	$mac .= <<<EOF
*GET,FANLI0$i($k,2),NODE,node0$k,RF,FX
*GET,FANLI0$i($k,3),NODE,node0$k,RF,FY
*GET,FANLI0$i($k,4),NODE,node0$k,RF,FZ

EOF;
if($rm == 1){
	$mac .= <<<EOF
*GET,FANLI0$i($k,5),NODE,node0$k,RF,MX
*GET,FANLI0$i($k,6),NODE,node0$k,RF,MY
*GET,FANLI0$i($k,7),NODE,node0$k,RF,MZ

EOF;
}
}
//轴力提取
for($l=$ysnum+1;$l<=$ysnum+$af*$afnum;$l++){
	$temp = $l - $ysnum;
	$mac .= <<<EOF
*GET,FANLI0$i($l,2),ELEM,elem0$temp,SMISC,1

EOF;
}
//云图数值
if($ztnum + $zjnum > 0){
	for($n=$ysnum+$af*$afnum+1;$n<=$rstrow;$n++){
		$temp = $n - $ysnum - $af*$afnum;
		$mac .= <<<EOF
FANLI0$i($n,2)=temp$temp*X4

EOF;
	}
}
//提取反力等数值数据结束

$mac .= <<<EOF
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('Condition-$i')

EOF;
if($rm == 1){
	$mac .= <<<EOF
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FANLI0$i(J,1)/1,FANLI0$i(J,2)/X4,FANLI0$i(J,3)/X4,FANLI0$i(J,4)/X4,FANLI0$i(J,5)/X7,FANLI0$i(J,6)/X7,FANLI0$i(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*CFCLOS

EOF;
}else{
	$mac .= <<<EOF
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FANLI0$i(J,1)/1,FANLI0$i(J,2)/X4,FANLI0$i(J,3)/X4,FANLI0$i(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*CFCLOS

EOF;
}

}//8工况循环结束
//end of 循环8工况===================================

$mac .= <<<EOF
*DIM,FMAX,ARRAY,$rstrow,$rstcol
*DIM,FMAX1,ARRAY,$rstrow,$rstcol
*DIM,FMAX2,ARRAY,$rstrow,$rstcol
*DIM,FMAX3,ARRAY,$rstrow,$rstcol
*DIM,FMAX4,ARRAY,$rstrow,$rstcol
*DIM,FMAX5,ARRAY,$rstrow,$rstcol
*DIM,FMAX6,ARRAY,$rstrow,$rstcol
*DO,JJ,1,$rstcol
*VOPER,FMAX1(1,JJ),FANLI01(1,JJ),MAX,FANLI02(1,JJ)
*VOPER,FMAX2(1,JJ),FANLI03(1,JJ),MAX,FANLI04(1,JJ)
*VOPER,FMAX3(1,JJ),FANLI05(1,JJ),MAX,FANLI06(1,JJ)
*VOPER,FMAX4(1,JJ),FANLI07(1,JJ),MAX,FANLI08(1,JJ)
*VOPER,FMAX5(1,JJ),FMAX1(1,JJ),MAX,FMAX2(1,JJ)
*VOPER,FMAX6(1,JJ),FMAX3(1,JJ),MAX,FMAX4(1,JJ)
*VOPER,FMAX(1,JJ),FMAX5(1,JJ),MAX,FMAX6(1,JJ)
*ENDDO
*DIM,FMIN,ARRAY,$rstrow,$rstcol
*DIM,FMIN1,ARRAY,$rstrow,$rstcol
*DIM,FMIN2,ARRAY,$rstrow,$rstcol
*DIM,FMIN3,ARRAY,$rstrow,$rstcol
*DIM,FMIN4,ARRAY,$rstrow,$rstcol
*DIM,FMIN5,ARRAY,$rstrow,$rstcol
*DIM,FMIN6,ARRAY,$rstrow,$rstcol
*DO,NN,1,$rstcol
*VOPER,FMIN1(1,NN),FANLI01(1,NN),MIN,FANLI02(1,NN)
*VOPER,FMIN2(1,NN),FANLI03(1,NN),MIN,FANLI04(1,NN)
*VOPER,FMIN3(1,NN),FANLI05(1,NN),MIN,FANLI06(1,NN)
*VOPER,FMIN4(1,NN),FANLI07(1,NN),MIN,FANLI08(1,NN)
*VOPER,FMIN5(1,NN),FMIN1(1,NN),MIN,FMIN2(1,NN)
*VOPER,FMIN6(1,NN),FMIN3(1,NN),MIN,FMIN4(1,NN)
*VOPER,FMIN(1,NN),FMIN5(1,NN),MIN,FMIN6(1,NN)
*ENDDO
*DIM,FABS,ARRAY,$rstrow,$rstcol
*DO,KK,1,$rstcol
*VABS,1,1,1
*VOPER,FABS(1,KK),FMAX(1,KK),MAX,FMIN(1,KK)
*ENDDO
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('-----MAX-MIN-SOLUTIONS-----')

EOF;
if($rm == 1){
	$mac .= <<<EOF
*VWRITE,
('F_MAX')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMAX(J,1)/1,FMAX(J,2)/X4,FMAX(J,3)/X4,FMAX(J,4)/X4,FMAX(J,5)/X7,FMAX(J,6)/X7,FMAX(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_MIN')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMIN(J,1)/1,FMIN(J,2)/X4,FMIN(J,3)/X4,FMIN(J,4)/X4,FMIN(J,5)/X7,FMIN(J,6)/X7,FMIN(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_ABS')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FABS(J,1)/1,FABS(J,2)/X4,FABS(J,3)/X4,FABS(J,4)/X4,FABS(J,5)/X7,FABS(J,6)/X7,FABS(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('-----------END--------------')
*CFCLOS

EOF;
}else{
		$mac .= <<<EOF
*VWRITE,
('F_MAX')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMAX(J,1)/1,FMAX(J,2)/X4,FMAX(J,3)/X4,FMAX(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_MIN')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMIN(J,1)/1,FMIN(J,2)/X4,FMIN(J,3)/X4,FMIN(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_ABS')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FABS(J,1)/1,FABS(J,2)/X4,FABS(J,3)/X4,FABS(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('-----------END--------------')
*CFCLOS

EOF;
}

}//一点加载8工况---结束
//end of 一点加载8工况=================================


//一点加载360工况===============================
if($loadkpnum == 1 and $casenum == 360){
	$mac .= <<<EOF
X4=10000
X7=10000000
*DIM,NONUM,ARRAY,$ysnum

EOF;
if($rm == 1){
	$mac .= <<<EOF
*DIM,FANLI,ARRAY,$ysnum,9

EOF;
}else{
	$mac .= <<<EOF
*DIM,FANLI,ARRAY,$ysnum,6

EOF;
}
if($af == 1){
	$mac .= <<<EOF
*DIM,ELNUM,ARRAY,$afnum
*DIM,ZHOULI,ARRAY,$afnum,4

EOF;
}
for($k=1;$k<=$ysnum;$k++){
	$mac .= <<<EOF
NONUM($k)=node0$k

EOF;
}
if($af == 1){
	for($k=1;$k<=$afnum;$k++){
		$mac .= <<<EOF
ELNUM($k)=elem0$k

EOF;
	}
}
$mac .= <<<EOF
/PREP7
*AFUN,DEG
*CFOPEN,NodeRes,txt,,Append

EOF;
if($rm == 1){
	$mac .= <<<EOF
*VWRITE,'Case','No','Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A8,'|',A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*CFCLOS

EOF;
}else{
	$mac .= <<<EOF
*VWRITE,'Case','No','Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A8,'|',A8,'|',A12,'|',A12,'|',A12)
*CFCLOS

EOF;
}
if($af == 1){
	$mac .= <<<EOF
*CFOPEN,ElemRes,txt,,Append
*VWRITE,'Case','No','Elem','F_A(t)'
(A8,'|',A8,'|',A8,'|',A12)
*CFCLOS

EOF;
}
$mac .= <<<EOF
*DO,JJ,0,359,1
/SOLU

EOF;
if($ckfv == 1){
	$mac .= <<<EOF
FK,a,FZ,-f_v

EOF;
}
if($ckfs == 1){
	$mac .= <<<EOF
FK,a,FX,f_h*SIN(JJ)
FK,a,FY,-f_h*COS(JJ)

EOF;
}
if($ckm == 1){
	$mac .= <<<EOF
FK,a,MX,f_m*COS(JJ)
FK,a,MY,f_m*SIN(JJ)

EOF;
}
if($ckmk == 1){
	$mac .= <<<EOF
FK,a,MZ,f_mk

EOF;
}
$mac .= <<<EOF
SOLVE
/POST1
*DO,I,1,$ysnum
FANLI(I,1) = JJ + 1
FANLI(I,2) = I
FANLI(I,3) = NONUM(I)
*GET,FANLI(I,4),NODE,NONUM(I),RF,FX
*GET,FANLI(I,5),NODE,NONUM(I),RF,FY
*GET,FANLI(I,6),NODE,NONUM(I),RF,FZ

EOF;
if($rm == 1){
	$mac .= <<<EOF
*GET,FANLI(I,7),NODE,NONUM(I),RF,MX
*GET,FANLI(I,8),NODE,NONUM(I),RF,MY
*GET,FANLI(I,9),NODE,NONUM(I),RF,MZ

EOF;
}
$mac .= <<<EOF
*ENDDO
*CFOPEN,NodeRes,txt,,Append
*DO,J,1,$ysnum

EOF;
if($rm == 1){
	$mac .= <<<EOF
*VWRITE,FANLI(J,1)/1,FANLI(J,2)/1,FANLI(J,3)/1,FANLI(J,4)/X4,FANLI(J,5)/X4,FANLI(J,6)/X4,FANLI(J,7)/X7,FANLI(J,8)/X7,FANLI(J,9)/X7
(F8.0,'|',F8.0,'|',F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)

EOF;
}else{
	$mac .= <<<EOF
*VWRITE,FANLI(J,1)/1,FANLI(J,2)/1,FANLI(J,3)/1,FANLI(J,4)/X4,FANLI(J,5)/X4,FANLI(J,6)/X4
(F8.0,'|',F8.0,'|',F8.0,'|',F12.2,'|',F12.2,'|',F12.2)

EOF;
}
$mac .= <<<EOF
*ENDDO
*CFCLOS

EOF;
if($af == 1){
$mac .= <<<EOF
*DO,I,1,$afnum
ZHOULI(I,1) = JJ + 1
ZHOULI(I,2) = I
ZHOULI(I,3) = ELNUM(I)
*GET,ZHOULI(I,4),ELEM,ELNUM(I),SMISC,1
*ENDDO
*CFOPEN,ElemRes,txt,,Append
*DO,J,1,$afnum
*VWRITE,ZHOULI(J,1)/1,ZHOULI(J,2)/1,ZHOULI(J,3)/1,ZHOULI(J,4)/X4
(F8.0,'|',F8.0,'|',F8.0,'|',F12.2)
*ENDDO
*CFCLOS

EOF;
}
$mac .= <<<EOF
*ENDDO

EOF;

}//一点加载360工况---结束



//四点加载8工况=================================
if($loadkpnum == 4){
	$mac .= <<<EOF
X4 = 10000
X7 = 10000000
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('-----REACTION-SOLUTIONS-----')
*CFCLOS

EOF;
for($i=1;$i<=8;$i++){
	$mac .= <<<EOF
/SOLU
FK,a,FZ,-f_v/4
FK,b,FZ,-f_v/4
FK,c,FZ,-f_v/4
FK,d,FZ,-f_v/4

EOF;
if($i == 1){
	$mac .= <<<EOF
FK,a,FX,0
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m
FK,a,FY,-f_h/2-f_m
FK,b,FY,-f_h/2
FK,c,FY,f_m
FK,d,FY,0

EOF;
}
if($i == 2){
	$mac .= <<<EOF
FK,a,FX,0
FK,b,FX,f_m+f_h/2.828
FK,c,FX,f_h/2.828
FK,d,FX,-f_m
FK,a,FY,-f_h/2.828-f_m
FK,b,FY,-f_h/2.828
FK,c,FY,f_m
FK,d,FY,0

EOF;
}
if($i == 3){
	$mac .= <<<EOF
FK,a,FX,0
FK,b,FX,f_m+f_h/2
FK,c,FX,f_h/2
FK,d,FX,-f_m
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m
FK,d,FY,0

EOF;
}
if($i == 4){
	$mac .= <<<EOF
FK,a,FX,0
FK,b,FX,f_m+f_h/2.828
FK,c,FX,f_h/2.828
FK,d,FX,-f_m
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m+f_h/2.828
FK,d,FY,f_h/2.828

EOF;
}
if($i == 5){
	$mac .= <<<EOF
FK,a,FX,0
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m+f_h/2
FK,d,FY,f_h/2

EOF;
}
if($i == 6){
	$mac .= <<<EOF
FK,a,FX,-f_h/2.828
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m-f_h/2.828
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m+f_h/2.828
FK,d,FY,f_h/2.828

EOF;
}
if($i == 7){
	$mac .= <<<EOF
FK,a,FX,-f_h/2
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m-f_h/2
FK,a,FY,-f_m
FK,b,FY,0
FK,c,FY,f_m
FK,d,FY,0

EOF;
}
if($i == 8){
	$mac .= <<<EOF
FK,a,FX,-f_h/2.828
FK,b,FX,f_m
FK,c,FX,0
FK,d,FX,-f_m-f_h/2.828
FK,a,FY,-f_m-f_h/2.828
FK,b,FY,-f_h/2.828
FK,c,FY,f_m
FK,d,FY,0

EOF;
}
$mac .= <<<EOF
SOLVE
/POST1

EOF;
//截图计数辅助变量
$shotnum1 = 1;
$shotnum2 = 2;
//整体截图
if($dfx == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,X,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;
}
if($dfy == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,Y,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
if($dfz == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,Z,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
if($dftotal == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,U,SUM,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
if($stotal == 1){
	$mac .= <<<EOF
ALLSEL,ALL
PLNSOL,S,EQV
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
$shotnum1 += 2;
$shotnum2 += 2;	
}
//组件截图
if($cpnum > 0){
	for($k=1;$k<=$cpnum;$k++){
		if($cpnx == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,X,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpny == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,Y,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpnz == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,Z,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpnt == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,U,SUM,0,1
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
		if($cpnst == 1){
			$mac .= <<<EOF
CMSEL,S,CP$k
ESEL,ALL
ESLL,S
PLNSOL,S,EQV
$shot
*GET,temp$shotnum1,PLNSOL,0,MAX,,,
*GET,temp$shotnum2,PLNSOL,0,MIN,,,

EOF;
			$shotnum1 += 2;
			$shotnum2 += 2;	
		}
	}
}//组件截图结束
$mac .= <<<EOF
ALLSEL,ALL
/POST1

EOF;
//开始提取反力等数值数据
$mac .= <<<EOF
*DIM,FANLI0$i,ARRAY,$rstrow,$rstcol

EOF;
for($j=1;$j<=$ysnum;$j++){
	$mac .= <<<EOF
FANLI0$i($j,1)=node0$j

EOF;
}
if($af == 1){
	for($l=$ysnum+1;$l<=$ysnum+$afnum;$l++){
		$temp = $l - $ysnum;
		$mac .= <<<EOF
FANLI0$i($l,1)=elem0$temp

EOF;
	}
}
if($ztnum + $zjnum > 0){
	for($n=$ysnum+$af*$afnum+1;$n<=$rstrow;$n++){
		$temp = 10000 + $n - $ysnum - $af*$afnum;
		$mac .= <<<EOF
FANLI0$i($n,1)=$temp

EOF;
	}
}
//反力提取
for($k=1;$k<=$ysnum;$k++){
	$mac .= <<<EOF
*GET,FANLI0$i($k,2),NODE,node0$k,RF,FX
*GET,FANLI0$i($k,3),NODE,node0$k,RF,FY
*GET,FANLI0$i($k,4),NODE,node0$k,RF,FZ

EOF;
if($rm == 1){
	$mac .= <<<EOF
*GET,FANLI0$i($k,5),NODE,node0$k,RF,MX
*GET,FANLI0$i($k,6),NODE,node0$k,RF,MY
*GET,FANLI0$i($k,7),NODE,node0$k,RF,MZ

EOF;
}
}
//轴力提取
for($l=$ysnum+1;$l<=$ysnum+$af*$afnum;$l++){
	$temp = $l - $ysnum;
	$mac .= <<<EOF
*GET,FANLI0$i($l,2),ELEM,elem0$temp,SMISC,1

EOF;
}
//云图数值
if($ztnum + $zjnum > 0){
	for($n=$ysnum+$af*$afnum+1;$n<=$rstrow;$n++){
		$temp = $n - $ysnum - $af*$afnum;
		$mac .= <<<EOF
FANLI0$i($n,2)=temp$temp*X4

EOF;
	}
}
//提取反力等数值数据结束
$mac .= <<<EOF
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('Condition-$i')

EOF;
if($rm == 1){
	$mac .= <<<EOF
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FANLI0$i(J,1)/1,FANLI0$i(J,2)/X4,FANLI0$i(J,3)/X4,FANLI0$i(J,4)/X4,FANLI0$i(J,5)/X7,FANLI0$i(J,6)/X7,FANLI0$i(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*CFCLOS

EOF;
}else{
	$mac .= <<<EOF
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FANLI0$i(J,1)/1,FANLI0$i(J,2)/X4,FANLI0$i(J,3)/X4,FANLI0$i(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*CFCLOS

EOF;
}

}//8工况循环结束
$mac .= <<<EOF
*DIM,FMAX,ARRAY,$rstrow,$rstcol
*DIM,FMAX1,ARRAY,$rstrow,$rstcol
*DIM,FMAX2,ARRAY,$rstrow,$rstcol
*DIM,FMAX3,ARRAY,$rstrow,$rstcol
*DIM,FMAX4,ARRAY,$rstrow,$rstcol
*DIM,FMAX5,ARRAY,$rstrow,$rstcol
*DIM,FMAX6,ARRAY,$rstrow,$rstcol
*DO,JJ,1,$rstcol
*VOPER,FMAX1(1,JJ),FANLI01(1,JJ),MAX,FANLI02(1,JJ)
*VOPER,FMAX2(1,JJ),FANLI03(1,JJ),MAX,FANLI04(1,JJ)
*VOPER,FMAX3(1,JJ),FANLI05(1,JJ),MAX,FANLI06(1,JJ)
*VOPER,FMAX4(1,JJ),FANLI07(1,JJ),MAX,FANLI08(1,JJ)
*VOPER,FMAX5(1,JJ),FMAX1(1,JJ),MAX,FMAX2(1,JJ)
*VOPER,FMAX6(1,JJ),FMAX3(1,JJ),MAX,FMAX4(1,JJ)
*VOPER,FMAX(1,JJ),FMAX5(1,JJ),MAX,FMAX6(1,JJ)
*ENDDO
*DIM,FMIN,ARRAY,$rstrow,$rstcol
*DIM,FMIN1,ARRAY,$rstrow,$rstcol
*DIM,FMIN2,ARRAY,$rstrow,$rstcol
*DIM,FMIN3,ARRAY,$rstrow,$rstcol
*DIM,FMIN4,ARRAY,$rstrow,$rstcol
*DIM,FMIN5,ARRAY,$rstrow,$rstcol
*DIM,FMIN6,ARRAY,$rstrow,$rstcol
*DO,NN,1,$rstcol
*VOPER,FMIN1(1,NN),FANLI01(1,NN),MIN,FANLI02(1,NN)
*VOPER,FMIN2(1,NN),FANLI03(1,NN),MIN,FANLI04(1,NN)
*VOPER,FMIN3(1,NN),FANLI05(1,NN),MIN,FANLI06(1,NN)
*VOPER,FMIN4(1,NN),FANLI07(1,NN),MIN,FANLI08(1,NN)
*VOPER,FMIN5(1,NN),FMIN1(1,NN),MIN,FMIN2(1,NN)
*VOPER,FMIN6(1,NN),FMIN3(1,NN),MIN,FMIN4(1,NN)
*VOPER,FMIN(1,NN),FMIN5(1,NN),MIN,FMIN6(1,NN)
*ENDDO
*DIM,FABS,ARRAY,$rstrow,$rstcol
*DO,KK,1,$rstcol
*VABS,1,1,1
*VOPER,FABS(1,KK),FMAX(1,KK),MAX,FMIN(1,KK)
*ENDDO
*CFOPEN,TheResult,txt,,Append
*VWRITE,
('-----MAX-MIN-SOLUTIONS-----')

EOF;
if($rm == 1){
	$mac .= <<<EOF
*VWRITE,
('F_MAX')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMAX(J,1)/1,FMAX(J,2)/X4,FMAX(J,3)/X4,FMAX(J,4)/X4,FMAX(J,5)/X7,FMAX(J,6)/X7,FMAX(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_MIN')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMIN(J,1)/1,FMIN(J,2)/X4,FMIN(J,3)/X4,FMIN(J,4)/X4,FMIN(J,5)/X7,FMIN(J,6)/X7,FMIN(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_ABS')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)','M_X(t.m)','M_Y(t.m)','M_Z(t.m)'
(A8,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FABS(J,1)/1,FABS(J,2)/X4,FABS(J,3)/X4,FABS(J,4)/X4,FABS(J,5)/X7,FABS(J,6)/X7,FABS(J,7)/X7
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('-----------END--------------')
*CFCLOS

EOF;
}else{
		$mac .= <<<EOF
*VWRITE,
('F_MAX')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMAX(J,1)/1,FMAX(J,2)/X4,FMAX(J,3)/X4,FMAX(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_MIN')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FMIN(J,1)/1,FMIN(J,2)/X4,FMIN(J,3)/X4,FMIN(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('F_ABS')
*VWRITE,'Node','F_X(t)','F_Y(t)','F_Z(t)'
(A8,'|',A12,'|',A12,'|',A12)
*DO,J,1,$rstrow
*VWRITE,FABS(J,1)/1,FABS(J,2)/X4,FABS(J,3)/X4,FABS(J,4)/X4
(F8.0,'|',F12.2,'|',F12.2,'|',F12.2)
*ENDDO
*VWRITE,
('-----------END--------------')
*CFCLOS

EOF;
}
}//四点加载8工况---结束
?>