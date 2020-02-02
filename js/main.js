//tagging.html part

window.onload = function(){
  if(document.location.href.indexOf('tagging')!=-1){
  findImg(0);
  }
}

var sendData = {num:0, jewelry_type:'',material_type:'',core_type:'',metal_color:'',core_color:'',setting_type:'',stone_shape:'',jewerly_name:'',type:1};

function createData(number, text){
  sendData.num=number;
  return sendData;
}

var count;

function findImg(num,txt){
  $.ajax({
    url:'./temp.php',
    type:'POST',
    data:createData(num,txt),
    success:function(data2){
      if(data2==1){
          $('#main_block').empty();
          $('#main_block').append("<h1>We're done!!</h1><h2>Let's watch yout DB</h2>");
      }
      else{
        if(num==1){
          $('#edge').empty();
        }
          $('#edge').append(data2);
      }
    }
  })
}


function getVal(){
  var btns = document.getElementsByName('jewelry_type');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
				sendData.jewelry_type = btns[i].value;
        break;
			}
    }

  btns = document.getElementsByName('material_type');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
 			  sendData.material_type = btns[i].value;
        break;
 			}
     }

  btns = document.getElementsByName('core_type');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
    		sendData.core_type = btns[i].value;
        break;
    	}
    }

  btns = document.getElementsByName('metal_color');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
        sendData.metal_color = btns[i].value;
        break;
      }
    }

  btns = document.getElementsByName('core_color');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
        sendData.core_color = btns[i].value;
        break;
      }
    }

  btns = document.getElementsByName('setting_type');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
        sendData.setting_type = btns[i].value;
        break;
      }
    }

  btns = document.getElementsByName('stone_shape');
  for(var i=0; i<btns.length; i++){
    if(btns[i].selected == true){
        sendData.stone_shape = btns[i].value;
        break;
      }
    }

}

function goNext(){
  getVal();
  findImg(1);
  clearSelect();
}

function clearSelect(){
  var select = document.getElementsByTagName('select');
  for(var i=0; i<select.length; i++){
      select[i].value='';
  }
}

//list.html part
var where_count =0;
var queryArray = new Array();
var arrayIndex = 0;
var query_where ="";

function findContext(context){
  var i=findLeast();
  for(i; i<arrayIndex; i+=1){
    if(queryArray[i]){
    if(queryArray[i].indexOf(context) != -1){
      return i;
    }
  }
}
  i=-1;
  return i;
}

function coloring(obj){
    if(obj.id=="button-color"){
      obj.id="button";
      where_count=1;
    }

    else{
      obj.id="button-color";
      where_count=0;
    }

    var value1 = obj.closest("div").previousSibling.previousSibling;

    while(value1.id!="theme"){
      value1=value1.previousSibling;
      if(value1.id=="theme"){
        break;
      }
    }

    value1=value1.className;
    var value2 = obj.text;

    if(where_count==0){
      var context_index = -1;
      context_index = findContext(value1);

      if(context_index==-1){
      queryArray[arrayIndex]="";
      queryArray[arrayIndex]+=("( "+value1+"="+'"'+value2+'"'+" )");
      arrayIndex+=1;
    }

    else{
      queryArray[context_index]=queryArray[context_index].replace(")","or "+value1+"="+'"'+value2+'"'+" )");
    }

  }

  else{
    eraseText(value1, value2);
  }

    $('#product').empty();
    firstSet(obj,value1,value2);
}


 function eraseText(value1, value2){
  var erase_index = findContext(value1);
  var text1 = " or "+value1+"="+'"'+value2+'"';
  var text2 = value1+"="+'"'+value2+'"'+" or ";

  if(queryArray[erase_index].indexOf(text1)!=-1){

    queryArray[erase_index]=queryArray[erase_index].replace(text1," ");

  }
  else if(queryArray[erase_index].indexOf(text2)!=-1){
    queryArray[erase_index]=queryArray[erase_index].replace(text2,"");
  }
  else{
    queryArray.splice(erase_index,1);
  }
 }

var show_amount=3;

function createData2(){
  var sendData2 = { where:query_where,type:2, show:show_amount};
  return sendData2;
}

function findLeast(){
  for(var i=0; i<arrayIndex; i+=1)
  {
    if(queryArray[i])
    {return i;}
  }
}

function firstSet(obj){
  query_where="where ";
  var least = findLeast();
  var start = least;
  for(var start; start<arrayIndex; start+=1)
  {
    if(queryArray[start]){
    if(start==least)
      {
        query_where+=queryArray[start];
      }
    else{
      query_where+=" and "+queryArray[start];
    }
  }
  }

 // alert(query_where+'1');

if(query_where!="where "&& query_where!=""){
  $.ajax({
             url:'./temp.php',
             type:'POST',
             data:createData2(),
             success:function(data2){
               // alert(data2);
               $('h3').empty();
               if(data2==0){
                  $('h3').append("결과가 없습니다!!");
               }

               else{
                 $('#product').append(data2);
                 if(show_amount>4){
                  $('#product').find('img').css({'width': '210px', 'height':'190px'});
                  $('#product').find('div').css({'width': '210px', 'height':'190px','margin-top': '-190px'});
                }
              }

             }
           })
         }
  else{
    $('h3').empty();
    $('h3').append("찾고싶은 항목을 클릭하세요!!");
  }
}

function createData3(obj){
  var img_name = obj.previousSibling.previousSibling.src;
  var temp=0;
  for(var i=0; i<img_name.length; i+=1){
    if(img_name[i]=="/"){
      temp=i;
    }
  }
  img_name = "where jewelry_name = "+'"'+img_name.substring(temp+1,img_name.length-4)+'"';
// alert(img_name);

  var sendData3 = {name:img_name,type:3};
  return sendData3;
}

function showProperty(obj){
  $.ajax({
             url:'./temp.php',
             type:'POST',
             data:createData3(obj),
             success:function(data3){
               // alert(data3);
               $('#lay').empty();

               $('#lay').append(data3);
             }
           })
}

function abspos(e){
    this.x = e.clientX + (document.documentElement.scrollLeft?document.documentElement.scrollLeft:document.body.scrollLeft);
    this.y = e.clientY + (document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop);
    return this;
}


function popupOn(e, obj){
    var ex_obj = document.getElementById('lay');
    if(!e) e = window.Event;
    pos = abspos(e);
    ex_obj.style.left = pos.x+50+"px";
    ex_obj.style.top = (pos.y-200)+"px";
    showProperty(obj);
    $('#lay').css({}).show();
}

function popupDown(){
  $('#lay').css({}).hide();
}

$(function() {
    $( "#slider" ).slider();

  });

  $(function() {
     $( "#slider-range-min" ).slider({
       range: "min",
       value: 3,
       min: 3,
       max: 6,
       slide: function( event, ui ) {
         if(show_amount!=ui.value){
           show_amount=ui.value;
           changeShow();
         }

         $( "#amount" ).val(ui.value+"개씩");


       }
     });
     $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" )+"개씩");

   });

function changeShow(){
  // alert(query_where);
  if(query_where!="where " && query_where!=""){
  $.ajax({
             url:'./temp.php',
             type:'POST',
             data:createData2(),
             success:function(data2){

                 $('h3').empty();
                 if(data2==0){
                    $('h3').append("결과가 없습니다!!");
                 }

                 else{
                   $('#product').empty();
                   $('#product').append(data2);
                      if(show_amount>4){
                        $('#product').find('img').css({'width': '210px', 'height':'190px'});
                        $('#product').find('div').css({'width': '210px', 'height':'190px','margin-top': '-190px'});
                      }
                }

             }
           })
         }
}

//upload.html part