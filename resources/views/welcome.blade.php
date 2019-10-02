<!DOCTYPE html>
<html>
<head>
  <title>payment</title>
</head>
<body>

  <form action="{{ route('payment') }}"  method="POST">
    @csrf
    @method('POST')
    <input type="submit" value="paynow">
  </form>




</body>
</html>