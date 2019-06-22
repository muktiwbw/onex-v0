<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <style>
        #answer-essay, #answer-checklist{
            display: none;
        }
    </style>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Create Question {{$level->name}}</h1>
    <form action="{{route('admin-question-store')}}" method="POST">
        <div id="case-study-section">
            Studi kasus: 
            <select name="case_study">
                <option value="0">Tidak ada</option>
                @foreach($caseStudies as $caseStudy)
                <option value="{{$caseStudy->id}}">{{$caseStudy->level->name}} - {{$caseStudy->number}}. {{$caseStudy->title}}</option>
                @endforeach
            </select>
            <a href="{{route('admin-case-study-create', ['level_id' => $level->id])}}">Buat Studi Kasus</a>
        </div>
        <div id="question-section">
            <textarea id="question-body" name="question_body" cols="30" rows="10" placeholder="Fill the question body here!"></textarea>
        </div>
        <div>
            <select name="answer_type" id="answer-type-dropdown">
                <option value="MULTIPLE" selected>Multiple Choice</option>
                <option value="ESSAY">Essay</option>
                <option value="CHECKLIST">Checklist</option>
            </select>
        </div>
        <div id="answer-section">
            <div class="answer-type" id="answer-checklist">
                <div><button id="add-checklist">Tambah Checklist</button><button id="remove-checklist">Kurangi Checklist</button></div>
                <div cl-number="1" cl-tail="true"><textarea class="checklist-elems" name="checklist[]" cols="50" rows="1"></textarea> <input type="number" name="cl_correct[]" min="1" max="5"></div>
            </div>
            <div class="answer-type" id="answer-essay">
                <textarea name="essay" cols="30" rows="10" placeholder="Fill the answer for essay here!"></textarea>
            </div>
            <div class="answer-type" id="answer-multiple">
                @php
                $point = 'a';
                @endphp
                @for($i=0;$i<4;$i++)
                <div><input type="radio" name="mc_correct" value="{{$i}}" @if($point == 'a') checked @endif> {{$point}} <textarea name="mc_body[]" cols="30" rows="1"></textarea></div>
                @php
                $point++;
                @endphp
                @endfor
            </div>
        </div>
        <input type="hidden" name="level_id" value="{{$level->id}}">
        @csrf
        <input type="submit" value="Submit">
    </form>
        
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js?cb=1234"></script>
    <script>
        (function(){

            const switchAnswerDropdown = document.getElementById('answer-type-dropdown')
            const answerEssay = document.getElementById('answer-essay')
            const answerMultiple = document.getElementById('answer-multiple')
            const answerChecklist = document.getElementById('answer-checklist')
            const answerTypeSections = document.getElementsByClassName('answer-type')
            const questionBody = document.getElementById('question-body')

            const addChecklist = document.getElementById('add-checklist')
            const removeChecklist = document.getElementById('remove-checklist')
            const options = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };

            CKEDITOR.replace( questionBody, options );

            switchAnswerDropdown.addEventListener('change', function(e){
                e.stopPropagation()
                
                for (let i = 0; i < answerTypeSections.length; i++) {
                    const element = answerTypeSections[i];
                    element.style.display = 'none'
                }

                switch (this.value) {
                    case 'MULTIPLE':
                        answerMultiple.style.display = 'block'
                        break;
                        
                    case 'ESSAY':
                        answerEssay.style.display = 'block'
                        break;
                        
                    case 'CHECKLIST':
                        answerChecklist.style.display = 'block'
                        break;
                        
                }
            })

            addChecklist.addEventListener('click', function(e){
                e.preventDefault()
                e.stopPropagation()

                const clTail = document.querySelector('div[cl-tail="true"]')
                const newNumber = parseInt(clTail.getAttribute('cl-number')) + 1

                clTail.removeAttribute('cl-tail')

                const node = document.createElement('div')
                node.setAttribute('cl-number', newNumber)
                node.setAttribute('cl-tail', "true")
                node.innerHTML = '<textarea class="checklist-elems" name="checklist[]" cols="50" rows="1"></textarea> <input type="number" name="cl_correct[]" min="0" max="5">'
                answerChecklist.appendChild(node)
            })

            removeChecklist.addEventListener('click', function(e){
                e.preventDefault()
                e.stopPropagation()

                const clTail = document.querySelector('div[cl-tail="true"]')
                const newNumber = parseInt(clTail.getAttribute('cl-number')) - 1
                const clNewTail = document.querySelector('div[cl-number="'+newNumber+'"]')

                if(clNewTail){
                    clNewTail.setAttribute('cl-tail', "true")
                    answerChecklist.removeChild(clTail)
                }
            })
        })()
    </script>
</body>
</html>