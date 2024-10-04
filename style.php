
<?php
echo "<style type=\"text/css\"> <!--
      
        body {  font-family: helvetica , Verdana, helvetica, sans-serif; font-size: 10pt; background-color :  ; margin: 0px ;   }
        th   {  font-family: helvetica,Verdana, helvetica, sans-serif; font-size: 10pt; font-weight: bold; background-color: #d5d5d5;}
        td   {  font-family: helvetica,Verdana, helvetica, sans-serif; font-size: 9pt;}

        form   {  font-family: helvetica,Verdana, helvetica, sans-serif; font-size: 10pt}
        select  {  font-family: helvetica,Verdana, helvetica, Helvetica, sans-serif; font-size: 9 pt; }
        h1   {  font-family: helvetica,Verdana, helvetica, Helvetica, sans-serif; font-size: 14pt; font-weight: bold}
        h2   {  font-family: helvetica,Verdana, helvetica, Helvetica, sans-serif; font-size: 11pt; }
		
				
		input[type='submit'] {
			
			background-color:#2b79b5;
			border-radius:3px;
			border:1px solid #1d6297;
			text-decoration:none;
			text-shadow:0px 1px 0px #2b79b5;
			color:white ; 
			padding-left : 14px ;
			padding-right : 14px ;
			font-size: 14px;
			margin-bottom:5px;
		    cursor:pointer;
		}
		
		.abs:link, .abs:visited {
  background-color: #b8daff;
  color: #002752 ;
  border: 1px solid #2b79b5;
  padding: 5px 5px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

.abs:hover, .abs:active {
    background-color: #2b79b5;
  color: white;
}

.abs1:link, .abs1:visited {
  background-color: #B4F98D;
  color: black;
  border: 1px solid #B4F98D ;
  padding: 5px 5px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

.abs1:hover, .abs2:active {
    background-color: #84DC52;
    color: white;
}


.abs2:link, .abs2:visited {
  background-color: #f5949e;
  color: black;
  border: 1px solid red ;
  padding: 5px 5px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

.abs2:hover, .abs2:active {
    background-color: #c82333;
  color: white;
}
		
		table td , table th {
			padding:1px;
		}
		
		.table1 th {
			padding:10px;
			text-transform: uppercase;
			background-color:#55a8ff ; 
		}
		
		.table1 tr:hover {
			background-color: #ecf5ff ;
		}

		.table1 tr:hover td {
			background-color: transparent; /* or #000 */
		}
		
		.table1 {
			width: 100%;
		}



		.table2 th {
			padding-top: 15px; 
			padding-bottom: 15px;
			text-transform: uppercase;
			font-size: 12px;
		}
		
		.table2 tr:nth-child(odd) td{
		padding-top: 5px; 
		padding-bottom: 5px;
				background-color: #f1f1f1;
				font-size: 11px;
		}
		.table2 tr:nth-child(even) td{
		  padding-top: 5px; 
		padding-bottom: 5px;
		   font-size: 11px;
		}
		
		.table2 {
			
			
		}
		
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

	table th  {
			
			text-transform: uppercase;
		}

#link-content {
			
			text-transform: capitalize;
		}
 

.header {
  overflow: hidden;
  
  padding: 0px 20px;
 
}



.header a {
  float: left;
  text-align: center;
  padding: 4px;
  text-decoration: none;

  
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
  margin-top:17px;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}

.red {
	text-transform: uppercase;
	color : #61666d ; 
	padding : 2px ; 
	font-size : 16px ; 
	border-radius:6px; 
	font-family: 'roboto condensed';
}

.red2 {
	text-transform: uppercase;
	color : #61666d ; 
	padding : 5px ; 
	font-size : 16px ; 
	border-radius:6px;
	background-color : #f1f1f1 ; 
}


.wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  grid-gap: 2px;
  margin-top: -32px;
}

.box {
  background-color: #20262e;
  color: #fff;
  border-radius: 2px;
  padding: 8px;
  font-size: 20px;
  text-align : center ; 
}

@keyframes blink { 50% { border-color:#fff ; }  }

.notification {
  color: white;
  text-decoration: none;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification_ {
  color: white;
  text-decoration: none;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification:hover {
}

.notification .badge {
 
 
   position: absolute;
  top: -31px;
  right: 82px;
  background-color: #dc3545;
  padding: 2px 5px;
  border-radius: 50%;
  color: white;
  
}

.notification_ .badge_ {
 position: absolute;
  top: 4px;
  right: -60px;
  background-color: #36be4c;
  padding: 3px 6px;
  border-radius: 50%;
  color: white;
}


.notification .badge2 {
  position: absolute;
  top: -29px;
  right: 73px;
  background-color: orange;
  padding: 2px 5px;
  border-radius: 50%;
  color: black;
}

.notification .badge3 {
  position: absolute;
  top: -29px;
  right: 75px;
  background-color: #009951;
  padding: 2px 5px;
  border-radius: 50%;
  color: white;
}

.notification .badge4 {
  position: absolute;
  top: -29px;
  right: 98px;
  background-color: #009951;
  padding: 2px 5px;
  border-radius: 50%;
  color: white;
}


.badge , .badge2 , .badge3 , .badge4{
	font-size : 12px;
}

#link-content a {
	 
    text-decoration: none;
}

.bouton_ok , #file {
	height : 36px; 
	text-transform: uppercase;
}

.selectStyle {
	height : 30px ; 
}

@font-face {
    font-family: 'Vertexio';
    font-style: normal;
    font-weight: 700;
    src: local('Vertexio'), url('https://fonts.cdnfonts.com/s/78809/Soria-Bold.woff') format('woff');
}

input[type=submit]:hover {
  background-color: #5499ce;
}

input[type=text] , .regexp , .selectStyle {
  border: 1px solid #ccc;
  border-radius: 4px;

}
hr {
border-top: 2px solid #2b79b5 ;
margin-top : -2px;
}

.titrePage {

	color : #ffc107; ; 
	text-decoration: none;
	margin-top: 0px ; background-color : #2b79b5  ; 
	padding : 8px ;
	text-transform: uppercase; 
	font-size : 18px; 
	font-weight:bold ; 
	font-family:'roboto condensed'
}


.titrePage:hover {
	color : #2b79b5; 
	text-decoration: none;
	margin-top: 0px ; background-color : #ffc107  ; 
	padding : 8px ;
	text-transform: uppercase; 
	font-size : 18px; 
	font-weight:bold ; 
}


.titrePage2 {
	
	color : #ffc107; ; 
	text-decoration: none;
	margin-top: 0px ; background-color : #2b79b5  ; 
	padding : 2px ; 
	font-size : 28px;  
	font-family:'roboto condensed';
	text-transform: uppercase;
	letter-spacing: -.03rem;
}
h1 {
	letter-spacing: -0.08rem;
}


.label-file {
    cursor: pointer;
    color: #00b1ca;
    font-weight: bold;
}
.label-file:hover {
    color: #25a5c4;
}

.imgBorder {
	border: 3px solid #2b79b5 ; 
	box-shadow: 10px 5px 5px #2b79b5;
}

.dataTables_info  {
	text-transform: uppercase;
	color : #2b79b5; 
	padding : 5px ; 
	font-size : 20px ; 
	border-radius:6px;
	background-color : #ffc107;
	font-family: 'Vertexio';
	height : 23px ; 
}

        section {
            padding: 60px 0;
           /* min-height: 100vh;*/
        }
 ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
.contact-area {
    border-bottom: 1px solid #353C46;
}

.contact-content p {
    font-size: 15px;
    margin: 30px 0 60px;
    position: relative;
}

.contact-content p::after {
    background: #353C46;
    bottom: -30px;
    content: '';
    height: 1px;
    left: 50%;
    position: absolute;
    transform: translate(-50%);
    width: 80%;
}

.contact-content h6 {
    color: #8b9199;
    font-size: 15px;
    font-weight: 400;
    margin-bottom: 10px;
}

.contact-content span {
    color: #353c47;
    margin: 0 10px;
}

.contact-social {
    margin-top: 30px;
}

.contact-social > ul {
    display: inline-flex;
}

.contact-social ul li a {
    border: 1px solid #8b9199;
    color: #8b9199;
    display: inline-block;
    height: 40px;
    margin: 0 10px;
    padding-top: 7px;
    transition: all 0.4s ease 0s;
    width: 40px;
}

.contact-social ul li a:hover {
    border: 1px solid #FAB702;
    color: #FAB702;
}

.contact-content img {
    max-width: 210px;
}

footer {
	color : white ; 
	padding-top: 0px !important;
	background-image: black !important ;
	opacity : 0.8 ; 
}


#tableaucours thead {
    cursor: pointer;
}


.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {

  visibility: hidden;
  width: 200px;
  background-color: black;
  color: #fff;
  text-align: left;
  border-radius: 6px;
  padding: 3px;
  opacity: 80%;
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  top: 0px;
  right: 50%;
  font-size: 12px;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}




.tooltip2 {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip2 .tooltiptext2 {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: left;
  border-radius: 6px;
  padding: 12px;
  width: 280px;
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  top: 34px;
  left: 50%;
  font-size: 12px;
   opacity: 85%;
}

.tooltip2:hover .tooltiptext2 {
  visibility: visible;
}


.tooltip3 {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip3 .tooltiptext3 {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: left;
  border-radius: 6px;
  padding: 12px;
  width: 200px;
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  top: 0px;
  left: 50%;
  font-size: 12px;
   opacity: 85%;
}

.tooltip3:hover .tooltiptext3 {
  visibility: visible;
}

.container {
  margin-top : 2px ; 
  position: relative;
  background: #28a745;
  color : white ; 
  height: 24px;
  line-height: 26px;
  padding: 2px 0;

}
.marquee {
  height: 24px;
  top: 0;
  width: 100%;
  right: 0;
  position: absolute;
  overflow: hidden;
}
.marquee div {
  display: block;

  white-space: nowrap;
  position: absolute;

  -webkit-animation: marquee 35s linear infinite;
  -moz-animation: marquee 35s linear infinite;
  -ms-animation: marquee 35s linear infinite;
  -o-animation: marquee 35s linear infinite;
  animation: marquee 35s linear infinite;
  
}

.marquee div:hover{
  -webkit-animation-play-state:paused;
  -moz-animation-play-state:paused;
  -o-animation-play-state:paused;
  animation-play-state:paused;
  cursor: pointer;
}


@-webkit-keyframes marquee {
  0% { right: -70%; }
  100% { right: 100%; }
}
@-moz-keyframes marquee {
  0% { right: -70%; }
  100% { right: 100%; }
}
@-ms-keyframes marquee {
  0% { right: -70%; }
  100% { right: 100%; }
}
@-o-keyframes marquee {
  0% { right: -70%; }
  100% { right: 100%; }
}
@keyframes marquee {
  0% { right: -70%; }
  100% { right: 100%; }
}

.msg {
font-family: Vertexio;
font-size : 18px ; 
color : #d72f2f ; 
}


.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  opacity : 0.8 ; 
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 4px 4px 4px 16px;
  text-decoration: none;
  font-size: 12px;
  color: #818181;
  display: block;
  transition: 0.3s;
  color : #ffc107 ; 
  text-transform : capitalize; 
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}


.notification-abs {

padding : 10px ; 
background-color : #ddffdd ; 
color : red ;
font-size : 14px ; 

}

@media only screen and (max-width: 1180px) {
 
 body {
    background-color: lightblue;
  }

 .doughnutChartContainer {
    display: none ; 
 }
}

button.dt-button, div.dt-button, a.dt-button, input.dt-button{
	background-color: red !important; 
	padding : 5px ; 
	font-size : 16px ; 
	text-transform: uppercase;
	color:white;
	font-weight : bold !important; 
    font-family:helvetica !important; 	
}


h3 {
	background-color : #28a745 ; color : white ; width : 100% ; padding : 5px ; 
}
	.header {
		
  font-family: Roboto Condensed;
  text-align: center;
  background-image: linear-gradient(#1e5f80, #1e5f80);
  padding: 5px;
  text-transform: uppercase;
	margin-bottom : 20px ;
}


     --></style> ";
//echo "<LINK REL='SHORTCUT ICON' href='/favicon.ico'>";

?>
