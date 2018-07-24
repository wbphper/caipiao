<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加规则</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}">
</head>
<body>
    <form action="/add_ruler_submit" method="post">
        @csrf
        <div class="add_ruler">
            <div class="add_ruler_l">左码:</div>
            <div class="add_ruler_r">
                <div class="add_ruler_r_l">
                    <input type="text" name="z-1" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="z-2" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="z-3" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="z-4" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="z-5" maxlength="1"/>
                </div>
            </div>
        </div>

        <div class="add_ruler">
            <div class="add_ruler_l">右码:</div>
            <div class="add_ruler_r">
                <div class="add_ruler_r_l">
                    <input type="text" name="y-1" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="y-2" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="y-3" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="y-4" maxlength="1"/>
                </div>
                <div class="add_ruler_r_l">
                    <input type="text" name="y-5" maxlength="1"/>
                </div>
            </div>
        </div>

        <div class="ruler_submit">
            <input type="submit" value="提 交"/>
        </div>
    </form>

</body>
</html>