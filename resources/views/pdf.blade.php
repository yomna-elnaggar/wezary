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
    <h1>تقرير عن طلاب المعلم</h1>

    <h2>{{ $teacher->name }}</h2>
    <br />
    <br />

    <div class="tab-content">
        <!-- Students Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">الطلاب</h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>كود الطالب</th>
                                            <th>الاسم</th>
                                            <th>هاتف الوالد</th>
                                            <th>رقم الهاتف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allUsers as $user)
                                        <tr>
                                            <td>{{ $user->special_code }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->parent_phone }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Students Info Tab -->
    </div>
</body>

</html>
