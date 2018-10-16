<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>

<script src="">


</script>

</head>

<body>

<? echo $_SERVER['REQUEST_METHOD']; ?>


<form action="deneme.php?id=100" method="post" name="form1" id="form1">
  <input type="submit" name="submit" id="submit" value="Submit">
    <input type="checkbox" style="color: #00ff00;">
    <div>
        deneme deneme
    </div>
</form>

<? echo str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) ; ?>

</body>
</html>