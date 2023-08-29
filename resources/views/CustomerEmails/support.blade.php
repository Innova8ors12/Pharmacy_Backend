<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
   <h4>Name:  <span style="opacity:0.7">{{ $support['name'] }}</span> </h4>
 <h4>Email:  <span style="opacity:0.7">{{ $support['email'] }}</span> </h4>
 <h4>Phone:  <span style="opacity:0.7">{{ $support['phone'] }}</span> </h4>
 <h4>Prescription Name:  <span style="opacity:0.7">{{ $support['prescription'] }}</span> </h4>
 @if( $support['pharmacy'] != '')
  <h4>Pharmacy Name:  <span style="opacity:0.7">{{ $support['pharmacy'] }}</span> </h4>
 @endif
 <h4>Message:  <span style="opacity:0.7">{{ $support['message'] }}</span> </h4>
 <h4>Category:  <span style="opacity:0.7">{{ $support['category'] }}</span> </h4>
</body>
</html>

       