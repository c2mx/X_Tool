//页面UI脚本

window.onload = function () {//初始化
  //根据最初的选项，设置各组件的属性
  //四点加载
  document.querySelector('input[id="load4"]').checked = true;
  //6个约束点
  var x = document.querySelectorAll('input[name^="node"]');
  for (i = 0; i < 6; i++) {
    x[i].disabled=false;
  }
  for (i = 6; i < 8; i++) {
    x[i].disabled=true;
  }
  //8工况
  document.querySelector('input[id="case8"]').checked = true;
  document.querySelector('input[id="ca360"]').disabled = true;
  //节点是否约束了旋转
  document.querySelector('input[id="fix"]').checked = false;
  //载荷
  document.querySelector('input[name="m"]').disabled = true;
  document.querySelector('input[name="mk"]').disabled = true;
  //提取节点反力
  document.querySelector('input[id="rf"]').checked = true;
  //提取节点反弯矩
  document.querySelector('input[id="rm"]').checked = false;
  document.querySelector('input[id="rm"]').disabled = true;
  //提取杆件轴力
  document.querySelector('input[id="af"]').checked = false;
  //杆件数量
  document.querySelector('select[id="sel2"]').disabled = true;
  //杆件编号
  var x2 = document.querySelectorAll('input[name^="elem"]');
  for (i = 0; i < 8; i++) {
    x2[i].disabled=true;
  }
  //组件截图
  var x3 = document.querySelectorAll('input[name^="cp"]');
  for (i = 0; i < 5; i++) {
    x3[i].disabled=true;
  }





  var inputtext = document.querySelectorAll('input[type="text"]');
  for (i = 0; i < inputtext.length; i++) {
    inputtext[i].addEventListener("click", function () {this.focus();});
    inputtext[i].addEventListener("focus", function () {this.select();});
  }

  document.querySelector('input[name="macname"]').addEventListener("input", function () {
      this.value = this.value.replace(/[^\w]/gi, "");
  });//过滤宏名称中的非法字符

  var keypoint = document.querySelectorAll('input[name^="kp"]');
  for (i = 0; i < keypoint.length; i++) {
    keypoint[i].addEventListener("input", function () {
      this.value = this.value.replace(/[^\d]/g, "");
    });
  }//过滤加载点编号中的非数字字符

  var node = document.querySelectorAll('input[name^="node"]');
  for (i = 0; i < node.length; i++) {
    node[i].addEventListener("input", function () {
      this.value = this.value.replace(/[^\d]/g, "");
    });
  }//过滤约束点编号中的非数字字符

  //过滤输入载荷中的非法字符
  document.querySelector('input[name="fv"]').addEventListener("input", function () {
      this.value = this.value.replace(/[^\d^\.]+/g, "");
    });
  document.querySelector('input[name="fs"]').addEventListener("input", function () {
      this.value = this.value.replace(/[^\d^\.]+/g, "");
    });
  document.querySelector('input[name="m"]').addEventListener("input", function () {
      this.value = this.value.replace(/[^\d^\.]+/g, "");
    });
  document.querySelector('input[name="mk"]').addEventListener("input", function () {
      this.value = this.value.replace(/[^\d^\.]+/g, "");
    });
  document.querySelector('input[name="fmk"]').addEventListener("input", function () {
      this.value = this.value.replace(/[^\d^\.]+/g, "");
    });

  var elem = document.querySelectorAll('input[name^="elem"]');
  for (i = 0; i < elem.length; i++) {
    elem[i].addEventListener("input", function () {
      this.value = this.value.replace(/[^\d]/g, "");
    });
  }//过滤杆件编号中的非数字字符

  document.querySelector('input[id="load1"]').addEventListener("change", changekp);//1点加载单选按钮改变
  document.querySelector('input[id="load4"]').addEventListener("change", changekp4);//4点加载单选按钮改变
  document.querySelector('select[name="ysnum"]').addEventListener("change", function () {
      changeys(this);
    });//约束点数量选项改变
  document.querySelector('input[name="fix"]').addEventListener("change", function () {
      ysxz(this);
    });//节点是否约束了旋转
  document.querySelector('input[name="af"]').addEventListener("change", function () {
      zhouli(this);
    });//提取杆件轴力
  document.querySelector('select[name="afnum"]').addEventListener("change", function () {
      changezl(this);
    });//杆件数量
  document.querySelector('select[name="cpnum"]').addEventListener("change", function () {
      changecp(this);
    });//组件CP数量
  document.querySelector('input[id="ca360"]').addEventListener("change", chca360);//360工况
  document.querySelector('input[id="case8"]').addEventListener("change", chca8);//8工况
};


