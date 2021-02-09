<!DOCTYPE html>

<h1>New Submission!</h1>
<h2>Survey Title: {{ $surveyTitle }}</h2>
{{-- <h3>{{ $answers }}</> --}}
@foreach ($answers as $answer)
    <div>
        <h3>Question #{{ $loop->index +1 }}</h3>

        <p>Question Title: {{ $answer->QuestionTitle}}</p>
        <p>User Answer: {{ $answer->Answer == true ? "Yes" : "No"}}</p>
        @if($answer->Note)
            <p>User Note: {{ $answer->Note  }}</p>
        @endif
    </div>
@endforeach

</html>