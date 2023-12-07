<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style>
        .button {
            width: 100%;
            height: 20vh;
            padding: .375em 1.125em;
            font-size: 5rem;
        }

        input[type="radio"]:checked+label {
            border-color: red;
            background: red;
        }

        .button:focus {
            background: red;
        }

        .clicked {
            background-color: #45a049;
            /* Change this to the color you want when the button is clicked */
        }
    </style>

</head>

<body>

    <div class="container-fluid">


        <div class="container-fluid bg-info">

            <h3>
                <h3> {{--- $name->room --}}</h3>
            </h3>




            <form class="font-roboto" method="POST" action="{{ url('/pelajar/room/'.$link->id.'/room_post') }}"
                onsubmit="return confirmSubmit()" enctype="multipart/form-data">

                @csrf

                @php $no=0; @endphp
                @foreach ($quizzes as $row)
                @php $no++; @endphp

                <input type="hidden" value="{{$row->id}}" name="id_quiz[]">

                <nav>
                    <ol class="breadcrumb text-center">

                        <li class="breadcrumb-item">
                            <h1> {!! $row->question !!} </h1>
                        </li>

                    </ol>
                </nav>



                <div class="row">
                    <div class="col-md-4">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary btn-rounded" href="{{ url('/pelajar') }}">Room <span
                                        class="badge badge-secondary rounded">
                                        <h1>{{$name->room}}</h1>
                                    </span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary" href="#">Pertaanyaan <span
                                        class="badge badge-light">
                                        <h1>{!! $row->id !!} </h1>
                                    </span></a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-4">
                        <img alt="Bootstrap Image Preview" src="{{ asset ('quiz/'.$row->image) }}" alt="image"
                            height="200vh" width="400px" />
                    </div>
                    <div class="col-md-4 text-center">
                        <div>
                            <h2>Jawaban Anda</h2>
                        <span
                                        class="badge badge-secondary">
                                        <h1 id="jawabananda"></h1>
                                    </span>
                    
                        </div>
                        <div class="pagination pagination-lg ">
                            <!-- Previous Page Link -->
                            @if ($quizzes->onFirstPage())

                            @else
                            <a class="btn btn-lg btn-danger btn-block" href="{{ $quizzes->previousPageUrl() }}"
                                rel="prev"> &laquo; Sebelumnya</a>
                            @endif

                            <!-- Next Page Link -->
                            @if ($quizzes->hasMorePages())
                            <a class="btn btn-lg btn-danger btn-block" href="{{ $quizzes->nextPageUrl() }}" rel="next"
                                id="nextid">Selanjutnya. &raquo;</a>
                            @else



                            @endif
                        </div>
                        

                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6 col-xs-6" data-toggle="buttons">
                        <label class="button btn btn-primary">
                            <input value="a" {{ old('answer')=="A" ?? "checked" }} name="answer[{{ $row->id }}]"
                                type="radio" id="answer" class="answer-radio"> {{ $row->a }}</label>
                    </div>
                    <div class="col-md-6 col-xs-6" data-toggle="buttons">

                        <label class="button btn btn-danger">
                            <input value="b" {{ old('answer')=="B" ?? "checked" }} name="answer[{{ $row->id }}]"
                                type="radio" id="answer2" class="answer-radio"> {{ $row->b }}</label>
                    </div>

                </div>



                @endforeach


                <br>
                @if ($quizzes->hasMorePages())
                <a class="btn btn-lg btn-danger btn-block" href="{{ $quizzes->nextPageUrl() }}" rel="next"
                                id="nextid">Selanjutnya &raquo;</a>

                @else
                <button type="submit" class="btn btn-lg btn-danger btn-block">
                    Kirim
                </button>
                @endif


        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.answer-radio').on('click', function() {
            var selectedValue = $(this).val();
            console.log('Selected value:', selectedValue);
            $('#jawabananda').text(selectedValue);

            // You can use the selectedValue as needed, for example, send it to the server via AJAX.
        });
    });
</script>



</body>

</html>