<?php
	// https://www.roboteach.es/lm-badge?c=rrggbb

	// COLOR
	if ( isset($_GET['c']) ) {
		$R = hexdec(substr($_GET['c'], 0, 2));
		$G = hexdec(substr($_GET['c'], 2, 2));
		$B = hexdec(substr($_GET['c'], 4, 2));
		$badgecolor = 
			str_pad(dechex($R), 2, "0", STR_PAD_LEFT).
			str_pad(dechex($G), 2, "0", STR_PAD_LEFT).
			str_pad(dechex($B), 2, "0", STR_PAD_LEFT);
	}
	else {
		$R = "255";
		$G = "00";
		$B = "255";
		$badgecolor="ff00ff";
	}

	$C = (255 - $R) / 255.0 * 100;
	$M = (255 - $G) / 255.0 * 100;
	$Y = (255 - $B) / 255.0 * 100;
	$X = min(array($C, $M, $Y));
	$C = round($C - $X);
	$M = round($M - $X);
	$Y = round($Y - $X);

	// NAME
	if ( isset($_GET['n']) ) $badgename=$_GET['n'];
	else $badgename="LIGHTMIXER";

	$svg = <<<SVG
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg
	version="1.1"
	width="120mm"
	height="142mm"
	viewBox="0 0 60 71"
	xmlns="http://www.w3.org/2000/svg"
	xmlns:svg="http://www.w3.org/2000/svg">
	<path
		 d="M -2.896285e-7,-6.1218398e-7 H 59.999999 V 70.999996 H -2.896285e-7 Z"
		 style="display:inline;fill:#999187;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0326352"
		 id="background" /><path
		 d="m 29.999596,68.228251 c -5.865183,0 -11.439072,-1.762222 -15.693572,-4.961854 C 12.087556,61.598653 10.326691,59.621726 9.0718102,57.390419 8.3309769,56.072935 7.7836674,54.695238 7.4379452,53.278367 h -0.429381 c -2.5185299,0 -4.5671609,-2.036344 -4.5671609,-4.539363 V 41.50146 c 0,-2.499212 2.0421802,-4.533247 4.5550657,-4.539458 V 8.244362 c 0,-3.0175889 2.4694444,-5.4726172 5.505349,-5.4726172 h 34.964309 c 3.035905,0 5.50535,2.4550283 5.50535,5.4726172 v 28.71764 h 0.02016 c 2.518834,0 4.566961,2.036439 4.566961,4.539458 v 7.237544 c 0,2.503019 -2.048127,4.539363 -4.566961,4.539363 h -0.429381 c -0.345722,1.416771 -0.893031,2.794468 -1.633865,4.112152 -1.254881,2.231006 -3.015746,4.208033 -5.234214,5.875878 -4.2545,3.199632 -9.828389,4.961854 -15.694579,4.961854"
		 style="fill:#efebe6;fill-opacity:1;fill-rule:evenodd;stroke:none;stroke-width:0.100491"
		 id="path1184" /><path
		 d="m 29.999596,66.424751 c -5.472087,0 -10.656913,-1.632377 -14.598952,-4.596566 -2.016881,-1.516459 -3.613453,-3.305732 -4.745366,-5.317925 -1.2236345,-2.175702 -1.8445233,-4.501191 -1.8445233,-6.911936 0,-0.122831 0.00202,-0.245262 0.00605,-0.372202 -0.00403,-0.06743 -0.00605,-0.135255 -0.00605,-0.202682 V 8.244362 c 0,-2.0232143 1.6560393,-3.6692174 3.6910633,-3.6692174 h 34.964309 c 2.035024,0 3.691064,1.6460031 3.691064,3.6692174 v 40.436232 c 0.02117,0.311888 0.03225,0.620369 0.03225,0.91773 0,2.410745 -0.620889,4.736334 -1.844524,6.912036 -1.131913,2.012193 -2.728484,3.801366 -4.745365,5.317825 -3.94204,2.964189 -9.126865,4.596566 -14.59996,4.596566"
		 style="fill:#1a2324;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.100491"
		 id="path1186" /><path
		 d="m 49.889207,49.598424 c 0,2.187424 -0.565453,4.300513 -1.679222,6.281147 -1.043215,1.855297 -2.521858,3.510217 -4.394604,4.917671 -0.607785,0.457462 -1.248833,0.882063 -1.918103,1.271096 -3.414889,1.987747 -7.5565,3.064277 -11.897682,3.064277 -4.340175,0 -8.481786,-1.07653 -11.896675,-3.064277 -0.66927,-0.389033 -1.310317,-0.813634 -1.918103,-1.271096 -1.872746,-1.407454 -3.351389,-3.062374 -4.394603,-4.917671 -1.11377,-1.980634 -1.679222,-4.093723 -1.679222,-6.281147 0,-0.127941 0.002,-0.258487 0.0071,-0.393542 -0.005,-0.05951 -0.0071,-0.120226 -0.0071,-0.181642 v -0.0039 h 39.764103 c 0.0091,0.197171 0.01411,0.390335 0.01411,0.579091"
		 style="fill:#696969;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.100491"
		 id="path1258" /><path
		 d="m 7.0085642,51.474962 c -1.5181529,0 -2.7528752,-1.227314 -2.7528752,-2.735958 V 41.50146 c 0,-1.508645 1.2347223,-2.736059 2.7528752,-2.736059 H 52.991635 c 1.517953,0 2.752675,1.227414 2.752675,2.736059 v 7.237544 c 0,1.508644 -1.234722,2.735958 -2.752675,2.735958 H 7.0085642"
		 style="display:inline;fill:#1a2324;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.100491"
		 id="path1260" /><path
		 d="M 52.991635,39.993216 H 7.0085642 c -0.8384006,0 -1.517649,0.675273 -1.517649,1.508244 v 7.237544 c 0,0.83297 0.6792484,1.508143 1.517649,1.508143 H 52.991635 c 0.838603,0 1.517953,-0.675173 1.517953,-1.508143 V 41.50146 c 0,-0.832971 -0.67935,-1.508244 -1.517953,-1.508244"
		 style="display:inline;fill:#bebebe;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.100491"
		 id="path1262" /><path
		 d="m 41.897278,62.068338 c -3.414889,1.987747 -7.5565,3.064277 -11.897682,3.064277 -4.340175,0 -8.481786,-1.07653 -11.896675,-3.064277 2.954262,-2.301839 7.190619,-3.743557 11.896675,-3.743557 4.707063,0 8.94342,1.441718 11.897682,3.743557"
		 style="display:inline;fill:#919191;fill-opacity:1;fill-rule:evenodd;stroke:none;stroke-width:0.100491"
		 id="path1306" /><g
		 id="ROBOteach"><circle
			 r="2.3148148"
			 cy="62.385185"
			 cx="26.995955"
			 id="path1195"
			 style="fill:#2c2525;fill-opacity:1;stroke:none;stroke-width:0.00323648;stroke-miterlimit:10" /><path
			 d="m 25.751637,61.962717 0.156831,-0.156831 -0.150864,-0.150905 c -0.04313,-0.04309 -0.113704,-0.04309 -0.156831,0 -0.04313,0.04313 -0.04313,0.113704 0,0.156872 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path969" /><path
			 d="m 26.084105,61.630249 0.156872,-0.156873 -0.150905,-0.150863 c -0.04313,-0.04309 -0.113703,-0.04309 -0.156831,0 -0.04313,0.04313 -0.04313,0.113703 0,0.156831 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path973" /><path
			 d="m 26.416656,61.297739 0.156831,-0.141893 -0.150905,-0.136543 c -0.04313,-0.03901 -0.113704,-0.03901 -0.156831,0 -0.04313,0.03905 -0.04313,0.102881 0,0.141934 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path977" /><path
			 d="m 28.240233,62.807695 -0.156872,0.156831 0.150905,0.150905 c 0.04313,0.04309 0.113704,0.04309 0.156831,0 0.04313,-0.04313 0.04313,-0.113703 0,-0.156872 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path981" /><path
			 d="m 27.907723,63.140164 -0.156831,0.156831 0.150905,0.150905 c 0.04313,0.04309 0.113704,0.04309 0.156831,0 0.04313,-0.04313 0.04313,-0.113704 0,-0.156831 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path985" /><path
			 d="m 27.575255,63.472632 -0.156831,0.156872 0.150864,0.150864 c 0.04313,0.04309 0.113703,0.04309 0.156872,0 0.04313,-0.04313 0.04313,-0.113703 0,-0.156831 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path989" /><path
			 d="m 26.265751,63.623537 c -0.04313,0.04313 -0.04313,0.113704 0,0.156831 0.04313,0.04309 0.113703,0.04309 0.156831,0 l 0.150905,-0.150864 -0.156831,-0.156831 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path993" /><path
			 d="m 26.084105,63.140164 -0.150864,0.150905 c -0.04313,0.04313 -0.04313,0.113703 0,0.156831 0.04313,0.04309 0.113704,0.04309 0.156831,0 l 0.150905,-0.150905 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path997" /><path
			 d="m 25.751637,62.807695 -0.150864,0.150864 c -0.04313,0.04317 -0.04313,0.113745 0,0.156872 0.04313,0.04309 0.113703,0.04309 0.156831,0 l 0.150864,-0.150905 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path1001" /><path
			 d="m 27.726119,61.146834 c 0.04317,-0.04313 0.04317,-0.113704 0,-0.156831 -0.04313,-0.04309 -0.113704,-0.04309 -0.156831,0 l -0.150864,0.150864 0.156831,0.156872 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path1005" /><path
			 d="m 27.907723,61.630249 0.150905,-0.150905 c 0.04313,-0.04313 0.04313,-0.113704 0,-0.156831 -0.04313,-0.04309 -0.113703,-0.04309 -0.156831,0 l -0.150905,0.150905 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path1009" /><path
			 d="m 28.240233,61.962717 0.150864,-0.150864 c 0.04313,-0.04317 0.04313,-0.113703 0,-0.156872 -0.04313,-0.04309 -0.113703,-0.04309 -0.156831,0 l -0.150905,0.150905 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path1013" /><path
			 d="m 26.989042,62.866707 c -0.262098,-0.0028 -0.477448,-0.222427 -0.474403,-0.483867 0.0031,-0.268971 0.220206,-0.481975 0.488436,-0.479094 0.262098,0.0028 0.477406,0.222428 0.474443,0.483826 -0.0031,0.269012 -0.220246,0.481975 -0.488476,0.479135 m 0.968023,-0.09292 c -4.08e-4,-0.128889 0,-0.257736 0,-0.386543 0,-0.130246 0,-0.260493 0,-0.39074 0,-0.09173 -0.0644,-0.204156 -0.143909,-0.249958 -0.224527,-0.129259 -0.448806,-0.25893 -0.672962,-0.388847 -0.0793,-0.04593 -0.209012,-0.04597 -0.288312,0 -0.224198,0.129876 -0.4486,0.259629 -0.673127,0.389011 -0.0793,0.04572 -0.144032,0.157901 -0.143909,0.249465 4.08e-4,0.259423 4.08e-4,0.518888 0,0.778353 0,0.09144 0.06461,0.203579 0.143868,0.249217 0.224609,0.129424 0.449094,0.259094 0.673415,0.389012 0.07918,0.04584 0.208723,0.04584 0.2879,0 0.224239,-0.129876 0.448559,-0.259547 0.673127,-0.388888 0.07955,-0.0458 0.144115,-0.158272 0.143909,-0.250082"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path1017" /><path
			 d="m 26.984268,62.082141 c -0.167489,0 -0.30325,0.135802 -0.30325,0.30325 0,0.16749 0.135761,0.303292 0.30325,0.303292 0.16749,0 0.303292,-0.135802 0.303292,-0.303292 0,-0.167448 -0.135802,-0.30325 -0.303292,-0.30325"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0411522"
			 id="path1021" /><path
			 d="m 35.039724,62.859796 c -0.187127,0.384832 -0.458693,0.64679 -0.908942,0.67348 -0.326889,0.01941 -0.579723,-0.168006 -0.645916,-0.488295 -0.01708,-0.08269 -0.02863,-0.170141 -0.02116,-0.253513 0.03358,-0.374544 0.07755,-0.748021 0.111325,-1.122565 0.0077,-0.08463 0.04125,-0.100551 0.117925,-0.09832 0.21702,0.0062 0.434331,0.0034 0.651545,0.0063 0.07609,9.7e-4 0.152089,0.0083 0.23255,0.013 0.02562,-0.228861 0.05057,-0.451801 0.07803,-0.698133 h -0.952715 c 0.07532,-0.355909 0.145295,-0.686971 0.216438,-1.023372 -0.268557,-0.05697 -0.527312,-0.111907 -0.793346,-0.168394 -0.08716,0.385511 -0.171695,0.758988 -0.257881,1.139646 -0.124913,-0.01398 -0.246332,-0.02747 -0.370565,-0.04125 -0.04115,0.234685 -0.08085,0.460731 -0.122098,0.695901 0.132095,0.01456 0.255746,0.02815 0.382697,0.04203 -0.003,0.02329 -0.0045,0.0394 -0.0074,0.05532 -0.09337,0.519063 -0.119186,1.043075 -0.104045,1.568737 0.0133,0.463837 0.232646,0.805188 0.64941,1.01192 0.618061,0.306604 1.505456,0.151797 2.023257,-0.348921 z"
			 style="fill:#f9aa24;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0970573"
			 id="path843" /><path
			 d="m 30.981662,62.467515 h -0.678527 v -1.10393 h 0.678527 c 0.290784,0 0.446949,0.220805 0.446949,0.543909 0,0.323104 -0.156165,0.560021 -0.446949,0.560021 m 0.775488,0.700074 c 0.414532,-0.210032 0.624564,-0.624661 0.624564,-1.22234 0,-0.899333 -0.479269,-1.443145 -1.400052,-1.443145 h -1.647741 v 3.823281 h 0.969214 v -0.996293 h 0.430837 l 0.538474,0.996293 h 1.260095 v -0.861674 h -0.608549 z"
			 style="fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.0970573"
			 id="path855" /></g><text
		 xml:space="preserve"
		 style="font-weight:bold;font-size:9.11539px;line-height:2;font-family:Arial;-inkscape-font-specification:'Arial Bold';text-align:center;text-anchor:middle;fill:#ffffff;stroke:none;stroke-width:0.142428;stroke-linecap:square;paint-order:markers fill stroke"
		 x="29.918768"
		 y="48.350616"
		 id="badgename"
		 transform="scale(1.0030136,0.99699545)"><tspan
			 id="tspan6389"
			 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:9.11539px;font-family:'PT Sans Narrow';-inkscape-font-specification:'PT Sans Narrow Bold';stroke:none;stroke-width:0.142428"
			 x="29.918768"
			 y="48.350616">{BADGENAME}</tspan></text>
	<path
		 id="badgecolor"
		 style="fill:#{BADGECOLOR};fill-opacity:1;stroke-width:0.175412;stroke-linecap:square;paint-order:markers fill stroke"
		 d="M 10.688833,38.751285 V 7.9576915 c 0,-0.776564 0.626573,-1.4017326 1.404882,-1.4017326 h 35.761667 c 0.778309,0 1.405376,0.6251686 1.404882,1.4017326 l -0.0194,30.7935935 z" />
	<rect
		 style="fill:#ffffff;fill-opacity:1;stroke:none;stroke-width:0.305105;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 id="whitebg"
		 width="28"
		 height="3.5"
		 x="16.0"
		 y="55.5" /><text
		 xml:space="preserve"
		 style="font-weight:bold;font-size:3px;line-height:2;font-family:Arial;-inkscape-font-specification:'Arial Bold';fill:#0000ff;fill-opacity:1;stroke:#000000;stroke-width:0.0847331;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 x="39.01334"
		 y="58.45356"
		 id="yellow"
		 transform="scale(1.0030136,0.99699546)"><tspan
			 id="tspan15035"
			 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:3px;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';text-align:center;text-anchor:middle;fill:#ffff00;fill-opacity:1;stroke:#000000;stroke-width:0.0847331;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
			 x="39.01334"
			 y="58.45356">Y:{YELLOW}</tspan></text><text
		 xml:space="preserve"
		 style="font-weight:bold;font-size:3px;line-height:2;font-family:Arial;-inkscape-font-specification:'Arial Bold';fill:#ff00ff;fill-opacity:1;stroke:#000000;stroke-width:0.0848667;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 x="29.852537"
		 y="58.453625"
		 id="magenta"
		 transform="scale(1.0030136,0.99699546)"><tspan
			 id="tspan15027"
			 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:3px;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';text-align:center;text-anchor:middle;fill:#ff00ff;fill-opacity:1;stroke:#000000;stroke-width:0.0848667;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
			 x="29.852537"
			 y="58.453625">M:{MAGENTA}</tspan></text><text
		 xml:space="preserve"
		 style="font-weight:bold;font-size:3px;line-height:2;font-family:Arial;-inkscape-font-specification:'Arial Bold';fill:#ff0020;fill-opacity:1;stroke:#000000;stroke-width:0.0847331;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 x="20.81773"
		 y="58.45356"
		 id="cyan"
		 transform="scale(1.0030136,0.99699546)"><tspan
			 id="tspan15017"
			 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:3px;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';text-align:center;text-anchor:middle;fill:#00ffff;fill-opacity:1;stroke:#000000;stroke-width:0.0847331;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
			 x="20.81773"
			 y="58.45356">C:{CYAN}</tspan></text><rect
		 style="fill:#000000;fill-opacity:1;stroke:none;stroke-width:0.305106;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 id="blackbg"
		 width="28"
		 height="3.5"
		 x="16.0"
		 y="52.0" /><text
		 xml:space="preserve"
		 style="font-weight:bold;font-size:3px;line-height:2;font-family:Arial;-inkscape-font-specification:'Arial Bold';fill:#0000ff;fill-opacity:1;stroke:#ffffff;stroke-width:0.0847331;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 x="38.996704"
		 y="54.943012"
		 id="blue"
		 transform="scale(1.0030136,0.99699546)"><tspan
			 id="tspan14268"
			 style="font-size:3px;text-align:center;text-anchor:middle;fill:#0000ff;fill-opacity:1;stroke:#ffffff;stroke-width:0.0847331;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
			 x="39.412716"
			 y="54.943012"><tspan
	 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';stroke-width:0.0847331"
	 id="tspan22567">B:{BLUE}</tspan> </tspan></text><text
		 xml:space="preserve"
		 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:3px;line-height:2;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';fill:#00ff00;fill-opacity:1;stroke:#ffffff;stroke-width:0.0848667;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 x="30.060053"
		 y="54.943077"
		 id="green"
		 transform="scale(1.0030136,0.99699546)"><tspan
			 id="tspan12690"
			 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:3px;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';text-align:center;text-anchor:middle;fill:#00ff00;fill-opacity:1;stroke:#ffffff;stroke-width:0.0848667;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
			 x="30.060053"
			 y="54.943077">G:{GREEN}</tspan></text><text
		 xml:space="preserve"
		 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:2.56201px;line-height:2;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';fill:#ff0020;fill-opacity:1;stroke:#ffffff;stroke-width:0.0847331;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:markers fill stroke"
		 x="20.816185"
		 y="54.943012"
		 id="red"
		 transform="scale(1.0030136,0.99699546)"><tspan
			 id="tspan2776"
			 style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:2.56201px;font-family:'PT Sans';-inkscape-font-specification:'PT Sans Bold';text-align:center;text-anchor:middle;stroke:#ffffff;stroke-width:0.0847331;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
			 x="21.141439"
			 y="54.943012"><tspan
	 style="font-size:3px;stroke-width:0.0847331"
	 id="tspan11881">R:{RED}</tspan> </tspan></text></svg>
