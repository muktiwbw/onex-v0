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
        <form action="{{route('admin-evaluation-store')}}" method="post">
            <div><button id="btn-add">Tambahkan Penilaian Diri</button> - <button id="btn-remove">Kurangi Penilaian Diri</button></div>
            <div id="section-body">
                <div tail="true" eval-number=1>
                    <textarea name="evaluation[]" cols="30" rows="1"></textarea>
                </div>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
            <input type="hidden" name="level_id" value="{{$level->id}}">
            @csrf
        </form>
    </div>
    <script>
        const btnAdd = document.getElementById('btn-add')
        const btnRemove = document.getElementById('btn-remove')
        const sectionBody = document.getElementById('section-body')

        btnAdd.addEventListener('click', function(e){
            e.preventDefault()
            e.stopPropagation()

            const tail = document.querySelector('div[tail="true"]')
            const node = document.createElement('div')

            node.setAttribute('eval-number', parseInt(tail.getAttribute('eval-number')) + 1)
            node.setAttribute('tail', 'true')
            node.innerHTML = '<textarea name="evaluation[]" cols="30" rows="1"></textarea>'
            tail.removeAttribute('tail')

            sectionBody.appendChild(node)
        })

        btnRemove.addEventListener('click', function(e){
            e.preventDefault()
            e.stopPropagation()

            const tail = document.querySelector('div[tail="true"]')

            if(parseInt(tail.getAttribute('eval-number')) == 1) return
            
            document.querySelector('div[eval-number="'+(parseInt(tail.getAttribute('eval-number'))-1)+'"]').setAttribute('tail', 'true')
            
            sectionBody.removeChild(tail)
        })
    </script>
</body>
</html>