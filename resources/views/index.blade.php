<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>走势图</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}">
</head>
<body>

<div class="hovers">
    <div class="hovers-line">
        <a href="/add_ruler">添 加 规 则</a>
    </div>
    <div class="hovers-line">
        <a href="/add_code">添 加 号 码</a>
    </div>
</div>

<div class="content">
    <div class="list_t">

        <div class="l_t_t">
            <div class="qihao">期号</div>
            <div class="qihao">开奖号码</div>
        </div>

        @foreach ($res as $k => $v)
            <div class="l_t_c">
                <div class="qh_show">
                    <div class="qh_show_n">{{$v['number']}}</div>
                    <div class="qh_show_c">{{$v['data']}}</div>
                </div>
            </div>
        @endforeach

        <div class="l_t_t">
            <div class="qihao">期号</div>
            <div class="qihao">开奖号码</div>
        </div>

    </div>

    @foreach ($info as $k => $v)

        <div class="list">
            <div class="l_title">
                <div class="zymshow">{{$v['id']}}、左码:{{$v['left']}}&nbsp;&nbsp;右码:{{$v['right']}}</div>
                <div class="gsbqw">
                    <div class="gsbqw_l">万位</div>
                    <div class="gsbqw_l">千位</div>
                    <div class="gsbqw_l">百位</div>
                    <div class="gsbqw_l">十位</div>
                    <div class="gsbqw_l">个位</div>
                </div>
            </div>

            @foreach ($v['n'] as $kk => $vv)

                <div class="l_number">
                    <div class="l_number_s {{$vv['w']['C']}}">
                        <div class="{{$vv['w']['class']}}">{{$vv['w']['num']}}</div>
                    </div>
                    <div class="l_number_s {{$vv['q']['C']}}">
                        <div class="{{$vv['q']['class']}}">{{$vv['q']['num']}}</div>
                    </div>
                    <div class="l_number_s {{$vv['b']['C']}}">
                        <div class="{{$vv['b']['class']}}">{{$vv['b']['num']}}</div>
                    </div>
                    <div class="l_number_s {{$vv['s']['C']}}">
                        <div class="{{$vv['s']['class']}}">{{$vv['s']['num']}}</div>
                    </div>
                    <div class="l_number_s {{$vv['g']['C']}}">
                        <div class="{{$vv['g']['class']}}">{{$vv['g']['num']}}</div>
                    </div>
                </div>

            @endforeach

            <div class="l_title">
                <div class="gsbqw">
                    <div class="gsbqw_l">万位</div>
                    <div class="gsbqw_l">千位</div>
                    <div class="gsbqw_l">百位</div>
                    <div class="gsbqw_l">十位</div>
                    <div class="gsbqw_l">个位</div>
                </div>
                <div class="zymshow">{{$v['id']}}、左码:{{$v['left']}}&nbsp;&nbsp;右码:{{$v['right']}}</div>
            </div>

        </div>

    @endforeach

</div>

</body>
</html>