//页面UI脚本
function changekp(){
    var x = document.getElementsByClassName('kp4');
    for(i=0;i<3;i++){
        x[i].style.display='none';
    }
    document.getElementById('m').style.display='block';
    document.getElementById('mk').style.display='block';
    document.getElementById('fmk').style.display='none';
    document.getElementById('case360').style.display='inline';
}//changekp加载点数量改为1时，改变加载关键点编号输入框数量，启用360工况，载荷启动弯矩和扭矩、禁用扭矩力
function changekp4(){
    var x = document.getElementsByClassName('kp4');
    for(i=0;i<3;i++){
        x[i].style.display='inline';
    }
    document.getElementById('m').style.display='none';
    document.getElementById('mk').style.display='none';
    document.getElementById('fmk').style.display='block';
    document.getElementById('case360').style.display='none';
    document.getElementById('case8').checked=true;
    chca8();
}//changekp4加载点数量改为4时，改变加载关键点编号输入框数量，禁用360工况选中工况8，载荷启用扭矩力，禁用弯矩和扭矩
function changeys(sel){
    if(sel.value == '2'){
        var x = document.getElementsByClassName('node');
        for(i=0;i<6;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '3'){
        var x = document.getElementsByClassName('node');
        x[0].style.display='inline';
        for(i=1;i<6;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '4'){
        var x = document.getElementsByClassName('node');
        x[0].style.display='inline';
        x[1].style.display='inline';
        for(i=2;i<6;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '5'){
        var x = document.getElementsByClassName('node');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        for(i=3;i<6;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '6'){
        var x = document.getElementsByClassName('node');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        x[3].style.display='inline';
        for(i=4;i<6;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '7'){
        var x = document.getElementsByClassName('node');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        x[3].style.display='inline';
        x[4].style.display='inline';
        x[5].style.display='none';
    }
    else{
        var x = document.getElementsByClassName('node');
        for(i=0;i<6;i++){
            x[i].style.display='inline';
        }
    }
}//changeys约束点数量改变时，改变约束点编号输入框数量
function zhouli(sel){
    if(sel.checked == true){
        document.getElementById('zhouli').style.display='inline';
    }
    else{
        document.getElementById('zhouli').style.display='none';
    }
}//改变杆轴力选中状态，改变杆数量极其编号输入框的显示状态
function ysxz(sel){
    if(sel.checked == true){
        document.getElementById('fwj').style.display='inline';
    }
    else{
        document.getElementById('fwj').style.display='none';
    }
}//约束旋转状态改变，改变反弯矩的显示
function changezl(sel){
    if(sel.value == '1'){
        var x = document.getElementsByClassName('elem');
        for(i=0;i<7;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '2'){
        var x = document.getElementsByClassName('elem');
        x[0].style.display='inline';
        for(i=1;i<7;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '3'){
        var x = document.getElementsByClassName('elem');
        x[0].style.display='inline';
        x[1].style.display='inline';
        for(i=2;i<7;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '4'){
        var x = document.getElementsByClassName('elem');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        for(i=3;i<7;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '5'){
        var x = document.getElementsByClassName('elem');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        x[3].style.display='inline';
        for(i=4;i<7;i++){
            x[i].style.display='none';
        }
    }
    else if(sel.value == '6'){
        var x = document.getElementsByClassName('elem');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        x[3].style.display='inline';
        x[4].style.display='inline';
        x[5].style.display='none';
        x[6].style.display='none';
    }
    else if(sel.value == '7'){
        var x = document.getElementsByClassName('elem');
        x[0].style.display='inline';
        x[1].style.display='inline';
        x[2].style.display='inline';
        x[3].style.display='inline';
        x[4].style.display='inline';
        x[5].style.display='inline';
        x[6].style.display='none';
    }
    else{
        var x = document.getElementsByClassName('elem');
        for(i=0;i<7;i++){
            x[i].style.display='inline';
        }
    }
}//changezl杆轴力数量改变时，改变杆件elem编号输入框数量
function changecp(sel){
    if(sel.value == '0'){
        document.getElementById('cp').style.display='none';
    }
    else{
        document.getElementById('cp').style.display='inline';
    }
}//组件数量0和非0时，改变组件结果输出选项的显示状态

window.onload = function(){
    var inputtext = document.querySelectorAll('input[type="text"]');
    for(i=0;i<inputtext.length;i++){
        inputtext[i].addEventListener('click',function(){this.focus();});
        inputtext[i].addEventListener('focus',function(){this.select();});
    }
    document.querySelector('input[name="macname"]').addEventListener('input',function(){this.value=this.value.replace(/[^\w]/ig,'');});
    var keypoint = document.querySelectorAll('input.kp4');
    for(i=0;i<keypoint.length;i++){
        keypoint[i].addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    }
    document.querySelector('input[name="kp1"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    document.querySelector('input[name="node1"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    document.querySelector('input[name="node2"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    var node = document.querySelectorAll('input.node');
    for(i=0;i<node.length;i++){
        node[i].addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    }
    document.querySelector('input[name="fv"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d^\.]+/g,'');});
    document.querySelector('input[name="fs"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d^\.]+/g,'');});
    document.querySelector('input[name="m"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d^\.]+/g,'');});
    document.querySelector('input[name="mk"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d^\.]+/g,'');});
    document.querySelector('input[name="fmk"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d^\.]+/g,'');});
    document.querySelector('input[name="elem1"]').addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    var elem = document.querySelectorAll('input.elem');
    for(i=0;i<elem.length;i++){
        elem[i].addEventListener('input',function(){this.value=this.value.replace(/[^\d]/g,'');});
    }
    document.querySelector('input[id="load1"]').addEventListener('change',changekp);
    document.querySelector('input[id="load4"]').addEventListener('change',changekp4);
    document.querySelector('select[name="ysnum"]').addEventListener('change',function(){changeys(this)});
    document.querySelector('input[name="fix"]').addEventListener('change',function(){ysxz(this)});
    document.querySelector('input[name="af"]').addEventListener('change',function(){zhouli(this)});
    document.querySelector('select[name="afnum"]').addEventListener('change',function(){changezl(this)});
    document.querySelector('select[name="cpnum"]').addEventListener('change',function(){changecp(this)});
    document.querySelector('input[name="ckfv"]').addEventListener('change',function(){chckfv(this)});
    document.querySelector('input[name="ckfs"]').addEventListener('change',function(){chckfs(this)});
    document.querySelector('input[name="ckm"]').addEventListener('change',function(){chckm(this)});
    document.querySelector('input[name="ckmk"]').addEventListener('change',function(){chckmk(this)});
    document.querySelector('input[name="ckfmk"]').addEventListener('change',function(){chckfmk(this)});
    document.querySelector('input[id="ca360"]').addEventListener('change',chca360);
    document.querySelector('input[id="case8"]').addEventListener('change',chca8);
}

function chckfv(sel){
    if(sel.checked == true){
        document.querySelector('input[name="fv"]').disabled="";
    }
    else{
        document.querySelector('input[name="fv"]').disabled="disabled";
    }
}

function chckfs(sel){
    if(sel.checked == true){
        document.querySelector('input[name="fs"]').disabled="";
    }
    else{
        document.querySelector('input[name="fs"]').disabled="disabled";
    }
}

function chckm(sel){
    if(sel.checked == true){
        document.querySelector('input[name="m"]').disabled="";
    }
    else{
        document.querySelector('input[name="m"]').disabled="disabled";
    }
}

function chckmk(sel){
    if(sel.checked == true){
        document.querySelector('input[name="mk"]').disabled="";
    }
    else{
        document.querySelector('input[name="mk"]').disabled="disabled";
    }
}

function chckfmk(sel){
    if(sel.checked == true){
        document.querySelector('input[name="fmk"]').disabled="";
    }
    else{
        document.querySelector('input[name="fmk"]').disabled="disabled";
    }
}

function chca360(){ 
    //360工况不显示截图选项
    document.getElementById('box53').style.display="none";
    document.getElementById('box54').style.display="none";
}

function chca8(){
    //非360工况显示截图选项
    document.getElementById('box53').style.display="block";
    document.getElementById('box54').style.display="block";
}