SVG;
	$svg = str_replace("{RED}",$R, $svg);
	$svg = str_replace("{GREEN}",$G, $svg);
	$svg = str_replace("{BLUE}",$B, $svg);
	$svg = str_replace("{CYAN}",$C, $svg);
	$svg = str_replace("{MAGENTA}",$M, $svg);
	$svg = str_replace("{YELLOW}",$Y, $svg);
	$svg = str_replace("{BADGECOLOR}",$badgecolor, $svg);
	$svg = str_replace("{BADGENAME}",$badgename, $svg);

?>
<!doctype html>
<html>
<head>
	<title>ROBOteach light-mixer - Badge generator</title>
	<meta charset=utf-8>
	<style>
		@font-face {
			font-family: 'PT Sans';
			font-style: normal;
			font-weight: 400;
			font-display: swap;
			src: url(fonts/jizaRExUiTo99u79D0KExcOPIDU.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+		2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		@font-face {
			font-family: 'PT Sans';
			font-style: normal;
			font-weight: 700;
			font-display: swap;
			src: url(fonts/jizfRExUiTo99u79B_mh0O6tLR8a8zI.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+		2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		@font-face {
			font-family: 'PT Sans Narrow';
			font-style: normal;
			font-weight: 400;
			font-display: swap;
			src: url(fonts/BngRUXNadjH0qYEzV7ab-oWlsbCGwR2oefDo.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+		2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}
		@font-face {
			font-family: 'PT Sans Narrow';
			font-style: normal;
			font-weight: 700;
			font-display: swap;
			src: url(fonts/BngSUXNadjH0qYEzV7ab-oWlsbg95AiFW_3CRs-2.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+		2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}

		html {
			font-family: 'PT Sans', sans-serif;
			background-color: #999187;
		}
		#badge, #form {
			text-align: center;
		}
	</style> 
</head>
<body>
	<h1 style="text-align: center;"><span style="color: white;">ROBO</span><span style="color: #f9aa24;">teach</span> light-mixer: xerador de insignias</h1>
	<div id="container">
		<div id="badge">
			<?php echo $svg; ?>
		</div>
		<div id="form">
			<form>
				<label><b>Nome</b>:</label>
				<input type="text" name="n" value="<?php if ( isset($_GET['n']) ) echo $_GET['n']; ?>">
				<?php if ( isset($_GET['c']) ) echo '<input type="hidden" name="c" value="'.$_GET['c'].'">'; ?>
				<input type="submit" value="Actualizar">
			</form>
		</div>
	</div>
</body>
</html>
