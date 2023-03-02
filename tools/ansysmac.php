<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ANSYS计算宏生成助手</title>
    <?php
$macname = strval(isset($_POST['macname'])? $_POST['macname'] : '');//宏文件名
if($macname){
}else{
?>
    <script src="/js/ansysmac.js"></script>
    <?php
}
?>
    <link rel="stylesheet" type="text/css" href="/css/ansysmac.css">
</head>

<body>
    <div id="main">
        <div id="header">ANSYS计算宏生成助手</div>
        <?php
include_once('common.php');
//TODO:保存文件路径用日期格式，年、月、日、时分秒、文件名
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
//循环8工况
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

if($macname){//==================================================================
	//===========================================================================
	//===========================================================================
$filepath = './'.date('Y/m/d').'/'.date('His');
if(!is_dir($filepath)){
	mkdir($filepath,0777,true);
}
//echo nl2br($mac);//测试输出
//MAC文件输出并给出下载链接====================================================
$macfilename = $filepath.'/'.$macname.'.mac';
$fp = fopen($macfilename,'w');
fwrite($fp,$mac);
fclose($fp);
echo <<<EOF
<p><a href="$macfilename">宏命令下载</a>(右键另存为)</p>
EOF;

//写出python文件
//8工况====================================================
if($casenum == 8){
  //$a,$b,$c,$d,$e分别是：
    //约束点数量, 杆轴力数量, 全局截图数量, 整体截图数量, 组件数量
    //$header模块引用；$format设置文档格式
$py8 = <<<EOF
$pyhead
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

EOF;
$ttl = $ysnum + $af*$afnum + ($ztnum + $zjnum) * 2;
$skip = array(0,1,2,$ttl+3,$ttl+4,$ttl*2+5,$ttl*2+6,$ttl*3+7,$ttl*3+8,$ttl*4+9,$ttl*4+10,$ttl*5+11,$ttl*5+12,$ttl*6+13,$ttl*6+14,
$ttl*7+15,$ttl*7+16,$ttl*8+17,$ttl*8+18,$ttl*8+19,$ttl*9+20,$ttl*9+21,$ttl*10+22,$ttl*10+23,$ttl*11+24);
$temp8 = 'skiplist = ['.$skip[0];
for($n=1;$n<25;$n++){
    $temp8 .= ','.$skip[$n];
}
$temp8 .= ']';
$py8 .= <<<EOF
$temp8
try:
	ansys = pd.read_table('TheResult.txt', sep='|', skiprows=skiplist, header=None)
except ValueError:
	print('目录下没有结果文件TheResult.txt')
	sys.exit(0)

EOF;
$tabi = $ysnum + $af*$afnum;
$py8 .= <<<EOF
tabindex = $tabi

EOF;
if($ztnum + $zjnum > 0){
    $py8 .= <<<EOF
for i in range(1, 9):
	calc_book.add_heading(f'{titlist}.{i}.工况{i}', level=3)

EOF;
}

$temp1 = 0;
$temp2 = 1;
if($ztnum > 0){
    if($dfx == 1){
		$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'整体X向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
	$temp1 += 2;
	$temp2 += 2;
	}
	if($dfy == 1){
		$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'整体Y向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
	$temp1 += 2;
	$temp2 += 2;
	}
	if($dfz == 1){
		$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'整体Z向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
	$temp1 += 2;
	$temp2 += 2;
	}
	if($dftotal == 1){
		$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'整体合位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
	$temp1 += 2;
	$temp2 += 2;
	}
	if($stotal == 1){
		$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'整体合应力{ceil(outnum)}MPa:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
	$temp1 += 2;
	$temp2 += 2;
	}
}
if($cpnum > 0){
	for($cpn=1;$cpn<=$cpnum;$cpn++){
		if($cpnx ==1){
			$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'部件$cpn X向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
			$temp1 += 2;
			$temp2 += 2;
		}
		if($cpny ==1){
			$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'部件$cpn Y向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
			$temp1 += 2;
			$temp2 += 2;
		}
		if($cpnz ==1){
			$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'部件$cpn Z向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
			$temp1 += 2;
			$temp2 += 2;
		}
		if($cpnt ==1){
			$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'部件$cpn 合向位移{ceil(outnum)}mm:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
			$temp1 += 2;
			$temp2 += 2;
		}
		if($cpnst ==1){
			$py8 .= <<<EOF
	maxn = ansys.iloc[tabindex + $temp1, 1]
	maxn = abs(maxn)
	minn = ansys.iloc[tabindex + $temp2, 1]
	minn = abs(minn)
	outnum = max(maxn, minn)
	calc_book.add_paragraph(f'部件$cpn 合应力{ceil(outnum)}MPa:',style='Normal')
	calc_book.add_paragraph('', style='No Spacing').add_run('').add_picture(f'{jobname + str(picnum)[1:]}.png',height=Cm(7))
	picnum = picnum + 1

EOF;
			$temp1 += 2;
			$temp2 += 2;
		}		
	}
}
if($ztnum + $zjnum > 0){
	$py8 .= <<<EOF
	tabindex = tabindex + $ttl

EOF;
}
$temprow = 9 * (2 + $ysnum);
$py8 .= <<<EOF
calc_book.add_heading(f'{titlist}.9.节点反力汇总', level=3)
rows_num = $temprow

EOF;
if($rm == 1){
$py8 .= <<<EOF
cols_num = 7

EOF;
}else{
$py8 .= <<<EOF
cols_num = 4

EOF;
}
$py8 .= <<<EOF
mytable = calc_book.add_table(rows=rows_num, cols=cols_num, style='Table Grid')
mytable.alignment = WD_TABLE_ALIGNMENT.CENTER
mytable.allow_autofit = False
for r in range(8):
	mytable.cell(0 + r * (2+$ysnum), 0).text = f'工况-{r + 1}'
	mytable.cell(1 + r * (2+$ysnum), 0).text = '节点'
	mytable.cell(1 + r * (2+$ysnum), 1).text = 'F_x(t)'
	mytable.cell(1 + r * (2+$ysnum), 2).text = 'F_y(t)'
	mytable.cell(1 + r * (2+$ysnum), 3).text = 'F_z(t)'

EOF;
if($rm == 1){
	$py8 .= <<<EOF
	mytable.cell(1 + r * (2+$ysnum), 4).text = 'M_x(t.m)'
	mytable.cell(1 + r * (2+$ysnum), 5).text = 'M_y(t.m)'
	mytable.cell(1 + r * (2+$ysnum), 6).text = 'M_z(t.m)'

EOF;
}
$py8 .= <<<EOF
	for i in range($ysnum):
		mytable.cell(2 + i + r * (2+$ysnum), 0).text = str(int(ansys.iloc[i + r * $ttl, 0]))

EOF;
if($rm == 1){
	$py8 .= <<<EOF
		for j in range(1, 7):
			mytable.cell(2 + i + r * (2+$ysnum), j).text = str(ansys.iloc[i + r * $ttl, j])

EOF;
}else{
	$py8 .= <<<EOF
		for j in range(1, 4):
			mytable.cell(2 + i + r * (2+$ysnum), j).text = str(ansys.iloc[i + r * $ttl, j])

EOF;
}
$py8 .= <<<EOF
mytable.cell(0 + 8 * (2 + $ysnum), 0).text = '包络值'
mytable.cell(1 + 8 * (2 + $ysnum), 0).text = '节点'
mytable.cell(1 + 8 * (2 + $ysnum), 1).text = 'F_x(t)'
mytable.cell(1 + 8 * (2 + $ysnum), 2).text = 'F_y(t)'
mytable.cell(1 + 8 * (2 + $ysnum), 3).text = 'F_z(t)'

EOF;
if($rm == 1){
	$py8 .= <<<EOF
mytable.cell(1 + 8 * (2 + $ysnum), 4).text = 'M_x(t.m)'
mytable.cell(1 + 8 * (2 + $ysnum), 5).text = 'M_y(t.m)'
mytable.cell(1 + 8 * (2 + $ysnum), 6).text = 'M_z(t.m)'

EOF;
}
$py8 .= <<<EOF
for i in range($ysnum):
	mytable.cell(2 + i + 8 * (2 + $ysnum), 0).text = str(int(ansys.iloc[i + 10 * $ttl, 0]))

EOF;
if($rm == 1){
	$py8 .= <<<EOF
	for j in range(1, 7):
		mytable.cell(2 + i + 8 * (2 + $ysnum), j).text = str(ansys.iloc[i + 10 * $ttl, j])

EOF;
}else{
	$py8 .= <<<EOF
	for j in range(1, 4):
		mytable.cell(2 + i + 8 * (2 + $ysnum), j).text = str(ansys.iloc[i + 10 * $ttl, j])

EOF;
}
$py8 .= <<<EOF
for c in range(cols_num): 
	for cell in mytable.columns[c].cells:

EOF;
if($rm == 1){
$py8 .= <<<EOF
		cell.width = Cm(2.5)

EOF;
}else{
$py8 .= <<<EOF
		cell.width = Cm(3.5)

EOF;
}
$py8 .= <<<EOF
		cell.paragraphs[0].paragraph_format.line_spacing_rule = WD_LINE_SPACING.SINGLE
		cell.paragraphs[0].paragraph_format.first_line_indent = Mm(0)
		cell.paragraphs[0].paragraph_format.alignment = WD_PARAGRAPH_ALIGNMENT.CENTER
		cell.vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
for row in mytable.rows:
	row.height = Cm(0.8)

EOF;
if($af*$afnum > 0){
$py8 .= <<<EOF
calc_book.add_paragraph('', style='Normal')
calc_book.add_paragraph('杆件轴力包络值', style='Normal')
mytable2 = calc_book.add_table(rows=($af*$afnum+1), cols=2, style='Table Grid')
mytable2.alignment = WD_TABLE_ALIGNMENT.CENTER
mytable2.autofit = False
mytable2.cell(0, 0).text = '名称'
mytable2.cell(0, 1).text = '轴向力/t'

EOF;
for($n=1;$n<=$af*$afnum;$n++){
$py8 .= <<<EOF
mytable2.cell($n, 0).text = '杆件$n'
mytable2.cell($n, 1).text = str(ceil(ansys.iloc[($ysnum+$n-1) + 10 * $ttl, 1]))

EOF;
}
$py8 .= <<<EOF
for c in range(2):
	for cell in mytable2.columns[c].cells:
		cell.width = Cm(3.5)
		cell.paragraphs[0].paragraph_format.line_spacing_rule = WD_LINE_SPACING.SINGLE
		cell.paragraphs[0].paragraph_format.first_line_indent = Mm(0)
		cell.paragraphs[0].paragraph_format.alignment = WD_PARAGRAPH_ALIGNMENT.CENTER
		cell.vertical_alignment = WD_CELL_VERTICAL_ALIGNMENT.CENTER
for row in mytable2.rows:
	row.height = Cm(0.8)

EOF;
}
$py8 .= <<<EOF
filename = f'{jobname}计算结果' + strftime('%Y-%m-%d-%H%M%S', localtime())
calc_book.save(f'{filename}.docx')
print(f'计算书生成结束，保存在程序目录下，文件名为{filename}.docx')

EOF;
//输出py脚本的下载链接，可能要注意编码格式


$pythonfile = $filepath.'/'.$macname.'.py';
$fpy = fopen($pythonfile,'w');
fwrite($fpy,$py8);
fclose($fpy);
echo <<<EOF
<p><a href="$pythonfile">Python脚本下载</a>(右键另存为)</p>
EOF;
}//8工况结束
//360工况====================================================
//输出两个文件：节点反力处理脚本，杆件轴力处理脚本
if($loadkpnum == 1 and $casenum == 360){
if($rf == 1){//反力，不完整，没有反弯矩结果提取
if($rm == 0){//无反弯矩的工况
$pyn360 = <<<EOF
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
for k in range(0, $ysnum):
	x = range(0, 360)
	yfx = []
	yfy = []
	yfz = []
	for i in range(0, 360):
		yfx.append(my_data.iloc[i * $ysnum + k, 1])
		yfy.append(my_data.iloc[i * $ysnum + k, 2])
		yfz.append(my_data.iloc[i * $ysnum + k, 3])
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

EOF;
//节点反力图脚本输出文件下载
$pythonfile2 = $filepath.'/'.'NS360.py';
$fpyn = fopen($pythonfile2,'w');
fwrite($fpyn,$pyn360);
fclose($fpyn);
echo <<<EOF
<p><a href="$pythonfile2">节点反力Python脚本下载</a>(右键另存为)</p>
EOF;
}
else{//有反弯矩的情况
$pyn360 = <<<EOF
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
for k in range(0, $ysnum):
	x = range(0, 360)
	yfx = []
	yfy = []
	yfz = []
	for i in range(0, 360):
		yfx.append(my_data.iloc[i * $ysnum + k, 1])
		yfy.append(my_data.iloc[i * $ysnum + k, 2])
		yfz.append(my_data.iloc[i * $ysnum + k, 3])
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
for k in range(0, $ysnum):
	x = range(0, 360)
	yfx = []
	yfy = []
	yfz = []
	for i in range(0, 360):
		yfx.append(my_data.iloc[i * $ysnum + k, 4])
		yfy.append(my_data.iloc[i * $ysnum + k, 5])
		yfz.append(my_data.iloc[i * $ysnum + k, 6])
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

EOF;
//节点反力图脚本输出文件下载
$pythonfile2 = $filepath.'/'.'NS360.py';
$fpyn = fopen($pythonfile2,'w');
fwrite($fpyn,$pyn360);
fclose($fpyn);
echo <<<EOF
<p><a href="$pythonfile2">节点反力Python脚本下载</a>(右键另存为)</p>
EOF;
}
}
if($af == 1){//轴力
$pys360 = <<<EOF
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
for k in range(0, $afnum):
	x = range(0, 360)
	y = []
	for i in range(0, 360):
		y.append(my_data.iloc[i * $afnum + k, 1])
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

EOF;
//杆件轴力图脚本输出文件下载
$pythonfile3 = $filepath.'/'.'ES360.py';
$fpye = fopen($pythonfile3,'w');
fwrite($fpye,$pys360);
fclose($fpye);
echo <<<EOF
<p><a href="$pythonfile3">杆件轴力Python脚本下载</a>(右键另存为)</p>
EOF;
}//轴力图输出脚本--结束
}//360工况输出脚本--结束
//处理一个bug，即使不选择杆轴力，但是杆轴力数量依然会传递给页面。因此真实的杆件数量是$af * $afnum
} 
else{
?>
        <form action="" method="post">
            <div id="lefttop">
                <div id="box1">
                    宏名称:<input type="text" name="macname" value="macname" id="macname">
                </div>
                <div class="cl"></div>
                <div id="box2">
                    <div id="box21">
                        加载点数量:
                        <input name="loadkpnum" type="radio" id="load1" value="1" checked>1
                        <input name="loadkpnum" type="radio" id="load4" value="4">4
                    </div>
                    <div id="box22">
                        约束点数量:
                        <select name="ysnum">
                            <option value="2" selected>2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div id="box23">
                        工况数量:
                        <input type="radio" checked name="casenum" value="8" id="case8">8
                        <div id="case360"><input type="radio" name="casenum" value="360" id="ca360">360</div>
                    </div>
                </div>
                <div id="box3">
                    <div id="box30">加载点关键点编号:</div>
                    <div id="box31">
                        <input name="kp1" type="text" value="1">
                        <input name="kp2" type="text" class="kp4" value="2">
                        <input name="kp3" type="text" class="kp4" value="3">
                        <input name="kp4" type="text" class="kp4" value="4">
                    </div>
                    <div id="box319">约束点node编号:</div>
                    <div id="box32">
                        <input type="text" name="node1" value="1">
                        <input type="text" name="node2" value="2">
                        <input type="text" name="node3" class="node" value="3">
                        <input type="text" name="node4" class="node" value="4">
                        <input type="text" name="node5" class="node" value="5">
                        <input type="text" name="node6" class="node" value="6">
                        <input type="text" name="node7" class="node" value="7">
                        <input type="text" name="node8" class="node" value="8">
                    </div>
                    <div id="box33">
                        <input type="checkbox" name="fix" value="1">约束旋转
                    </div>
                </div>
                <div class="cl"></div>
            </div>
            <!--lefttop-->
            <div id="righttop">
                <div id="box41">载荷</div>
                <div id="fv"><input type="checkbox" name="ckfv" value="1">垂直力<input type="text" name="fv" value="0"
                        disabled>t</div>
                <div id="fs"><input type="checkbox" name="ckfs" value="1">水平力<input type="text" name="fs" value="0"
                        disabled>t</div>
                <div id="m"><input type="checkbox" name="ckm" value="1">弯矩<input type="text" name="m" value="0"
                        disabled>t.m</div>
                <div id="mk"><input type="checkbox" name="ckmk" value="1">扭矩<input type="text" name="mk" value="0"
                        disabled>t.m</div>
                <div id="fmk"><input type="checkbox" name="ckfmk" value="1">扭矩力<input type="text" name="fmk" value="0"
                        disabled>t</div>
            </div>
            <!--righttop-->
            <div class="cl"></div>
            <div class="hline"></div>
            <div id="leftdown">
                <div id="box51">输出结果和截图</div>
                <div id="box52">
                    <div id="rf"><input type="checkbox" checked name="rf" value="1">反力</div>
                    <div id="fwj"><input type="checkbox" name="rm" value="1">反弯矩<br></div>
                    <div id="af"><input type="checkbox" name="af" value="1">杆轴力</div>
                    <div id="zhouli">
                        <div id="box521">数量</div>
                        <div id="box522">
                            <select name="afnum">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div id="box523">杆件elem编号:</div>
                        <div id="box524">
                            <input type="text" name="elem1" value="1">
                            <input type="text" name="elem2" class="elem" value="2">
                            <input type="text" name="elem3" class="elem" value="3">
                            <input type="text" name="elem4" class="elem" value="4">
                            <input type="text" name="elem5" class="elem" value="5">
                            <input type="text" name="elem6" class="elem" value="6">
                            <input type="text" name="elem7" class="elem" value="7">
                            <input type="text" name="elem8" class="elem" value="8">
                        </div>
                    </div>
                    <!--zhouli-->
                </div>
                <div id="box53">
                    <div id="box531"><input type="checkbox" name="dfx" value="1">整体X向位移</div>
                    <div id="box532"><input type="checkbox" name="dfy" value="1">整体y向位移</div>
                    <div id="box533"><input type="checkbox" name="dfz" value="1">整体z向位移</div>
                    <div id="box534"><input type="checkbox" name="dftotal" value="1">整体合位移</div>
                    <div id="box535"><input type="checkbox" name="stotal" value="1">整体合应力</div>
                </div>
                <div id="box54">
                    <div id="box541">组件CP数量</div>
                    <div id="box542">
                        <select name="cpnum">
                            <option value="0" selected>0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div id="cp">
                        <input type="checkbox" name="cpnx" value="1">组件CPN X向位移
                        <input type="checkbox" name="cpny" value="1">组件CPN y向位移
                        <input type="checkbox" name="cpnz" value="1">组件CPN z向位移
                        <input type="checkbox" name="cpnt" value="1">组件CPN 合位移
                        <input type="checkbox" name="cpnst" value="1">组件CPN 合应力
                    </div>
                </div>
            </div>
            <!--leftdown-->
            <div id="rightdown">
                <div id="shuoming">
                    <div id="shuo">说明</div>
                    <ol>
                        <li>宏名称使用英文字母开头，由字母和数字组成，长度不超过10位</li>
                        <li>需要对模型中组件截图时，应提前在模型中设置好line组件，且名称以‘CP+数字编号’的形式从CP1到CP8，最多支持设置8个组件，截图保存的顺序是先整体后组件</li>
                        <li>加载点从第四象限开始逆时针依次填入</li>
                        <li>8工况条件下可生成python脚本辅助汇总结果</li>
                        <li>一点加载360工况条件下可生成python脚本辅助生成反力曲线图</li>
                        <li>Z+为竖直向上，Y-为工况1，其余工况逆时针排列</li>
                        <li>边界约束、重力加速度以及大变形等前处理部分需提前在ANSYS中设置，本程序涉及的步骤为加载求解和后处理</li>
                    </ol>
                </div>
                <div class="cl"></div>
                <div id="button1">
                    <input type="submit" value="生成脚本">
                </div>
                <div id="button2">
                    <button type="button" onclick="javascript:location.reload()">重置页面</button>
                </div>
            </div>
            <div class="cl"></div>
        </form>
        <?php
}
?>
    </div>
    <!--main-->
</body>

</html>