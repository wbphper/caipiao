<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加中奖号码</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}">
</head>
<body>
    <form action="/add_code_submit" method="post">
        @csrf
        <div class="addcode">
        <div class="addcode-left">
            <div class="addcode-left-l">第</div>
            <div class="addcode-left-m">
                <select name="number" class="addcode-select">
                    <option value="001">1</option>
                    <option value="002">2</option>
                    <option value="003">3</option>
                    <option value="004">4</option>
                    <option value="005">5</option>
                    <option value="006">6</option>
                    <option value="007">7</option>
                    <option value="008">8</option>
                    <option value="009">9</option>
                    <option value="010">10</option>
                    <option value="011">11</option>
                    <option value="012">12</option>
                    <option value="013">13</option>
                    <option value="014">14</option>
                    <option value="015">15</option>
                    <option value="016">16</option>
                    <option value="017">17</option>
                    <option value="018">18</option>
                    <option value="019">19</option>
                    <option value="020">20</option>
                    <option value="021">21</option>
                    <option value="022">22</option>
                    <option value="023">23</option>
                    <option value="024">24</option>
                    <option value="025">25</option>
                    <option value="026">26</option>
                    <option value="027">27</option>
                    <option value="028">28</option>
                    <option value="029">29</option>
                    <option value="030">30</option>
                    <option value="031">31</option>
                    <option value="032">32</option>
                    <option value="033">33</option>
                    <option value="034">34</option>
                    <option value="035">35</option>
                    <option value="036">36</option>
                    <option value="037">37</option>
                    <option value="038">38</option>
                    <option value="039">39</option>
                    <option value="040">40</option>
                    <option value="041">41</option>
                    <option value="042">42</option>
                    <option value="043">43</option>
                    <option value="044">44</option>
                    <option value="045">45</option>
                    <option value="046">46</option>
                    <option value="047">47</option>
                    <option value="048">48</option>
                    <option value="049">49</option>
                    <option value="050">50</option>
                    <option value="051">51</option>
                    <option value="052">52</option>
                    <option value="053">53</option>
                    <option value="054">54</option>
                    <option value="055">55</option>
                    <option value="056">56</option>
                    <option value="057">57</option>
                    <option value="058">58</option>
                    <option value="059">59</option>
                    <option value="060">60</option>
                    <option value="061">61</option>
                    <option value="062">62</option>
                    <option value="063">63</option>
                    <option value="064">64</option>
                    <option value="065">65</option>
                    <option value="066">66</option>
                    <option value="067">67</option>
                    <option value="068">68</option>
                    <option value="069">69</option>
                    <option value="070">70</option>
                    <option value="071">71</option>
                    <option value="072">72</option>
                    <option value="073">73</option>
                    <option value="074">74</option>
                    <option value="075">75</option>
                    <option value="076">76</option>
                    <option value="077">77</option>
                    <option value="078">78</option>
                    <option value="079">79</option>
                    <option value="080">80</option>
                    <option value="081">81</option>
                    <option value="082">82</option>
                    <option value="083">83</option>
                    <option value="084">84</option>
                    <option value="085">85</option>
                    <option value="086">86</option>
                    <option value="087">87</option>
                    <option value="088">88</option>
                    <option value="089">89</option>
                    <option value="090">90</option>
                    <option value="091">91</option>
                    <option value="092">92</option>
                    <option value="093">93</option>
                    <option value="094">94</option>
                    <option value="095">95</option>
                    <option value="096">96</option>
                    <option value="097">97</option>
                    <option value="098">98</option>
                    <option value="099">99</option>
                    <option value="100">100</option>
                    <option value="101">101</option>
                    <option value="102">102</option>
                    <option value="103">103</option>
                    <option value="104">104</option>
                    <option value="105">105</option>
                    <option value="106">106</option>
                    <option value="107">107</option>
                    <option value="108">108</option>
                    <option value="109">109</option>
                    <option value="110">110</option>
                    <option value="111">111</option>
                    <option value="112">112</option>
                    <option value="113">113</option>
                    <option value="114">114</option>
                    <option value="115">115</option>
                    <option value="116">116</option>
                    <option value="117">117</option>
                    <option value="118">118</option>
                    <option value="119">119</option>
                    <option value="120">120</option>
                </select>
            </div>
            <div class="addcode-left-r">期:</div>
        </div>
        <div class="addcode-right">
            <div class="write-code">
                <div class="codes">
                    <input type="text" name="w" maxlength="1"/>
                </div>
                <div class="codes">
                    <input type="text" name="q" maxlength="1"/>
                </div>
                <div class="codes">
                    <input type="text" name="b" maxlength="1"/>
                </div>
                <div class="codes">
                    <input type="text" name="s" maxlength="1"/>
                </div>
                <div class="codes">
                    <input type="text" name="g" maxlength="1"/>
                </div>
            </div>
            <div class="code-submit">
                <input type="submit" value="提 交">
            </div>
        </div>
    </div>
    </form>
</body>
</html>