<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $infos = Redis::hgetall('cqssc.code:' . date('Ymd'));

        $new_nums = count($infos);
        $old_nums = Redis::get('cqssc.code.num');

        $res = false;
        $info = false;

        if ($old_nums == $new_nums) {

            $get_res  = Redis::get('cqssc.res');
            $get_info = Redis::get('cqssc.info');
            $res      = json_decode($get_res, true);
            $info     = json_decode($get_info, true);
        }

        if (!$res || !$info) {

            Redis::setex('cqssc.code.num', 700, $new_nums);

            foreach ($infos as $k => $v) {
                $res[] = [
                    'number' => $k,
                    'data' => $v,
                ];
            }

            foreach ($res as $k => $v) {
                $num_arr = explode(',', $v['data']);
                $total_num['w'][$k] = $num_arr[0];
                $total_num['q'][$k] = $num_arr[1];
                $total_num['b'][$k] = $num_arr[2];
                $total_num['s'][$k] = $num_arr[3];
                $total_num['g'][$k] = $num_arr[4];
            }

            $zhongjiangqishu = count($res);
            $list = $this->code();
            foreach ($list as $k => $v) {
                $info[$k]['id'] = $v['id'];
                $info[$k]['left'] = $v['left'];
                $info[$k]['right'] = $v['right'];
                $left = explode(',', $v['left']);
                $right = explode(',', $v['right']);

                foreach ($res as $kk => $vv) {
                    $num_arr = explode(',', $vv['data']);
                    $info[$k]['n'][$kk]['w']['num'] = $num_arr[0];
                    $info[$k]['n'][$kk]['q']['num'] = $num_arr[1];
                    $info[$k]['n'][$kk]['b']['num'] = $num_arr[2];
                    $info[$k]['n'][$kk]['s']['num'] = $num_arr[3];
                    $info[$k]['n'][$kk]['g']['num'] = $num_arr[4];
                    foreach ($num_arr as $kkk => $vvv) {
                        if ($kkk == 0) {
                            if (in_array($vvv, $left)) {
                                $info[$k]['n'][$kk]['w']['class'] = 'zuoma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['w'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['w']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['w']['C'] = 'zuoxia';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['w'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['w']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['w']['C'] = 'zuoshang';
                                    }
                                } else {
                                    if (in_array($total_num['w'][($kk + 1)], $left) && in_array($total_num['w'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['w']['C'] = '';
                                    } elseif (in_array($total_num['w'][($kk + 1)], $right) && in_array($total_num['w'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['w']['C'] = 'zuoquan';
                                    } elseif (in_array($total_num['w'][($kk + 1)], $left) && in_array($total_num['w'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['w']['C'] = 'zuoshang';
                                    } else {
                                        $info[$k]['n'][$kk]['w']['C'] = 'zuoxia';
                                    }
                                }
                            } else {
                                $info[$k]['n'][$kk]['w']['class'] = 'youma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['w'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['w']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['w']['C'] = '';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['w'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['w']['C'] = 'youshang';
                                    } else {
                                        $info[$k]['n'][$kk]['w']['C'] = '';
                                    }
                                } else {
                                    if (in_array($total_num['w'][($kk + 1)], $left) && in_array($total_num['w'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['w']['C'] = 'youquan';
                                    } elseif (in_array($total_num['w'][($kk + 1)], $right) && in_array($total_num['w'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['w']['C'] = '';
                                    } elseif (in_array($total_num['w'][($kk + 1)], $left) && in_array($total_num['w'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['w']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['w']['C'] = 'youshang';
                                    }
                                }
                            }
                        } elseif ($kkk == 1) {
                            if (in_array($vvv, $left)) {
                                $info[$k]['n'][$kk]['q']['class'] = 'zuoma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['q'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['q']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['q']['C'] = 'zuoxia';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['q'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['q']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['q']['C'] = 'zuoshang';
                                    }
                                } else {
                                    if (in_array($total_num['q'][($kk + 1)], $left) && in_array($total_num['q'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['q']['C'] = '';
                                    } elseif (in_array($total_num['q'][($kk + 1)], $right) && in_array($total_num['q'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['q']['C'] = 'zuoquan';
                                    } elseif (in_array($total_num['q'][($kk + 1)], $left) && in_array($total_num['q'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['q']['C'] = 'zuoshang';
                                    } else {
                                        $info[$k]['n'][$kk]['q']['C'] = 'zuoxia';
                                    }
                                }
                            } else {
                                $info[$k]['n'][$kk]['q']['class'] = 'youma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['q'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['q']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['q']['C'] = '';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['q'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['q']['C'] = 'youshang';
                                    } else {
                                        $info[$k]['n'][$kk]['q']['C'] = '';
                                    }
                                } else {
                                    if (in_array($total_num['q'][($kk + 1)], $left) && in_array($total_num['q'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['q']['C'] = 'youquan';
                                    } elseif (in_array($total_num['q'][($kk + 1)], $right) && in_array($total_num['q'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['q']['C'] = '';
                                    } elseif (in_array($total_num['q'][($kk + 1)], $left) && in_array($total_num['q'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['q']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['q']['C'] = 'youshang';
                                    }
                                }
                            }
                        } elseif ($kkk == 2) {
                            if (in_array($vvv, $left)) {
                                $info[$k]['n'][$kk]['b']['class'] = 'zuoma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['b'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['b']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['b']['C'] = 'zuoxia';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['b'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['b']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['b']['C'] = 'zuoshang';
                                    }
                                } else {
                                    if (in_array($total_num['b'][($kk + 1)], $left) && in_array($total_num['b'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['b']['C'] = '';
                                    } elseif (in_array($total_num['b'][($kk + 1)], $right) && in_array($total_num['b'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['b']['C'] = 'zuoquan';
                                    } elseif (in_array($total_num['b'][($kk + 1)], $left) && in_array($total_num['b'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['b']['C'] = 'zuoshang';
                                    } else {
                                        $info[$k]['n'][$kk]['b']['C'] = 'zuoxia';
                                    }
                                }
                            } else {
                                $info[$k]['n'][$kk]['b']['class'] = 'youma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['b'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['b']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['b']['C'] = '';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['b'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['b']['C'] = 'youshang';
                                    } else {
                                        $info[$k]['n'][$kk]['b']['C'] = '';
                                    }
                                } else {
                                    if (in_array($total_num['b'][($kk + 1)], $left) && in_array($total_num['b'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['b']['C'] = 'youquan';
                                    } elseif (in_array($total_num['b'][($kk + 1)], $right) && in_array($total_num['b'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['b']['C'] = '';
                                    } elseif (in_array($total_num['b'][($kk + 1)], $left) && in_array($total_num['b'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['b']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['b']['C'] = 'youshang';
                                    }
                                }
                            }
                        } elseif ($kkk == 3) {
                            if (in_array($vvv, $left)) {
                                $info[$k]['n'][$kk]['s']['class'] = 'zuoma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['s'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['s']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['s']['C'] = 'zuoxia';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['s'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['s']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['s']['C'] = 'zuoshang';
                                    }
                                } else {
                                    if (in_array($total_num['s'][($kk + 1)], $left) && in_array($total_num['s'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['s']['C'] = '';
                                    } elseif (in_array($total_num['s'][($kk + 1)], $right) && in_array($total_num['s'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['s']['C'] = 'zuoquan';
                                    } elseif (in_array($total_num['s'][($kk + 1)], $left) && in_array($total_num['s'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['s']['C'] = 'zuoshang';
                                    } else {
                                        $info[$k]['n'][$kk]['s']['C'] = 'zuoxia';
                                    }
                                }
                            } else {
                                $info[$k]['n'][$kk]['s']['class'] = 'youma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['s'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['s']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['s']['C'] = '';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['s'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['s']['C'] = 'youshang';
                                    } else {
                                        $info[$k]['n'][$kk]['s']['C'] = '';
                                    }
                                } else {
                                    if (in_array($total_num['s'][($kk + 1)], $left) && in_array($total_num['s'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['s']['C'] = 'youquan';
                                    } elseif (in_array($total_num['s'][($kk + 1)], $right) && in_array($total_num['s'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['s']['C'] = '';
                                    } elseif (in_array($total_num['s'][($kk + 1)], $left) && in_array($total_num['s'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['s']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['s']['C'] = 'youshang';
                                    }
                                }
                            }
                        } else {
                            if (in_array($vvv, $left)) {
                                $info[$k]['n'][$kk]['g']['class'] = 'zuoma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['g'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['g']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['g']['C'] = 'zuoxia';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['g'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['g']['C'] = '';
                                    } else {
                                        $info[$k]['n'][$kk]['g']['C'] = 'zuoshang';
                                    }
                                } else {
                                    if (in_array($total_num['g'][($kk + 1)], $left) && in_array($total_num['g'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['g']['C'] = '';
                                    } elseif (in_array($total_num['g'][($kk + 1)], $right) && in_array($total_num['g'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['g']['C'] = 'zuoquan';
                                    } elseif (in_array($total_num['g'][($kk + 1)], $left) && in_array($total_num['g'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['g']['C'] = 'zuoshang';
                                    } else {
                                        $info[$k]['n'][$kk]['g']['C'] = 'zuoxia';
                                    }
                                }
                            } else {
                                $info[$k]['n'][$kk]['g']['class'] = 'youma';
                                if ($kk == 0)//第一个
                                {
                                    if (in_array($total_num['g'][($kk + 1)], $left)) {
                                        $info[$k]['n'][$kk]['g']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['g']['C'] = '';
                                    }
                                } elseif ($kk == ($zhongjiangqishu - 1))//最后一个
                                {
                                    if (in_array($total_num['g'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['g']['C'] = 'youshang';
                                    } else {
                                        $info[$k]['n'][$kk]['g']['C'] = '';
                                    }
                                } else {
                                    if (in_array($total_num['g'][($kk + 1)], $left) && in_array($total_num['g'][($kk - 1)], $left)) {
                                        $info[$k]['n'][$kk]['g']['C'] = 'youquan';
                                    } elseif (in_array($total_num['g'][($kk + 1)], $right) && in_array($total_num['g'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['g']['C'] = '';
                                    } elseif (in_array($total_num['g'][($kk + 1)], $left) && in_array($total_num['g'][($kk - 1)], $right)) {
                                        $info[$k]['n'][$kk]['g']['C'] = 'youxia';
                                    } else {
                                        $info[$k]['n'][$kk]['g']['C'] = 'youshang';
                                    }
                                }
                            }
                        }
                    }
                }
            }

            Redis::setex('cqssc.res', 700, json_encode($res));
            Redis::setex('cqssc.info', 700, json_encode($info));
        }

        return view('index', ['info' => $info, 'res' => $res]);
    }

    private function code()
    {
        $code = '[{"id":"1","left":"0,1,2,5,6","right":"3,4,7,8,9","status":"1"},{"id":"2","left":"0,1,2,5,7","right":"3,4,6,8,9","status":"1"},{"id":"3","left":"0,1,2,5,8","right":"3,4,6,7,9","status":"1"},{"id":"4","left":"0,1,2,5,9","right":"3,4,6,7,8","status":"1"},{"id":"5","left":"0,1,2,6,7","right":"3,4,5,8,9","status":"1"},{"id":"6","left":"0,1,2,6,8","right":"3,4,5,7,9","status":"1"},{"id":"7","left":"0,1,2,6,9","right":"3,4,5,7,8","status":"1"},{"id":"8","left":"0,1,2,7,8","right":"3,4,5,6,9","status":"1"},{"id":"9","left":"0,1,2,7,9","right":"3,4,5,6,8","status":"1"},{"id":"10","left":"0,1,2,8,9","right":"3,4,5,6,7","status":"1"},{"id":"11","left":"0,1,3,5,6","right":"2,4,7,8,9","status":"1"},{"id":"12","left":"0,1,3,5,7","right":"2,4,6,8,9","status":"1"},{"id":"13","left":"0,1,3,5,8","right":"2,4,6,7,9","status":"1"},{"id":"14","left":"0,1,3,5,9","right":"2,4,6,7,8","status":"1"},{"id":"15","left":"0,1,3,6,7","right":"2,4,5,8,9","status":"1"},{"id":"16","left":"0,1,3,6,8","right":"2,4,5,7,9","status":"1"},{"id":"17","left":"0,1,3,6,9","right":"2,4,5,7,8","status":"1"},{"id":"18","left":"0,1,3,7,8","right":"2,4,5,6,9","status":"1"},{"id":"19","left":"0,1,3,7,9","right":"2,4,5,6,8","status":"1"},{"id":"20","left":"0,1,3,8,9","right":"2,4,5,6,7","status":"1"},{"id":"21","left":"0,1,4,5,6","right":"2,3,7,8,9","status":"1"},{"id":"22","left":"0,1,4,5,7","right":"2,3,6,8,9","status":"1"},{"id":"23","left":"0,1,4,5,8","right":"2,3,6,7,9","status":"1"},{"id":"24","left":"0,1,4,5,9","right":"2,3,6,7,8","status":"1"},{"id":"25","left":"0,1,4,6,7","right":"2,3,5,8,9","status":"1"},{"id":"26","left":"0,1,4,6,8","right":"2,3,5,7,9","status":"1"},{"id":"27","left":"0,1,4,6,9","right":"2,3,5,7,8","status":"1"},{"id":"28","left":"0,1,4,7,8","right":"2,3,5,6,9","status":"1"},{"id":"29","left":"0,1,4,7,9","right":"2,3,5,6,8","status":"1"},{"id":"30","left":"0,1,5,6,7","right":"2,3,4,8,9","status":"1"},{"id":"31","left":"0,1,5,6,8","right":"2,3,4,7,9","status":"1"},{"id":"32","left":"0,1,5,6,9","right":"2,3,4,7,8","status":"1"},{"id":"33","left":"0,1,5,7,8","right":"2,3,4,6,9","status":"1"},{"id":"34","left":"0,1,5,7,9","right":"2,3,4,6,8","status":"1"},{"id":"35","left":"0,1,5,8,9","right":"2,3,4,6,7","status":"1"},{"id":"36","left":"0,1,6,7,8","right":"2,3,4,5,9","status":"1"},{"id":"37","left":"0,1,6,7,9","right":"2,3,4,5,8","status":"1"},{"id":"38","left":"0,1,7,8,9","right":"2,3,4,5,6","status":"1"},{"id":"39","left":"0,2,5,6,7","right":"1,3,4,8,9","status":"1"},{"id":"40","left":"0,2,5,6,8","right":"1,3,4,7,9","status":"1"},{"id":"41","left":"0,2,5,6,9","right":"1,3,4,7,8","status":"1"},{"id":"42","left":"0,2,5,7,8","right":"1,3,4,6,9","status":"1"},{"id":"43","left":"0,2,5,7,9","right":"1,3,4,6,8","status":"1"},{"id":"44","left":"0,2,5,8,9","right":"1,3,4,6,7","status":"1"},{"id":"45","left":"0,2,6,7,8","right":"1,3,4,5,9","status":"1"},{"id":"46","left":"0,2,6,7,9","right":"1,3,4,5,8","status":"1"},{"id":"47","left":"0,2,6,8,9","right":"1,3,4,5,7","status":"1"},{"id":"48","left":"0,2,3,5,6","right":"1,4,7,8,9","status":"1"},{"id":"49","left":"0,2,3,5,7","right":"1,4,6,8,9","status":"1"},{"id":"50","left":"0,2,3,5,8","right":"1,4,6,7,9","status":"1"},{"id":"51","left":"0,2,3,5,9","right":"1,4,6,7,8","status":"1"},{"id":"52","left":"0,2,3,6,7","right":"1,4,5,8,9","status":"1"},{"id":"53","left":"0,2,3,6,8","right":"1,4,5,7,9","status":"1"},{"id":"54","left":"0,2,3,6,9","right":"1,4,5,7,8","status":"1"},{"id":"55","left":"0,2,3,7,8","right":"1,4,5,6,9","status":"1"},{"id":"56","left":"0,2,3,7,9","right":"1,4,5,6,8","status":"1"},{"id":"57","left":"0,2,3,8,9","right":"1,4,5,6,7","status":"1"},{"id":"58","left":"0,2,4,5,6","right":"1,3,7,8,9","status":"1"},{"id":"59","left":"0,2,4,5,7","right":"1,3,6,8,9","status":"1"},{"id":"60","left":"0,2,4,5,8","right":"1,3,6,7,9","status":"1"},{"id":"61","left":"0,2,4,5,9","right":"1,3,6,7,8","status":"1"},{"id":"62","left":"0,3,5,6,7","right":"1,2,4,8,9","status":"1"},{"id":"63","left":"0,3,5,6,8","right":"1,2,4,7,9","status":"1"},{"id":"64","left":"0,3,5,6,9","right":"1,2,4,7,8","status":"1"},{"id":"65","left":"0,3,6,7,8","right":"1,2,4,5,9","status":"1"},{"id":"66","left":"0,3,6,7,9","right":"1,2,4,5,8","status":"1"},{"id":"67","left":"0,3,7,8,9","right":"1,2,4,5,6","status":"1"},{"id":"68","left":"0,3,4,5,6","right":"1,2,7,8,9","status":"1"},{"id":"69","left":"0,3,4,5,7","right":"1,2,6,8,9","status":"1"},{"id":"70","left":"0,3,4,5,8","right":"1,2,6,7,9","status":"1"},{"id":"71","left":"0,3,4,5,9","right":"1,2,6,7,8","status":"1"},{"id":"72","left":"0,3,4,6,7","right":"1,2,5,8,9","status":"1"},{"id":"73","left":"0,3,4,6,8","right":"1,2,5,7,9","status":"1"},{"id":"74","left":"0,3,4,6,9","right":"1,2,5,7,8","status":"1"},{"id":"75","left":"0,2,4,6,7","right":"1,3,5,8,9","status":"1"},{"id":"76","left":"0,2,4,6,8","right":"1,3,5,7,9","status":"1"},{"id":"78","left":"0,2,4,6,9","right":"1,3,5,7,8","status":"1"},{"id":"79","left":"0,2,4,7,8","right":"1,3,5,6,9","status":"1"},{"id":"80","left":"0,2,4,7,9","right":"1,3,5,6,8","status":"1"},{"id":"81","left":"0,2,7,8,9","right":"1,3,4,5,6","status":"1"},{"id":"82","left":"0,4,5,6,7","right":"1,2,3,8,9","status":"1"},{"id":"83","left":"0,4,5,6,8","right":"1,2,3,7,9","status":"1"},{"id":"84","left":"0,4,5,6,9","right":"1,2,3,7,8","status":"1"},{"id":"85","left":"0,4,6,7,8","right":"1,2,3,5,9","status":"1"},{"id":"86","left":"0,4,6,7,9","right":"1,2,3,5,8","status":"1"},{"id":"87","left":"0,4,7,8,9","right":"1,2,3,5,6","status":"1"},{"id":"88","left":"0,3,4,7,8","right":"1,2,5,6,9","status":"1"},{"id":"89","left":"0,3,4,7,9","right":"1,2,5,6,8","status":"1"},{"id":"90","left":"0,3,4,8,9","right":"1,2,5,6,7","status":"1"},{"id":"91","left":"0,1,4,8,9","right":"2,3,5,6,7","status":"1"},{"id":"92","left":"0,1,6,8,9","right":"2,3,4,5,7","status":"1"},{"id":"93","left":"0,2,4,8,9","right":"1,3,5,6,7","status":"1"},{"id":"94","left":"0,4,6,8,9","right":"1,2,3,5,7","status":"1"},{"id":"95","left":"0,1,2,3,4","right":"5,6,7,8,9","status":"1"},{"id":"96","left":"0,3,5,7,8","right":"1,2,4,6,9","status":"1"},{"id":"97","left":"0,3,5,7,9","right":"1,2,4,6,8","status":"1"},{"id":"98","left":"0,3,5,8,9","right":"1,2,4,6,7","status":"1"},{"id":"99","left":"0,3,6,8,9","right":"1,2,4,5,7","status":"1"}]';
        return json_decode($code, true);
    }

    public function add_code()
    {
        return view('add_code');
    }

    public function add_code_submit(Request $request)
    {
        $number = $request->input('number');
        $w = $request->input('w');
        $q = $request->input('q');
        $b = $request->input('b');
        $s = $request->input('s');
        $g = $request->input('g');

        if (!$this->vefiry_code($w) || !$this->vefiry_code($q) || !$this->vefiry_code($b) || !$this->vefiry_code($s) || !$this->vefiry_code($g)) {
            echo 'Error';exit;
        }

        $date = date('Ymd');
        $key  = 'cqssc.code:' . $date;
        $name = $date . $number;
        $value = $w . ',' . $q . ',' . $b . ',' . $s . ',' . $g;

        $res = Redis::hset($key, $name, $value);

        redirect();
    }

    public function add_ruler()
    {
        return view('add_ruler');
    }

    public function add_ruler_submit(Request $request)
    {
        $z1 = $request->input('z-1');
        $z2 = $request->input('z-2');
        $z3 = $request->input('z-3');
        $z4 = $request->input('z-4');
        $z5 = $request->input('z-5');
        $y1 = $request->input('y-1');
        $y2 = $request->input('y-2');
        $y3 = $request->input('y-3');
        $y4 = $request->input('y-4');
        $y5 = $request->input('y-5');

        if (!$this->vefiry_code($z1) || !$this->vefiry_code($z2) || !$this->vefiry_code($z3) || !$this->vefiry_code($z4) || !$this->vefiry_code($z5) || !$this->vefiry_code($y1) || !$this->vefiry_code($y2) || !$this->vefiry_code($y3) || !$this->vefiry_code($y4) || !$this->vefiry_code($y5)) {
            echo 'Error';exit;
        }

        $arr = [$z1, $z2, $z3, $z4, $z5, $y1, $y2, $y3, $y4, $y5];
        $array = array_unique($arr);
        if (count($array) != 10) {
            echo 'Error';exit;
        }

        if (($z1 + $z2 + $z3 + $z4 + $z5 + $y1 + $y2 + $y3 + $y4 + $y5) != 45) {
            echo 'Error';exit;
        }

        echo 'Success';
    }

    private function vefiry_code($code = '')
    {
        if ($code >= 0 && $code <= 9 && is_numeric($code)) {
            return true;
        }

        return false;
    }
}
