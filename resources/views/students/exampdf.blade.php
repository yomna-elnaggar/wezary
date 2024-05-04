<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{$title}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td {
            background-color: #fff;
            color: #333;
        }

        h1,
        h2 {
            text-align: center;
        }

        /* Style for the logo */
        .logo {
            width: 100px; /* Adjust the width as needed */
            height: auto;
            float: left;
            margin-right: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <img src="{{ URL::to('assets/img/logo2.png') }}" alt="Your Logo" class="logo">
    <p>{{ $date }}</p>
    <h1>تقرير عن امتحانات الطالب</h1>

    <h2>{{ $student->name }}</h2>
    <br />
    <br />

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الدرجة</th>
                            <th>الكورس</th>
                            <th>المعلم</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $items)
                        <tr>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->grade }}</td>
                            <td>{{ $items->course_name }}</td>
                            <td>{{ $items->teacher->name }}</td>
                            <td>{{ $items->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
