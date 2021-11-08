<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{ route('Location.creat') }}" method="post">
    @csrf
    <label for="name">نام مکان</label>
<input type="text" id="name" name="name"><br>

<button type="submit">ارسال</button>
</form>
</body>
</html>
