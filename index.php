<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/style1.css">
    <link rel="stylesheet" type="text/css" href="./css/style1-pinterest.css">
    <link rel="stylesheet" type="text/css" href="./css/style1-calendar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/modallocation.css">
    <link rel="stylesheet" type="text/css" href="./css/style1-uppertool.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/calendar.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/pinterest.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/search.js" type="text/javascript" charset="utf-8"></script>

</head>

<body>
    <!--=================================== 상단 툴바 ===================================-->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation" style="border-bottom-width:2px; background-color: #fff;">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="./" style="color: #FB464C;"><strong>HealingHome</strong></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="col-sm-offset-2 col-md-5 ">
                    <div class="input-group">
                        <input type="text" class="form-control" id="query" onkeypress="if(event.keyCode==13) {simpleSearch(); return false;}" placeholder="어디로 가시나요?">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button" onclick=simpleSearch()>
                          <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                      session_start();
                      if(isset($_SESSION['is_login'])) {
                        echo '<li>
                            <button type="button" class="btn btn-link" onclick=location.replace("./logout.php")>로그아웃</button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-link" onclick=location.href="./mypage.php";>마이페이지</button>
                        </li>';
                        echo '<script>$("#query").attr("placeholder", "'.$_SESSION['name'].'님 어디로 가시나요?")</script>';
                      }
                      else {
                        echo '<li>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">로그인</button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal1">회원가입</button>
                        </li>';
                      }
                    ?>
                    <li>
                        <button type="button" class="btn btn-link" onclick="location.href='./customer.php'" style="text-decoration: none; color: #FB464C;">고객센터</button>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!--=================================== 로그인 모달 ===================================-->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal 내용-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">로그인</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">이메일</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" placeholder="healing@home.com">
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="pwd">비밀번호</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="pwd" placeholder="********">
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button type="button" class="btn btn-primary" id="login">로그인</button>
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <p>아직 가입을 안하셨습니까?
                        <button type="link" class="btn btn-link" data-dismiss="modal" data-toggle="modal" data-target="#myModal1">회원가입</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
    $('#login').click(function(){
      login();
    });
    $("#email").keydown(function(e){if(e.keyCode == 13)  login(); });
    $("#pwd").keydown(function(e){if(e.keyCode == 13)  login(); });

    function login() {
      $('.warning').html('');
      if($('#email').val() == '') {
        $('#email').parent().children('span').html("이메일을 입력해주세요.");
      }
      if($('#pwd').val() == '') {
        $('#pwd').parent().children('span').html("비밀번호를 입력해주세요.");
      }
      else if($('#email').val() != '' & $('#pwd').val() != '') {
        $.ajax({
          url:'./login_proc.php',
          type:'post',
          data:{id:$('#email').val(),pwd:$('#pwd').val()},
          success:function(data){
            if(data == $('#email').val()) {
              window.location.reload(true);
            }
            else {
              $('#login').parent().children('span').html(data);
            }
          },
          error:function(data){
            alert('오류가 발생했습니다.');
          }
        });
      }
    }
    </script>
    <!--=================================== 회원가입 모달 ===================================-->
    <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog">
            <!-- Modal 내용-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">회원가입</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">이메일</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email2" placeholder="이메일을 입력하시오">
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">이름</label>
                            <div class="col-sm-8">
                                <input type="name" class="form-control" id="name" placeholder="이름을 입력하시오">
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="pwd">비밀번호</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="pwd2" placeholder="비밀번호를 입력하시오">
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px">
                            <label class="control-label col-sm-3" for="pnumber">휴대폰번호</label>
                            <div class="col col-sm-8">
                                <input type="phone-number" class="form-control" id="pnumber" placeholder="'-'없이 입력하시오" maxlength="13">
                                <div class="col-sm-offset-1">
                                    <button type="button" class="btn btn-default">실명확인</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3"></label>
                            <div class="col-sm-8">
                                <span class="warning" style="color: #FB464C"></span>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button type="button" class="btn btn-primary" id="register">가입하기</button>
                                <span class="warning" style="color: #FB464C"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <p>이미 가입하셨습니까?
                        <button type="link" class="btn btn-link" data-dismiss="modal" data-toggle="modal" data-target="#myModal">로그인</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
    $('#register').click(function(){
      $('.warning').html('');
      var validation = true;
      if($('#email2').val() == '') {
        $('#email2').parent().children('span').html("이메일을 입력해주세요.");
        validation = false;
      }
      else {
        var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
        //이메일 형식이 알파벳+숫자@알파벳+숫자.알파벳+숫자 형식이 아닐경우
        if(!exptext.test($('#email2').val())){
          $('#email2').parent().children('span').html("이메일을 형식이 올바르지 않습니다.");
          validation = false;
        }
      }
      if($('#name').val() == '') {
        $('#name').parent().children('span').html("이름을 입력해주세요.");
        validation = false;
      }
      if($('#pwd2').val() == '') {
        $('#pwd2').parent().children('span').html("비밀번호를 입력해주세요.");
        validation = false;
      }
      if($('#pnumber').val() == '') {
        $('#pnumber').parent().parent().next().children('div').children('span').html("휴대폰번호를 입력해주세요.");
        validation = false;
      }
      else {
        var regExp = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/;
 
        if(!regExp.test($('#pnumber').val())) {
          $('#pnumber').parent().parent().next().children('div').children('span').html("휴대폰번호를 확인해주세요.");
          validation = false;
        }
      }

      if(validation) {
        $.ajax({
          url:'./register_proc.php',
          type:'post',
          data:{id:$('#email2').val(),pwd:$('#pwd2').val(),name:$('#name').val(),phone:$('#pnumber').val()},
          success:function(data){
            if(data == '회원가입이 완료되었습니다.') {
              alert(data);
              window.location.reload(true);
            }
            else {
              $('#register').parent().children('span').html(data);
            }
          },
          error:function(data){
            alert('오류가 발생했습니다.');
          }
        });
      }
    });

    function autoHypenPhone(str){
        str = str.replace(/[^0-9]/g, '');
        var tmp = '';
        if( str.length < 4){
            return str;
        }else if(str.length < 7){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3);
            return tmp;
        }else if(str.length < 11){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 3);
            tmp += '-';
            tmp += str.substr(6);
            return tmp;
        }else{
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 4);
            tmp += '-';
            tmp += str.substr(7);
            return tmp;
        }
        return str;
    }

    $("#pnumber").keyup(function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = autoHypenPhone(_val) ;
    });

    </script>

    <!--=================================== 배경 광고 및 상세 검색 ===================================-->
    <div class="advertisement">
        <div class="intro-header">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-message">
                            <h1 style="font-family: cursive;"><strong>HealingHome</strong></h1>
                            <hr class="intro-divider">
                            <ul class="list-inline intro-social-buttons">
                                <li>
                                  <div class="item2-search" data-toggle="modal" data-target="#location"><input type="text" class="form-control" placeholder="지역" id="region"></div>
                              </li>
                              <li>
                                  <div class="item2-search" data-toggle="modal" data-target="#location"><input type="text" class="form-control" placeholder="상세지역"id="address"></div>
                                </li>
                            </ul>
                            <ul class="list-inline intro-social-buttons">
                                <li>
                                    <div class="item2-search"><input type="text" class="form-control" id="datepicker1" placeholder="체크인" readonly="true" style="background-color:#fff"></div>
                                </li>
                                <li>
                                    <div class="item2-search"><input type="text" class="form-control" id="datepicker2" placeholder="체크아웃" readonly="true" style="background-color:#fff"></div>
                                </li>
                                <li>
                                    <div class="item2-last" style="display:flex; padding:6px 12px;">
                                        <div class="form-group">
                                            <select class="form-control" id="number">
                                              <option>숙박인원 2명</option>
                                              <option>숙박인원 3명</option>
                                              <option>숙박인원 4명</option>
                                            </select>
                                        </div>
                                        <div class="item2-search"><button type="button" class="btn btn-default" onclick="search()">검색</button></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container -->

        </div>
    </div>

    <!-- 지역 검색 modal -->
    <div class="location modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">지역</h4>
                </div>
                <div class="modal-body">
                  <button id="btnlocation-1" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation1">서울</button>
                  <button id="btnlocation-2" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation2">경기</button>
                  <button id="btnlocation-3" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation3">인천</button>
                  <button id="btnlocation-4" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation4">강원</button>
                  <button id="btnlocation-5" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation5">부산</button>
                  <button id="btnlocation-6" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation6">경남</button>
                  <button id="btnlocation-7" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation7">대구</button>
                  <button id="btnlocation-8" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation8">경북</button>

                  <button id="btnlocation-9" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation9">대전</button>
                  <button id="btnlocation-10" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation10">충남</button>
                  <button id="btnlocation-11" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation11">충북</button>
                  <button id="btnlocation-12" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation12">광주</button>
                  <button id="btnlocation-13" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation13">전남</button>
                  <button id="btnlocation-14" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation14">울산</button>
                  <button id="btnlocation-15" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation15">전북</button>
                  <button id="btnlocation-16" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#detaillocation16">제주</button>
                </div>
            </div>
        </div>
    </div>

    <!--서울 modal -->
    <div class="location modal fade" id="detaillocation1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">서울</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-1" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-2" type="button" class="btn btn-default" data-dismiss="modal">강남구</button>
                  <button id="btndetaillocation-3" type="button" class="btn btn-default" data-dismiss="modal">강동구</button>
                  <button id="btndetaillocation-4" type="button" class="btn btn-default" data-dismiss="modal">강북구</button>
                  <button id="btndetaillocation-5" type="button" class="btn btn-default" data-dismiss="modal">강서구</button>
                  <button id="btndetaillocation-6" type="button" class="btn btn-default" data-dismiss="modal">관악구</button>
                  <button id="btndetaillocation-7" type="button" class="btn btn-default" data-dismiss="modal">광진구</button>
                  <button id="btndetaillocation-8" type="button" class="btn btn-default" data-dismiss="modal">구로구</button>
                  <button id="btndetaillocation-9" type="button" class="btn btn-default" data-dismiss="modal">금천구</button>
                  <button id="btndetaillocation-10" type="button" class="btn btn-default" data-dismiss="modal">노원구</button>
                  <button id="btndetaillocation-11" type="button" class="btn btn-default" data-dismiss="modal">도봉구</button>
                  <button id="btndetaillocation-12" type="button" class="btn btn-default" data-dismiss="modal">동대문구</button>
                  <button id="btndetaillocation-13" type="button" class="btn btn-default" data-dismiss="modal">동작구</button>
                  <button id="btndetaillocation-14" type="button" class="btn btn-default" data-dismiss="modal">마포구</button>
                  <button id="btndetaillocation-15" type="button" class="btn btn-default" data-dismiss="modal">서대문구</button>
                  <button id="btndetaillocation-16" type="button" class="btn btn-default" data-dismiss="modal">서초구</button>
                  <button id="btndetaillocation-17" type="button" class="btn btn-default" data-dismiss="modal">성동구</button>
                  <button id="btndetaillocation-18" type="button" class="btn btn-default" data-dismiss="modal">성북구</button>
                  <button id="btndetaillocation-19" type="button" class="btn btn-default" data-dismiss="modal">양천구</button>
                  <button id="btndetaillocation-20" type="button" class="btn btn-default" data-dismiss="modal">영등포구</button>
                  <button id="btndetaillocation-21" type="button" class="btn btn-default" data-dismiss="modal">용산구</button>
                  <button id="btndetaillocation-22" type="button" class="btn btn-default" data-dismiss="modal">은평구</button>
                  <button id="btndetaillocation-23" type="button" class="btn btn-default" data-dismiss="modal">종로구</button>
                  <button id="btndetaillocation-24" type="button" class="btn btn-default" data-dismiss="modal">중구</button>
                  <button id="btndetaillocation-25" type="button" class="btn btn-default" data-dismiss="modal">중랑구</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <!--경기 modal -->
    <div class="location modal fade" id="detaillocation2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">경기</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-26" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-27" type="button" class="btn btn-default" data-dismiss="modal">가평군</button>
                  <button id="btndetaillocation-28" type="button" class="btn btn-default" data-dismiss="modal">고양시</button>
                  <button id="btndetaillocation-29" type="button" class="btn btn-default" data-dismiss="modal">과천시</button>
                  <button id="btndetaillocation-30" type="button" class="btn btn-default" data-dismiss="modal">광명시</button>
                  <button id="btndetaillocation-31" type="button" class="btn btn-default" data-dismiss="modal">광주시</button>
                  <button id="btndetaillocation-32" type="button" class="btn btn-default" data-dismiss="modal">구리시</button>
                  <button id="btndetaillocation-33" type="button" class="btn btn-default" data-dismiss="modal">군포시</button>
                  <button id="btndetaillocation-34" type="button" class="btn btn-default" data-dismiss="modal">김포시</button>
                  <button id="btndetaillocation-35" type="button" class="btn btn-default" data-dismiss="modal">남양주시</button>
                  <button id="btndetaillocation-36" type="button" class="btn btn-default" data-dismiss="modal">동두천시</button>
                  <button id="btndetaillocation-37" type="button" class="btn btn-default" data-dismiss="modal">부천시</button>
                  <button id="btndetaillocation-38" type="button" class="btn btn-default" data-dismiss="modal">성남시</button>
                  <button id="btndetaillocation-39" type="button" class="btn btn-default" data-dismiss="modal">수원시</button>
                  <button id="btndetaillocation-40" type="button" class="btn btn-default" data-dismiss="modal">시흥시</button>
                  <button id="btndetaillocation-41" type="button" class="btn btn-default" data-dismiss="modal">안산시</button>
                  <button id="btndetaillocation-42" type="button" class="btn btn-default" data-dismiss="modal">안성시</button>
                  <button id="btndetaillocation-43" type="button" class="btn btn-default" data-dismiss="modal">안양시</button>
                  <button id="btndetaillocation-44" type="button" class="btn btn-default" data-dismiss="modal">양주시</button>
                  <button id="btndetaillocation-45" type="button" class="btn btn-default" data-dismiss="modal">양평군</button>
                  <button id="btndetaillocation-46" type="button" class="btn btn-default" data-dismiss="modal">여주시</button>
                  <button id="btndetaillocation-47" type="button" class="btn btn-default" data-dismiss="modal">연천군</button>
                  <button id="btndetaillocation-48" type="button" class="btn btn-default" data-dismiss="modal">오산시</button>
                  <button id="btndetaillocation-49" type="button" class="btn btn-default" data-dismiss="modal">용인시</button>
                  <button id="btndetaillocation-50" type="button" class="btn btn-default" data-dismiss="modal">의왕시</button>
                  <button id="btndetaillocation-51" type="button" class="btn btn-default" data-dismiss="modal">의정부시</button>
                  <button id="btndetaillocation-52" type="button" class="btn btn-default" data-dismiss="modal">이천시</button>
                  <button id="btndetaillocation-53" type="button" class="btn btn-default" data-dismiss="modal">파주시</button>
                  <button id="btndetaillocation-54" type="button" class="btn btn-default" data-dismiss="modal">평택시</button>
                  <button id="btndetaillocation-55" type="button" class="btn btn-default" data-dismiss="modal">포천시</button>
                  <button id="btndetaillocation-56" type="button" class="btn btn-default" data-dismiss="modal">하남시</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">인천</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-57" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-58" type="button" class="btn btn-default" data-dismiss="modal">계양구</button>
                  <button id="btndetaillocation-59" type="button" class="btn btn-default" data-dismiss="modal">남구</button>
                  <button id="btndetaillocation-60" type="button" class="btn btn-default" data-dismiss="modal">남동구</button>
                  <button id="btndetaillocation-61" type="button" class="btn btn-default" data-dismiss="modal">동구</button>
                  <button id="btndetaillocation-62" type="button" class="btn btn-default" data-dismiss="modal">부평구</button>
                  <button id="btndetaillocation-63" type="button" class="btn btn-default" data-dismiss="modal">서구</button>
                  <button id="btndetaillocation-64" type="button" class="btn btn-default" data-dismiss="modal">연수구</button>
                  <button id="btndetaillocation-65" type="button" class="btn btn-default" data-dismiss="modal">중구</button>
                  <button id="btndetaillocation-66" type="button" class="btn btn-default" data-dismiss="modal">강화군</button>
                  <button id="btndetaillocation-67" type="button" class="btn btn-default" data-dismiss="modal">웅진군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">강원</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-68" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-69" type="button" class="btn btn-default" data-dismiss="modal">강릉시</button>
                  <button id="btndetaillocation-70" type="button" class="btn btn-default" data-dismiss="modal">동해시</button>
                  <button id="btndetaillocation-71" type="button" class="btn btn-default" data-dismiss="modal">삼척시</button>
                  <button id="btndetaillocation-72" type="button" class="btn btn-default" data-dismiss="modal">속초시</button>
                  <button id="btndetaillocation-73" type="button" class="btn btn-default" data-dismiss="modal">원주시</button>
                  <button id="btndetaillocation-74" type="button" class="btn btn-default" data-dismiss="modal">춘천시</button>
                  <button id="btndetaillocation-75" type="button" class="btn btn-default" data-dismiss="modal">태백시</button>
                  <button id="btndetaillocation-76" type="button" class="btn btn-default" data-dismiss="modal">고성군</button>
                  <button id="btndetaillocation-77" type="button" class="btn btn-default" data-dismiss="modal">양구군</button>
                  <button id="btndetaillocation-78" type="button" class="btn btn-default" data-dismiss="modal">양양군</button>
                  <button id="btndetaillocation-79" type="button" class="btn btn-default" data-dismiss="modal">영월군</button>
                  <button id="btndetaillocation-80" type="button" class="btn btn-default" data-dismiss="modal">인제군</button>
                  <button id="btndetaillocation-81" type="button" class="btn btn-default" data-dismiss="modal">정선군</button>
                  <button id="btndetaillocation-82" type="button" class="btn btn-default" data-dismiss="modal">철원군</button>
                  <button id="btndetaillocation-83" type="button" class="btn btn-default" data-dismiss="modal">평창군</button>
                  <button id="btndetaillocation-84" type="button" class="btn btn-default" data-dismiss="modal">홍천군</button>
                  <button id="btndetaillocation-85" type="button" class="btn btn-default" data-dismiss="modal">화천군</button>
                  <button id="btndetaillocation-86" type="button" class="btn btn-default" data-dismiss="modal">횡성군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">부산</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-87" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-88" type="button" class="btn btn-default" data-dismiss="modal">강서구</button>
                  <button id="btndetaillocation-89" type="button" class="btn btn-default" data-dismiss="modal">금정구</button>
                  <button id="btndetaillocation-90" type="button" class="btn btn-default" data-dismiss="modal">남구</button>
                  <button id="btndetaillocation-91" type="button" class="btn btn-default" data-dismiss="modal">동구</button>
                  <button id="btndetaillocation-92" type="button" class="btn btn-default" data-dismiss="modal">동래구</button>
                  <button id="btndetaillocation-93" type="button" class="btn btn-default" data-dismiss="modal">부산진구</button>
                  <button id="btndetaillocation-94" type="button" class="btn btn-default" data-dismiss="modal">북구</button>
                  <button id="btndetaillocation-95" type="button" class="btn btn-default" data-dismiss="modal">사상구</button>
                  <button id="btndetaillocation-96" type="button" class="btn btn-default" data-dismiss="modal">사하구</button>
                  <button id="btndetaillocation-97" type="button" class="btn btn-default" data-dismiss="modal">서구</button>
                  <button id="btndetaillocation-98" type="button" class="btn btn-default" data-dismiss="modal">수영구</button>
                  <button id="btndetaillocation-99" type="button" class="btn btn-default" data-dismiss="modal">연제구</button>
                  <button id="btndetaillocation-100" type="button" class="btn btn-default" data-dismiss="modal">영도구</button>
                  <button id="btndetaillocation-101" type="button" class="btn btn-default" data-dismiss="modal">중구</button>
                  <button id="btndetaillocation-102" type="button" class="btn btn-default" data-dismiss="modal">해운대구</button>
                  <button id="btndetaillocation-103" type="button" class="btn btn-default" data-dismiss="modal">기장군</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">경남</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-104" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-105" type="button" class="btn btn-default" data-dismiss="modal">거제시</button>
                  <button id="btndetaillocation-106" type="button" class="btn btn-default" data-dismiss="modal">김해시</button>
                  <button id="btndetaillocation-107" type="button" class="btn btn-default" data-dismiss="modal">마산시</button>
                  <button id="btndetaillocation-108" type="button" class="btn btn-default" data-dismiss="modal">밀양시</button>
                  <button id="btndetaillocation-109" type="button" class="btn btn-default" data-dismiss="modal">사천시</button>
                  <button id="btndetaillocation-110" type="button" class="btn btn-default" data-dismiss="modal">울산시</button>
                  <button id="btndetaillocation-111" type="button" class="btn btn-default" data-dismiss="modal">진주시</button>
                  <button id="btndetaillocation-112" type="button" class="btn btn-default" data-dismiss="modal">진해시</button>
                  <button id="btndetaillocation-113" type="button" class="btn btn-default" data-dismiss="modal">창원시</button>
                  <button id="btndetaillocation-114" type="button" class="btn btn-default" data-dismiss="modal">통영시</button>
                  <button id="btndetaillocation-115" type="button" class="btn btn-default" data-dismiss="modal">거창군</button>
                  <button id="btndetaillocation-116" type="button" class="btn btn-default" data-dismiss="modal">고성군</button>
                  <button id="btndetaillocation-117" type="button" class="btn btn-default" data-dismiss="modal">남해군</button>
                  <button id="btndetaillocation-118" type="button" class="btn btn-default" data-dismiss="modal">산청군</button>
                  <button id="btndetaillocation-119" type="button" class="btn btn-default" data-dismiss="modal">양산시</button>
                  <button id="btndetaillocation-120" type="button" class="btn btn-default" data-dismiss="modal">의령군</button>
                  <button id="btndetaillocation-121" type="button" class="btn btn-default" data-dismiss="modal">창녕군</button>
                  <button id="btndetaillocation-122" type="button" class="btn btn-default" data-dismiss="modal">하동군</button>
                  <button id="btndetaillocation-123" type="button" class="btn btn-default" data-dismiss="modal">함안군</button>
                  <button id="btndetaillocation-124" type="button" class="btn btn-default" data-dismiss="modal">함양군</button>
                  <button id="btndetaillocation-125" type="button" class="btn btn-default" data-dismiss="modal">합천군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">대구</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-126" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-127" type="button" class="btn btn-default" data-dismiss="modal">남구</button>
                  <button id="btndetaillocation-128" type="button" class="btn btn-default" data-dismiss="modal">달서구</button>
                  <button id="btndetaillocation-129" type="button" class="btn btn-default" data-dismiss="modal">동구</button>
                  <button id="btndetaillocation-130" type="button" class="btn btn-default" data-dismiss="modal">북구</button>
                  <button id="btndetaillocation-131" type="button" class="btn btn-default" data-dismiss="modal">서구</button>
                  <button id="btndetaillocation-132" type="button" class="btn btn-default" data-dismiss="modal">수성구</button>
                  <button id="btndetaillocation-133" type="button" class="btn btn-default" data-dismiss="modal">중구</button>
                  <button id="btndetaillocation-134" type="button" class="btn btn-default" data-dismiss="modal">달성군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">경북</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-135" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-136" type="button" class="btn btn-default" data-dismiss="modal">경산시</button>
                  <button id="btndetaillocation-137" type="button" class="btn btn-default" data-dismiss="modal">경주시</button>
                  <button id="btndetaillocation-138" type="button" class="btn btn-default" data-dismiss="modal">구미시</button>
                  <button id="btndetaillocation-139" type="button" class="btn btn-default" data-dismiss="modal">김천시</button>
                  <button id="btndetaillocation-140" type="button" class="btn btn-default" data-dismiss="modal">문겅시</button>
                  <button id="btndetaillocation-141" type="button" class="btn btn-default" data-dismiss="modal">상주시</button>
                  <button id="btndetaillocation-142" type="button" class="btn btn-default" data-dismiss="modal">안동시</button>
                  <button id="btndetaillocation-143" type="button" class="btn btn-default" data-dismiss="modal">영주시</button>
                  <button id="btndetaillocation-144" type="button" class="btn btn-default" data-dismiss="modal">영천시</button>
                  <button id="btndetaillocation-145" type="button" class="btn btn-default" data-dismiss="modal">포항시</button>
                  <button id="btndetaillocation-146" type="button" class="btn btn-default" data-dismiss="modal">고령군</button>
                  <button id="btndetaillocation-147" type="button" class="btn btn-default" data-dismiss="modal">군위군</button>
                  <button id="btndetaillocation-148" type="button" class="btn btn-default" data-dismiss="modal">봉화군</button>
                  <button id="btndetaillocation-149" type="button" class="btn btn-default" data-dismiss="modal">성주군</button>
                  <button id="btndetaillocation-150" type="button" class="btn btn-default" data-dismiss="modal">영덕군</button>
                  <button id="btndetaillocation-151" type="button" class="btn btn-default" data-dismiss="modal">영양군</button>
                  <button id="btndetaillocation-152" type="button" class="btn btn-default" data-dismiss="modal">예천군</button>
                  <button id="btndetaillocation-153" type="button" class="btn btn-default" data-dismiss="modal">울릉군</button>
                  <button id="btndetaillocation-154" type="button" class="btn btn-default" data-dismiss="modal">울진군</button>
                  <button id="btndetaillocation-155" type="button" class="btn btn-default" data-dismiss="modal">의성군</button>
                  <button id="btndetaillocation-156" type="button" class="btn btn-default" data-dismiss="modal">청도군</button>
                  <button id="btndetaillocation-157" type="button" class="btn btn-default" data-dismiss="modal">청송군</button>
                  <button id="btndetaillocation-158" type="button" class="btn btn-default" data-dismiss="modal">칠곡군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">대전</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-159" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-160" type="button" class="btn btn-default" data-dismiss="modal">대덕구</button>
                  <button id="btndetaillocation-161" type="button" class="btn btn-default" data-dismiss="modal">동구</button>
                  <button id="btndetaillocation-162" type="button" class="btn btn-default" data-dismiss="modal">서구</button>
                  <button id="btndetaillocation-163" type="button" class="btn btn-default" data-dismiss="modal">유성구</button>
                  <button id="btndetaillocation-164" type="button" class="btn btn-default" data-dismiss="modal">중구</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">충남</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-165" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-166" type="button" class="btn btn-default" data-dismiss="modal">공주시</button>
                  <button id="btndetaillocation-167" type="button" class="btn btn-default" data-dismiss="modal">보령시</button>
                  <button id="btndetaillocation-168" type="button" class="btn btn-default" data-dismiss="modal">서산시</button>
                  <button id="btndetaillocation-169" type="button" class="btn btn-default" data-dismiss="modal">아산시</button>
                  <button id="btndetaillocation-170" type="button" class="btn btn-default" data-dismiss="modal">천안시</button>
                  <button id="btndetaillocation-171" type="button" class="btn btn-default" data-dismiss="modal">금산군</button>
                  <button id="btndetaillocation-172" type="button" class="btn btn-default" data-dismiss="modal">논산군</button>
                  <button id="btndetaillocation-173" type="button" class="btn btn-default" data-dismiss="modal">당진군</button>
                  <button id="btndetaillocation-174" type="button" class="btn btn-default" data-dismiss="modal">부여군</button>
                  <button id="btndetaillocation-175" type="button" class="btn btn-default" data-dismiss="modal">서천군</button>
                  <button id="btndetaillocation-176" type="button" class="btn btn-default" data-dismiss="modal">연기군</button>
                  <button id="btndetaillocation-177" type="button" class="btn btn-default" data-dismiss="modal">예산군</button>
                  <button id="btndetaillocation-178" type="button" class="btn btn-default" data-dismiss="modal">청양군</button>
                  <button id="btndetaillocation-179" type="button" class="btn btn-default" data-dismiss="modal">태안군</button>
                  <button id="btndetaillocation-180" type="button" class="btn btn-default" data-dismiss="modal">홍성군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">충북</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-181" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-182" type="button" class="btn btn-default" data-dismiss="modal">제천시</button>
                  <button id="btndetaillocation-183" type="button" class="btn btn-default" data-dismiss="modal">청주시</button>
                  <button id="btndetaillocation-184" type="button" class="btn btn-default" data-dismiss="modal">충주시</button>
                  <button id="btndetaillocation-185" type="button" class="btn btn-default" data-dismiss="modal">괴산군</button>
                  <button id="btndetaillocation-186" type="button" class="btn btn-default" data-dismiss="modal">단양군</button>
                  <button id="btndetaillocation-187" type="button" class="btn btn-default" data-dismiss="modal">보은군</button>
                  <button id="btndetaillocation-188" type="button" class="btn btn-default" data-dismiss="modal">연동군</button>
                  <button id="btndetaillocation-189" type="button" class="btn btn-default" data-dismiss="modal">옥천군</button>
                  <button id="btndetaillocation-190" type="button" class="btn btn-default" data-dismiss="modal">음성군</button>
                  <button id="btndetaillocation-191" type="button" class="btn btn-default" data-dismiss="modal">진천군</button>
                  <button id="btndetaillocation-192" type="button" class="btn btn-default" data-dismiss="modal">청원군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">광주</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-193" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-194" type="button" class="btn btn-default" data-dismiss="modal">광산구</button>
                  <button id="btndetaillocation-195" type="button" class="btn btn-default" data-dismiss="modal">남구</button>
                  <button id="btndetaillocation-196" type="button" class="btn btn-default" data-dismiss="modal">동구</button>
                  <button id="btndetaillocation-197" type="button" class="btn btn-default" data-dismiss="modal">북구</button>
                  <button id="btndetaillocation-198" type="button" class="btn btn-default" data-dismiss="modal">서구</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation13" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">전남</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-199" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-200" type="button" class="btn btn-default" data-dismiss="modal">광양시</button>
                  <button id="btndetaillocation-201" type="button" class="btn btn-default" data-dismiss="modal">나주시</button>
                  <button id="btndetaillocation-202" type="button" class="btn btn-default" data-dismiss="modal">목포시</button>
                  <button id="btndetaillocation-203" type="button" class="btn btn-default" data-dismiss="modal">순천시</button>
                  <button id="btndetaillocation-204" type="button" class="btn btn-default" data-dismiss="modal">여수시</button>
                  <button id="btndetaillocation-205" type="button" class="btn btn-default" data-dismiss="modal">여천시</button>
                  <button id="btndetaillocation-206" type="button" class="btn btn-default" data-dismiss="modal">강진군</button>
                  <button id="btndetaillocation-207" type="button" class="btn btn-default" data-dismiss="modal">고흥군</button>
                  <button id="btndetaillocation-208" type="button" class="btn btn-default" data-dismiss="modal">곡성군</button>
                  <button id="btndetaillocation-209" type="button" class="btn btn-default" data-dismiss="modal">구례군</button>
                  <button id="btndetaillocation-210" type="button" class="btn btn-default" data-dismiss="modal">담양군</button>
                  <button id="btndetaillocation-211" type="button" class="btn btn-default" data-dismiss="modal">무안군</button>
                  <button id="btndetaillocation-212" type="button" class="btn btn-default" data-dismiss="modal">보성군</button>
                  <button id="btndetaillocation-213" type="button" class="btn btn-default" data-dismiss="modal">신안군</button>
                  <button id="btndetaillocation-214" type="button" class="btn btn-default" data-dismiss="modal">여천군</button>
                  <button id="btndetaillocation-215" type="button" class="btn btn-default" data-dismiss="modal">영광군</button>
                  <button id="btndetaillocation-216" type="button" class="btn btn-default" data-dismiss="modal">영암군</button>
                  <button id="btndetaillocation-217" type="button" class="btn btn-default" data-dismiss="modal">완도군</button>
                  <button id="btndetaillocation-218" type="button" class="btn btn-default" data-dismiss="modal">장성군</button>
                  <button id="btndetaillocation-219" type="button" class="btn btn-default" data-dismiss="modal">장흥군</button>
                  <button id="btndetaillocation-220" type="button" class="btn btn-default" data-dismiss="modal">진도군</button>
                  <button id="btndetaillocation-221" type="button" class="btn btn-default" data-dismiss="modal">함평군</button>
                  <button id="btndetaillocation-222" type="button" class="btn btn-default" data-dismiss="modal">해남군</button>
                  <button id="btndetaillocation-223" type="button" class="btn btn-default" data-dismiss="modal">화순군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation14" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">울산</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-224" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-225" type="button" class="btn btn-default" data-dismiss="modal">남구</button>
                  <button id="btndetaillocation-226" type="button" class="btn btn-default" data-dismiss="modal">동구</button>
                  <button id="btndetaillocation-227" type="button" class="btn btn-default" data-dismiss="modal">북구</button>
                  <button id="btndetaillocation-228" type="button" class="btn btn-default" data-dismiss="modal">중구</button>
                  <button id="btndetaillocation-229" type="button" class="btn btn-default" data-dismiss="modal">울주군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation15" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">전북</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-230" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-231" type="button" class="btn btn-default" data-dismiss="modal">군산시</button>
                  <button id="btndetaillocation-232" type="button" class="btn btn-default" data-dismiss="modal">김제시</button>
                  <button id="btndetaillocation-233" type="button" class="btn btn-default" data-dismiss="modal">남원시</button>
                  <button id="btndetaillocation-234" type="button" class="btn btn-default" data-dismiss="modal">익산시</button>
                  <button id="btndetaillocation-235" type="button" class="btn btn-default" data-dismiss="modal">전주시</button>
                  <button id="btndetaillocation-236" type="button" class="btn btn-default" data-dismiss="modal">정읍시</button>
                  <button id="btndetaillocation-237" type="button" class="btn btn-default" data-dismiss="modal">고창군</button>
                  <button id="btndetaillocation-238" type="button" class="btn btn-default" data-dismiss="modal">무주군</button>
                  <button id="btndetaillocation-239" type="button" class="btn btn-default" data-dismiss="modal">부안군</button>
                  <button id="btndetaillocation-240" type="button" class="btn btn-default" data-dismiss="modal">순창군</button>
                  <button id="btndetaillocation-241" type="button" class="btn btn-default" data-dismiss="modal">완주군</button>
                  <button id="btndetaillocation-242" type="button" class="btn btn-default" data-dismiss="modal">임실군</button>
                  <button id="btndetaillocation-243" type="button" class="btn btn-default" data-dismiss="modal">장수군</button>
                  <button id="btndetaillocation-244" type="button" class="btn btn-default" data-dismiss="modal">진안군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <div class="location modal fade" id="detaillocation16" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">제주</h4>
                </div>
                <div class="modal-body">
                  <button id="btndetaillocation-245" type="button" class="btn btn-default" data-dismiss="modal">전체</button>
                  <button id="btndetaillocation-246" type="button" class="btn btn-default" data-dismiss="modal">서귀포시</button>
                  <button id="btndetaillocation-247" type="button" class="btn btn-default" data-dismiss="modal">제주시</button>
                  <button id="btndetaillocation-248" type="button" class="btn btn-default" data-dismiss="modal">남제주군</button>
                  <button id="btndetaillocation-249" type="button" class="btn btn-default" data-dismiss="modal">북제주군</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"  data-toggle="modal" data-target="#location">뒤로</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var modalVerticalCenterClass = ".location.modal";
        function centerModals($element) {
            var $modals;
            if ($element.length) {
                $modals = $element;
            } else {
                $modals = $(modalVerticalCenterClass + ':visible');
            }
            $modals.each( function(i) {
                var $clone = $(this).clone().css('display', 'block').appendTo('body');
                var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
                top = top > 0 ? top : 0;
                $clone.remove();
                $(this).find('.modal-content').css("margin-top", top);
            });
        }
        $(modalVerticalCenterClass).on('show.bs.modal', function(e) {
            centerModals($(this));
        });
        $(window).on('resize', centerModals);
        $(document).ready(function(){
            var result;
            var detailresult;
            $('button[id^="btnlocation-"]').click(function(){
                var currentId = $(this).attr('id');
                result = "#" + currentId;
                $("#region").val($(result).text());
            });
            $('button[id^="btndetaillocation-"]').click(function(){
                var currentId = $(this).attr('id');
                detailresult = "#" + currentId;
                $("#address").val($(detailresult).text());
            });

        });
    </script>


    <!--=================================== 지역 검색 핀터레스트 형식 ===================================-->

        <div class="row" style="margin-left:15px;margin-right:15px;">
            <hr style="border-color: lightgrey;">
            <section id="pinBoot">

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("서울")><img src="http://photos.wikimapia.org/p/00/00/26/62/32_big.jpg" alt="">
                    <h4>서울</h4>
                    <p>전통과 현대가 공존하는 도시 서울. 역사 유적, 조선시대 궁궐부터 최신 유행의 쇼핑 타운과 랜드마크까지 화려한 도시 라이프와 고즈넉한 전통의 멋을 취향에 따라 즐겨 보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>190 Houses</p>
                    </div>
                </article>

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("경기")> <img src="http://tong.visitkorea.or.kr/cms/resource/13/565113_image2_1.jpg" alt="">
                    <h4>경기</a></h4>
                    <p>북동부의 산악지역에서 남서쪽 해안지역에 이르는 천혜의 자연조건과 한민족의 정체성을 형성해 온 역사와 문화를 배경으로 경기도는 세계에 자랑하는 풍부한 관광자원을 경험해 보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>101 Houses</p>
                    </div>
                </article>

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("인천")> <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAKAA6QMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAAEBQACAwEGB//EAEIQAAIBAwMCAwUGAwUGBwEAAAECAwAEEQUSIRMxQVFhBhQicYEVMlKRobEjwfAWM0KS0SRDU2JyolZjgpPC0uEH/8QAGgEBAQEBAQEBAAAAAAAAAAAAAAECAwQFBv/EACQRAAICAgICAgMBAQAAAAAAAAABAhEDEhMhMUEEUSIyYaEU/9oADAMBAAIRAxEAPwB3uqbqE6w86nWHnWLOugXuqbvWhOsPOp1vWljUL3VzfQnV9anV9aWNQvfU30J1q51aWNQzfU30GJa71aWTUL31N9CdSu9SrY1Ct9TfQ3Uqb6WNQgtXN9YbjXNxpY1CC9c31huNTdSxqb765urHdU3Usam+6ubqx3VM0smpsXrm+sia5upY1NS1c3Vlurm6ll1Nd1c3VluqbqWNTQtUzWZaubqWTUF6voK71fWlZnH/ABBUFwv4wfrWD00NOqK6JR50sE6/jA+td66eLg/WgoZdQedTqUt94T8YqwnT8YoNRjvFTeKX9dPxV3rr5mg1D99TqUAJge2asJaDUN6ldEh86CEtWEoqWTUL6hq28+dBiYVcTCll1ChIanUofqr51OqKWTUJ31wvQxkHnXOrSxqFb6m/1oTq1OrSxqGb/WpvoQS13q0sahW+oXocSioZB50sam5eq76wMo86qZh50sahO6pvoXrDzrnWFLGoUXrm+hTKKnVHnSxqebw3nVgPMUrFxP5VYXE3nXo0YTQ1XjwrRW+VKVuZvMVotzL6VlxZtUNQ9W6lLBcyeld94fxxWNTfQz6nrVhJSwXDeYq3vDYpqy0MuofOp1D50uFy3jU959alMUhl1DU6ppcLn1qe801FDISnzrvWPnSz3n1rvvVNWShoJj51YS0pF1VluvI4pqShr1Khkpctznxq/Wz401JQb1vWudf1oEytVDKfM01KMet61BP60sMx8zXOsfOmooaif1qwn9aUif1q4n9aUKGJlHnVDN60H1ao0p86agNM48651x50vMtV6tNRQy64qdcUs61TrVaFCcTkeFd9548KCJPnXM16tEeblaDhdeoqG79M0DU4q6InLIMN2fAVBdv4UJlfI1ZZAPCmqHJL2wsXEvnVhNL50L1fSp1WqUdFP+hnUk8TVt70D1WqdVvPFTUvIg8O3nVt5pd1G/FU3nxJqaF5UMOpXepS8TNXes1NGXlQwEld6lLuoT3qBvU00M8iGay4raOfmlG/1NaJJ86aDcdhg9b6hZPZw2srMGFzCJVwp4BJ4+fFA6dkspkPAPCnxr3+tRwtomm28yHJtI2X65rnPonLR89aTGaz6tX1CCS1kKnlc8GlzSnNbUbNrKg7qjzFWWalhlaoJW86aDkQ4SUeYraOGW53dCKSUopZhGpbCjuTjw9aTwysTgV7T2Ls+s180rEJ7m6nHhkijSS7JyI8u745zWZlx41vrFv7rdOqMWj3Hax8RStpMGijfZd0F9b1qdb1oHqVOpTUboC3ipu9aF5rvPia9FI+fswrdU3UMpYnCnmrbyO9KFm+6pmh+p6VoHIKhlI3YxnjOags13Gu7jWch6f3uecAjkHnHFU6wz2/Ohqzfcam4+dYGbHgB55NQSk/dGfPHNShsEZPnXd1YCTjkH6Crg5+eccnFQ1Zruru4VkCDtORtPjuFdGT90En0p0NjTNWBqqxysSFjZjjgAE5oqLStSljMsenXzxDJ6qWsjJgeO7GKlotg+70NFwQ7RvkBPkDTbStCs3uHjvNZsIXjYBsyghfP6jHah9RjtxOyW17A0KE4k39wOx+tZ3TdF7BvenRiE+I4+Eete39qdUScxdB9y2MnuXHiFVcfqGrx2l2NvdalZwi5jZJZkVtp+InI3AfyNPlsVi0nWZb+dI990GQqd21wx3DjnxHpXOdWRoHnmS7hwwGaRXlo8TcDK+Ypgt1pEceFupdxHZYycH1q0OsaSpC3ENxIvY4AH860nRDz5rq8tgd6ZXM2gzMeml4mT8D5XtjxHofzxUN5pEUaiK1ut+AGLMO/jx+da2NmEIEIy3evZ+xmqJb2WqSTAENCIYx/wA7E4/avDyXFs5BQSAZ5yAcU1t4JxoKXkBAj98DZLAD4Ax58c5IrM+0RsvM63gKMRnPFIp0MTlW4x50yurb3e6kFvdW7xq2U/igZUjI70edHbVdPa4Sa1WSL7+6dBxj59+DWl0SzzG6puq99aTWU3TmAB2hlIYEMvmD+dDbvl/mFaLsDZrVEZ8qiFm78eVYiWL8X6U39ndbi0m/F3H7uZF7LdRM0Z+eAf2qznStHGC2fYNDp91cyJFBbvK8j9NFVeWby+dXfSb9Lh7b3Kbrrw0YjbcD6jFep1D2yt71+tNpWmJIG3dWx1AwtnzwQf2pL9uaRcmU3/20GkJz/tKTDkY8kzXBZcj9Hfjx15BjoV8gBuUgtVPjdXUUP/azbvyFZmysY93X1mxLAdrdJpT+ewL+tWdvZtpCyT3sYJ7vYBv1Fx/KrGPRMfwtVgOe/VspVxx6bq0pyfkxrEGUacnPWuJj/wAsAT92NZF7QMOnDKygj77DPb0FGgacP4f2hpbbwRkwTDbx3yY/T9aLubOym+KG40hHyScTdMAkYGMgdu4q7L7LQr+0mReotqMIBnPI+XbjtRerSe56ndW0McbJE5VC6AknA549f9KuNODbo1vdLKuwLKL9MNjPcZ9c570Q2jai8ruUimldeZFuVYk+ec+XGKiolsF1OUwx6aIo4Q72sc7ssYyzlmHfHkKxd92kSTyKpuXv8FymCF2E4+WT+leo/s5E+imWVbz7QjbEdsmxkEYP3Q5J5+lK7vQr+3EaC3ublXUyP0skBj2HK9x498+GKKcW6K4urF2jTst7JJJhttrJs3KCMhTg4x4edLpZHlidGZyp5IycUzGmahGcmxv0Ow5It3xn8u2KHNnKgIliuEypIzCQCfIk9h68/Kt9HPs1109XVLl9u5VEfIXsNi4/XNdjubhtFmshLOYjcoelvOz7r8Y7eVSG1NwJmW5+GG360hcAcjw+9z8/0oNZgFAjmUqe4B8f6/eipl7QdebzpGkjpyBE3rnGBkt2zVtdaSTWbpWTLK+DhcHt3OPTxodRclI3LSFVOFLE4Tt/XHlTC/0jVLKI3dywX4f4n8bL844bxzyOKipOi02vAuspFS6hlZUCrNHuYkDaNwye9OI7box+0MSbTJbuEjVOd6iRssvmMAHPkaCtodwgiSLN7PKBESwCBT5/XnOaIv4NUtVi6/T2Sltjq6kfD6+Hak/2o6TwTxpNiUk9PcV+EEDtWguwIun0IT8X3sHd+/p+9UkRnjLk/ArfdDYwfl9P2qk9oYpEV1YFlDrz4HtXQ4kkkByxUIDyMA9ufzH+lbtdKjOrWkKsHOQQ2RyeO/8AWKySOVkO3eyrhe+cZ7VUhl4IZceHlVpEtmktwZSG2ooUYAVewpqtvLJoN3MYMtaTJvXkmNSh+M/UD88UkDlTkMQfnWizyqm0EhfLwrLhYsP12FbfVJokRZYkACOjZEgIwHyPXkeePWsdLjc3nwo+5YZhGAOQ208DyOaCMjknkjJyee5qhJ3Zyc+eaadULG9rF/D0RngdlWeXqEKcuS4+HzJ4H50Nif8ABdf91AEsRgsxHkTU3P8Ajf8AzGpxv7GwCBniun4TtPerPIGfKR7R5ZqzXMsibJWeRQcgMc+Q79/CuNnSjMnzx9aZaHpk2qTsVhkktYB1Lp4sDpx+LZPFBwz28ckbFGO1st8fcenlRkmtOqXSW2U97BFwxIJcnOT6d+1G2QCMe6VhGVADEDmmVnoGoXcLSQQuQvfA+X+opXHcNG2VwSDn516rTP8A+gajp1n7vBbQjByHJOQc5qXIHl5IZ4zL1I5B0m2yZHCnyPgKosxByH5/6qvdXU11PLNIeZZGlbHA3E5NYiaRTkO+f+o1UDXruf8Aek+m6qbz4hW9SoNRpDIoBBZgfvFiT8qoCB94Zqg1WbH+7j48duP2xREd9LGcKzqAP8Ezr/8AI124n017KFYIJkuEPxsxBVx4+tA5H9GsooyGrXStlLu/U7e/vZPPyx+lFx+0mpx/3eq6ivHH8QEZpGrbcgKp9SM1r1SyEbI+QBkRKMHPnilFsfr7Va3k4169GF43YOfSqtruo3DKZ9RinOORNbRtj05U159Tz/h/y0x0/S72/wBptoFdMcyEDavOMH19MZPgDUot9H0X2Ws1t/Y279oNTjtIVg/i2oEEKNK6ngAKAeSMYPrXE9ohrdqBqOn2qQsS4kWJ4yxA3KQeoc5Ix286X+zXs/bwWrNdQW9w24ESTRA4I/D3z27c+PqARrksiR7VBDSDIwcuw8Pp4/TPPerg+Op5O2ev4eN5cij6E0cWFGopG0ksc+I4c4UgDz7+B/KtY9ft9WuYreX2ZknkySFju+2ASeGTHYH8q3mjYaMIwSSinGTjz454x4+XekX2bepA1zZSTRyDkiN2UvjPHHOe/B8cjvjPTPU2mjr83JbjKI6k1L2Ne0ulfTbu3uudqmOLaGB7BgOBXmrrUYJGiMWm2ipGMc7iT8yCufyoFLq4ADdWRgpZk3EkAsOW58T/ADqscx6gZgp5yQVB5FeXTXwebkcumejsdDkmvIkuhHY+9R9a3YRSsGXwZQrZ70fL7IhpLaKHWrG6jmVgG6uxVxyclh/RoXSNZ1P7U0u5isbq4NnEYIEhjblfjwV44+/ivXeztnqFpBoUWo2a2EdhdvKy3s6oZAwwAqscntXKWSSOyxxPKN7L6xtea3PvYWQFjbyiQ7gCMnHoe/alV3o1zaf39lcKVJyCp5Pia+hMvs/ZCMX98rXUbzMfd4+m7F2ypy21iV7DANYa37QGdzqEdpfm1CIAzBlWTHwkljgMc8djXN5siXR0jjxt/kuj5nMVfZliCg2YwBjHnWTtlY1XZ/Dz2UAtz4n/ABfX5dqP17V5NXuFke2SLYMDpryfmf5Up2eIGPPINeyDlSvo8WRR2/FdGpdnkL4jG7/Dtwoz5DwrH4/+I3+aoVPmtc2n0/Wt2/s51/DrRyRRxysfhfJXBHhUheFQOpG7HeCdrAfDzx+1ENYXE8jOvTJbLYB7Vn7hMThAWIUs2B2A7n5VN0Xjl9GbTFpCR28AQO35VYyMqbt0YJ7KV5I8+2MfWjINDvZv7mNpD3xEpc/pTJfZK/aAu0dwrKcBDAf3NZ5Imlhm/CPOvIWPKofULVdw/CtPV9k9Ubn3d8eZKj+da/2WeNf9ruIbdsZ/iyqP9acsQsExLti6IGxjPJ8SbTxjnv45rKeGSBzHNE0bjwbOa9R9l6XbKrw6lbNMowGM2duRzgD5mhrm3tr2fr32sQPIQF5ye3yFZ5ezbwOu2eejUM6hjgE4PpVpmVn+FQuAFIHjgYz9e9egh+wLZ26p63kyjgH6nms3u9MIKOkhjHbaoBFTl/hf+de5HnwCeBzRDQSmNdsUmwc5K+JHP7U9h1HTrcfwLVt3/mcg/rWt3rEEkMcXusZJ5CqjDP8A3HNZeWV9RNL48KvY82lvM/3Imb0ArSaNowYiGV04aM5GD608uNQntI4mS0tkzgh0Bbae+Cc43djj1FB3GvajcMTLOCxJYsyjJPfmtKc36I4YkvJfQrOD7UhF9BJcW4P8SOM4JHof6HrX0CKIC2drW1dLUsREmD8KkdiO5HA9Wz90D4q8fa3GoTwJJNdAQuSSobZwP2H6+WK9heWMmivc2l3dpMIUjaSRFOxVYbstnw8BGOWIJYkcCJtyMyUaGAiNtpJkl4ZVztJAAUfpjjlu3HG7G4pL25+143umW2txsEIIPDnGSx9cfXmrXtzM9vcWwR9xXayO25lJ43OR3fxx2BxxgAUJexJY2kVpF8ToN0jeAz2X6nk/IV6IOrV9nowZVhxykl2WljC6RJFHICTGQG29zny8fP60TZxxyWyxoT1MDKthT4dhuzjtjPkBkcEZaVdpG1twGdVc4xuH3Djj50r0mV4tWtdmULzIM8eJArkrlF2/1OOXImoKgzUdBsYLSWb3KJpGbMkh3Er6hdo/l9OcBXNgNLht1m01QbqITQylQrFM4z95q9V7Ra5FLq2oxpyxlORx5D8/L+uUXtHcC6j0cQx/3Vj0j3xgOSP3NcoKMnBvxIjlNbfwtqzalp+l6bcC96kd3E0kKh2DKobaQxAH86Nl06LS/avSrO7dp7GaOGS4WTjlxyB8jQ3tL7zJoehK0SosdoY95U43FqN1ixutX9orZHkSMPFHsk+8FCj0rz8kEl9d/wCHdY8kn3/DTRJbW20XrW8FvEqa5FsOMuIiTx+gom71VNR0K5t416mzqqXfsoMspz/XpWNnYadpuizpNK8rR3CsMHarFcgHz8/GhNT1uyl0/wBzRNkJyCsOFz8zznvXk3lklUIvyetY4RVzfZ4RLWWSVkEgKFfurxgCsZtOO74ZMKPxHP8AIU8ur+JI+lawpEuPDv8AnS4TE87c1+hw4tlckfEzZNXSYv8AcfOY1PcV/wCKaY9V8fCoH/pzXOrJ+Ef5P/yvRxQPNyyMf7Q6iw3ItqAB3FnCCPrszUj9qdYhAWG7aMDwT4f2pQYZweYnHzFbpp906lmhKYO34zt3N32jPdsHtXz+NL0e55pPwwyf2k1i4z1r+V8+eP8ASgWv7ps5uZfo5FZ9J1mMZibqA4KY5zV0tZieYG+oxVUV9GN5fZQzynvK5+bGqF2PdifWjrzR72zt1muYBGhxglxzn0zms7zT5rFLc3KGN541ljQ9zGwBVvLB/PjnHGXXojbT7C7C50eGIe/6fcStj7yzYBPyrC+uLCRs2VtJDH5M2ai6dNtSR0kRXzsdl+FvrXbXSZry/t7G1ZGnnfYgY7Rn51n8fs6OUkgJmAPwcj0ptaxaI1kpu766juudyxw5XvxzmldxGkM7IjMwVtuWUA+vGTRun6Pe6oJ2s4dwhjaWQ5xtQdzWn37Oe1FYRpgn/wBokuXiHhHgE/nXpLT+y0i26ia6j6IwDckBCMk4IAORkn50ggtLGKwkurubrSEvFHbRna6ttBWQ57rk4x6UJFbwt/eXHTJ75iP+tYlj28No6RzRT7SPQe0iWckyva6lbSRhfhjR8Kg8lUKFUegpDHC8rgRYZvBQMmnOg6dpk1xtkv4prgPGILZkZUnYuBtZvAedD6bfCyvm1SzuBazEviJYg4VWyNuGBBGDikYtdWV5Iv0MvZzSZ5LuN5bOaaJSWIj5EZwSGYDJY+QxXq/a26vr+WHVYbG8QRxpDBBNAYws4DZlZSMnaOFJHB7YpJY+0Oltf2f2lMJIN3UcwWqxlWYcgkY8hTn7S9nNa9phZyXYhheMKtykpSNSFz4cenzrm4XlTTOylBwodeyfs2LX2Z94lkE1y69acFg25z91c/lWdt7MXlzeXFwdQis2y9whDgnI27Rz2GMj5k0qvNX0LR76HSbPV7iexZ16s4KvEpPpgk4HhWWt+2thps4g0i3t5bfbl2CYLnGN2AQeeODXJ4M0ct3ZveHHqTQoJNR1bU49RkLXCWskm5e6v28e/FE617LT6JpEeppfRySRjBMa72QjnOBnzC+VeZ0u80nUbiQzSe6MY26SRLKSXAyBnkY70xuPaQppkNhMk0TQyAl4SW3KPuqTnkePatpSinfs43tLo8pqV5qTu2ozS46khXd8OWYDnjkj6/St31u/1SG3txAhNumB0YuSPEkCmGrXekax1JFivLa7+EArCJElIGPiHBDY8j4dq20yOJvZe7sZ7GQkXUc4lRApUBWXBznnJHFackorrwKmpde/Iu1a41bU4bJL0tFZ9Bui4Y9Ntqk58vD9aV2uu3lvOsgmkk2rtRZGzgYr6Pbz232Mtnf6Jc3MS7T0ldMlcYyMEYryl17PWnv08C262rRr1OldXaREITxjLHJrOOUGqcTU8c1L9v8ATz13q810iK+Ph7n8XzxWEF1JEQRggDGCTiu6jJm7dAIyqYVemwIIHqOD86HbIRDx8Wf3r1LrweWUm/Ixku3RI5JLd0VwdjEEBvPHnWrX3RijYMMvzsGcgeBPzpXJcXEkMUUs8rxRAiNGclUz3wPD6Vrp6LJK4kaABYnYddyq5C9h6+Q866rLNGHCIcl8Z2wqNIcf4QSanvI8j/lNZ6DeS2eoxvb3osWcFDcFSdikc8AE/lT/AOy7T/xnb/8As3P/ANazL5M0zpD48JKzzpuL66kX4tzY+EBc5/Ktbi+1N4hFcTyBRP1QChHx7dufoAKVLIykEMwI7YJ4qNI5HLsT6msd+zPS8B9nqU1kt4sWwm5AUyOvxLg5yvkayS8mbO+aQ/UUGf65rmKvYGt5f3F3GsM9zLMikbQz8eQ+tCTTTSyJ1pt/TRUXe2cKOyj0oXFTFRKiuV+R3d6/cz2drZsY2tbdAEjx900KmoPGgClVIOQUHNL6h7VnRGlkkujSWVpD8RyPCrW9zLAX6cjqHQowViNynuPl/pWc8MkErRTLtkXuPKqVqkc/JcvjAqFuapUoC6SFSCK68m5mbAGTnis6lC2y4fBq6zFeyr+WaxqUpCzRXKsGAGQc9qIa/nfdyo3YBwoHag813NKFhqajdJJ1FncMOARiunVL1gA1y5C9ue1A5qZpqi7MKF7c7si5lBznIcjnzqG+uyGBu7jDdx1W5/WhQalWiWaSO0hy7s582OaqCO2BVamatFOnvxU9PKuZqUIdNcFcqVAXU4q29vxH86zzUzUpFtn/2Q=="
                        alt="">
                    <h4>인천</h4>
                    <p>서울에서도 멀지 않은 곳에 있는 월미도는 문화의 거리가 조성되어 연극, 이벤트등 즐거운 볼거리와 곳곳에 숨겨진 자연의 아름다움을 찾아 사진속에 담아 보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>64 Houses</p>
                    </div>
                </article>


                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("강원")> <img src="http://www.ktsketch.com/files/attach/images/1994/503/016/7a9989a0ce104fbd55c685a6ba5ed426.jpg" alt="">
                    <h4>강원</h4>
                    <p>강원도 정선과 태백·삼척을 경계 짓는 백두대간 능선 위에 해발 1418m의 금대봉이 있다. 고도는 무척 높지만 산행은 가벼운 트레킹에 가깝다. 산행을 시작하는 두문동재가 해발 1268m 고지여서다. 표고 차가 채 200m가 안 되는 능선을 오르내리는 코스라 초보자도 즐기며 걸어보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>134 Houses</p>
                    </div>
                </article>

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("부산")> <img src="http://chulsa.kr/files/attach/images/67/063/857/002/c784f6c702df8d6349e1a38d31d923e4.jpg" alt="">
                    <h4>부산</h4>
                    <p>천연기념물인 낙동강 하류 철새 도래지, 부산의 상징인 오륙도, 기암괴석이 장관인 태종대, 아름다운 해안인 이기대, 육계도로 동백꽃이 유명한 동백섬 그리고 대한팔경의 하나인 해운대 달맞이언덕 등을 구경해보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>51 Houses</p>
                    </div>
                </article>

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("대전")> <img src="http://cfile9.uf.tistory.com/image/14338C355008646A1AF6AE" alt="">
                    <h4>대전</h4>
                    <p>대전광역시 선정 관광명소는 오월드, 뿌리공원, 엑스포과학공원, 한밭수목원, 계족산황톳길, 대청호반, 장태산휴양림, 대전둘레산길, 동춘당, 대전문화예술단지, 으능정이문화의거리, 유성온천 등 12곳을 즐겨보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>44 Houses</p>
                    </div>
                </article>

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("대구")> <img src="http://cfile209.uf.daum.net/image/20192A4D4FFA2FD018C65E" alt="">
                    <h4>대구</h4>
                    <p>2008년 10월 대구광역시는 '메디시티: 대구'를 선언하고 의료관광산업을 육성하고 있습니다. 대구시는 첨단의료 복합단지를 조성하고 의료기기, 의약품 등 의료산업 전반에 걸친 투자, 기존 관광자원을 개선하여 의료관광 산업을 육성중이며, 2014년 문화체육관광부가 의료관광클러스터 조성 사업지로 지정된 대구광역시를 즐겨보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>71 Houses</p>
                    </div>
                </article>

                <article class="white-panel" style="cursor:pointer" onclick=regionSearch("광주")> <img src="http://cfile24.uf.tistory.com/image/1748474950A2E581139DFF" alt="">
                    <h4>광주</h4>
                    <p>동북아시아의 중신인 한반도의 남서부를 차지하는 호남지방의 중심부에 위치합니다. 예술과 맛이 있는 풍요로운 문화도시인 영원한 빛의 도시 광주광역시를 즐겨보세요.</p>
                    <div class="count-house">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                        <p>84 Houses</p>
                    </div>
                </article>
            </section>
            <hr>
        </div>

</body>

</html>
