<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<style>
*{margin:0;padding:0}
body{background:#FFF;height:100%;width:100%;font-weight:400;margin:0;padding:0;font-size:14px;font-family:'Open Sans',Arial,Helvetica,sans-serif}
</style>
<div style="margin:0 auto;padding:0;">
<header style="background: rgba(80, 164, 47, 0.98);box-shadow: 0 2px 10px -2px rgba(0, 0, 0, 0.41);display: inline-block;line-height: 0;position: relative;width: 100%;z-index: 999;margin-bottom:20px;">
    <div style="width: 1100px;margin:0 auto;">
      <div style="margin: 12px 0;text-align:center;color:#fff;font-size:16px;"> <a href="{{ url('/') }}" target="_blank"><img src="{{ URL::asset('upload/'.getcong('site_logo')) }}" alt="" ></a> </div>      
    </div>
</header>
<div style="width: 1100px;margin:0 auto;">    
<h2 style="color: #565656;font-size: 14px;font-weight: 600;padding:5px 10px;text-align:left;">Hi {{$name}},</h2>
<p style="padding:0 10px;margin: 0 0 10px;line-height:22px;color:#444">Thank you for your order!</p> 
 
<div style="clear:both"></div>        
<div style="float: left;margin:0px 0;padding: 8px 0; width:1100px;">					
	<table height="100%" width="100%">
	  <thead>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Email</th>
		  <td>{{$email}}</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Restaurant</th>
		  <td>{{$restaurant}}</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Menu Name</th>
		  <td>{{$menu_name}}</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Order Description</th>
		  <td>{{$order_des}}</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Delivery Charge ({{$distance}})</th>
		  <td><? if($del_charge=='free') { echo 'free'; } else { echo "&#8377;".$del_charge."/-"; }?></td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Total Price</th>
		  <td>&#8377;{{number_format($price,2)}}/-</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Quantity</th>
		  <td>{{$quantity}}</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Time</th>
		  <td>{{$time}}</td>
		</tr>
		<tr style="border-bottom:1px solid #ccc">                      
		  <th style="width:40%;color:#565656;text-align:left;padding:10px;vertical-align: middle;">Map Link</th>
		  <td>click <a href="{{$link}}" target="_blank">here</a> to know location</td>
		</tr>
		
	  </thead>
	  <div style="clear:both"></div>
	  				  
	</table>
	 	 
  </div>
</div>
<div style="clear:both"></div>
<div style="background:#444;padding: 20px 0;margin-top:30px;text-transform: uppercase;">
<div style="width: 1100px;margin:0 auto;">
  <p style="color: #fff;font-size: 13px;margin: 0;text-align: center;text-transform: none;">Copyright © {{date('Y')}} {{getcong('site_name')}}. All rights reserved.</p>
</div>
</div>
</body>
</html>
 