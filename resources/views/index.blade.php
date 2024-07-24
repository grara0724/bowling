<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body>
    <form action="{{ route('calc')}}" method="POST">
        @csrf
        <div class="container flex mx-auto justify-center items-center mt-20">
            <table class="border-collapse border border-slate-600 ...">
                <thead>
                    <tr>
                        @for($i = 1; $i <= 9; $i++) <th colspan="2" class="border border-slate-300 ... w-16 h-8">{{ $i }}</th>
                            @endfor
                            <th colspan="3" class="border border-slate-300 ...  w-16 h-8">10</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @for($i = 0; $i < 21; $i++) <th colspan="1" class="border border-slate-300 ... w-16 h-8">
                            <select name="throw-score[]">
                                @for($n = 0; $n <= 10 ; $n++) @if(isset($throw_scores[$i]) && $throw_scores[$i]==$n) <option value="{{$n}}" selected>{{$n}}</option>
                                    @else
                                    <option value="{{$n}}">{{$n}}</option>
                                    @endif
                                    @endfor
                            </select>
                            </th>
                            @endfor
                    </tr>
                    <tr>
                        @isset($total_scores)
                        @foreach($total_scores as $index => $score)
                        @if($loop->iteration == 10)
                        <th colspan="3" class="border border-slate-300 ...">{{ $score }}</th>
                        @else
                        <th colspan="2" class="border border-slate-300 ...">{{ $score }}</th>
                        @endif
                        @endforeach
                        @endisset
                    </tr>
                </tbody>
            </table>
            <div class="flex flex-col">
                <input type="submit" class="ml-20 bg-sky-500 h-10 px-10 rounded-md shadow-md hover:bg-sky-700  duration-300 text-white font-bold" value="計算">
                <input type="button" class="ml-20 mt-3 bg-red-500 h-10 px-10 rounded-md shadow-md hover:bg-red-700  duration-300 text-white font-bold" onclick="location.href='./'" value="リセット">
            </div>
        </div>
    </form>

    </div>
</body>

</html>