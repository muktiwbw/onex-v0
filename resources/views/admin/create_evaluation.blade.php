<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Evaluation - {{$level->name}}</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Create Evaluation - {{$level->name}}</h1>
    <div>
        <form action="#" method="post">
            <div><button>Tambahkan Penilaian Diri</button> - <button>Tambahkan Penilaian Diri</button></div>
            <div id="section-body">
                <textarea name="evaluation[]" cols="30" rows="1"></textarea>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
            <input type="hidden" name="level_id" value="{{$level->id}}">
            @csrf
        </form>
    </div>
</body>
</html>