function changekp() {
  document.querySelector('input[name="kp2"]').disabled=true;
  document.querySelector('input[name="kp3"]').disabled=true;
  document.querySelector('input[name="kp4"]').disabled=true;
  document.querySelector('input[name="m"]').disabled=false;
  document.querySelector('input[name="mk"]').disabled=false;
  document.querySelector('input[name="fmk"]').disabled=true;
  document.getElementById("ca360").disabled=false;
} //changekp加载点数量改为1时，改变加载关键点编号输入框数量，启用360工况，载荷启动弯矩和扭矩、禁用扭矩力
function changekp4() {
  document.querySelector('input[name="kp2"]').disabled=false;
  document.querySelector('input[name="kp3"]').disabled=false;
  document.querySelector('input[name="kp4"]').disabled=false;
  document.querySelector('input[name="m"]').disabled=true;
  document.querySelector('input[name="mk"]').disabled=true;
  document.querySelector('input[name="fmk"]').disabled=false;
  document.getElementById("case8").checked = true;
  document.getElementById("ca360").disabled=true;

  chca8();
} //changekp4加载点数量改为4时，改变加载关键点编号输入框数量，禁用360工况选中工况8，载荷启用扭矩力，禁用弯矩和扭矩
function changeys(sel) {
  var ysnum = parseInt(sel.value);
  var x = document.querySelectorAll('input[name^="node"]');
    for (i = 0; i < ysnum; i++) {
      x[i].disabled=false;
    }
    for (i = ysnum; i < 8; i++) {
      x[i].disabled=true;
    }
} //changeys约束点数量改变时，改变约束点编号输入框数量


function zhouli(sel) {
  if (sel.checked == true) {
    document.querySelector('select[id="sel2"]').disabled = false;
  } else {
    document.querySelector('select[id="sel2"]').disabled = true;
    document.querySelector('select[id="sel2"]').selectedIndex = 0;
    var x2 = document.querySelectorAll('input[name^="elem"]');
    for (i = 0; i < 8; i++) {
      x2[i].disabled=true;
    }
  }
} //改变杆轴力选中状态，改变杆数量极其编号输入框的显示状态


function ysxz(sel) {
  if (sel.checked == true) {
    document.querySelector('input[id="rm"]').disabled = false;
  } else {
    document.querySelector('input[id="rm"]').disabled = true;
    document.querySelector('input[id="rm"]').checked = false;
  }
} //约束旋转状态改变，改变反弯矩的显示


function changezl(sel) {
  var zlnum = parseInt(sel.value);
  var x = document.querySelectorAll('input[name^="elem"]');
    for (i = 0; i < zlnum; i++) {
      x[i].disabled=false;
    }
    for (i = zlnum; i < 8; i++) {
      x[i].disabled=true;
    }
} //changezl杆轴力数量改变时，改变杆件elem编号输入框数量


function changecp(sel) {
  if (sel.value == "0") {
    var x3 = document.querySelectorAll('input[name^="cp"]');
    for (i = 0; i < 5; i++) {
      x3[i].disabled=true;
      x3[i].checked=false;
    }
  } else {
    var x3 = document.querySelectorAll('input[name^="cp"]');
    for (i = 0; i < 5; i++) {
      x3[i].disabled=false;
    }
  }
} //组件数量0和非0时，改变组件结果输出选项的显示状态


function chca360() {
  //360工况不显示截图选项
  document.querySelector('input[name="dfx"]').disabled=true;
  document.querySelector('input[name="dfy"]').disabled=true;
  document.querySelector('input[name="dfz"]').disabled=true;
  document.querySelector('input[name="dftotal"]').disabled=true;
  document.querySelector('input[name="stotal"]').disabled=true;

  document.querySelector('input[name="cpnx"]').disabled=true;
  document.querySelector('input[name="cpny"]').disabled=true;
  document.querySelector('input[name="cpnz"]').disabled=true;
  document.querySelector('input[name="cpnt"]').disabled=true;
  document.querySelector('input[name="cpnst"]').disabled=true;

  document.querySelector('input[name="dfx"]').checked=false;
  document.querySelector('input[name="dfy"]').checked=false;
  document.querySelector('input[name="dfz"]').checked=false;
  document.querySelector('input[name="dftotal"]').checked=false;
  document.querySelector('input[name="stotal"]').checked=false;

  document.querySelector('input[name="cpnx"]').checked=false;
  document.querySelector('input[name="cpny"]').checked=false;
  document.querySelector('input[name="cpnz"]').checked=false;
  document.querySelector('input[name="cpnt"]').checked=false;
  document.querySelector('input[name="cpnst"]').checked=false;

  document.querySelector('select[id="sel3"]').selectedIndex = 0;
  document.querySelector('select[id="sel3"]').disabled = true;
}

function chca8() {
  //非360工况显示截图选项
  document.querySelector('input[name="dfx"]').disabled=false;
  document.querySelector('input[name="dfy"]').disabled=false;
  document.querySelector('input[name="dfz"]').disabled=false;
  document.querySelector('input[name="dftotal"]').disabled=false;
  document.querySelector('input[name="stotal"]').disabled=false;

  document.querySelector('input[name="cpnx"]').disabled=false;
  document.querySelector('input[name="cpny"]').disabled=false;
  document.querySelector('input[name="cpnz"]').disabled=false;
  document.querySelector('input[name="cpnt"]').disabled=false;
  document.querySelector('input[name="cpnst"]').disabled=false;

  document.querySelector('select[id="sel3"]').disabled = false;
}
