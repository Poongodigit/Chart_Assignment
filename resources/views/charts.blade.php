
@extends('layouts')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
       <!-- Fontawesome CSS -->
</head>
<body>
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Final Data</div>
                <div class="card-body">
                        @csrf
                        <div class="mb-3 row">
                            <label for="table" class="col-md-4 col-form-label text-md-end text-start">Table Name</label>
                            <div class="col-md-6">
                                <select id="table" name="table" class="form-control">
                                    <option value="" selected disabled>Select</option>
                                        <?php 
                                            foreach($tableData as $data){ ?>
                                            <option value="<?= $data->ID ?>" ><?= $data->name ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="periodicity"  name="periodicity" class="form-control">
                                    <option value="" selected disabled>Select</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>   
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>
    <div class="container" style="display:none">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading my-2">Chart Demo</div>
                        <div class="col-lg-8">
                            <canvas id="userChart" class="rounded shadow"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <!-- CHARTS -->
        <script>
        var ctx = document.getElementById('userChart').getContext('2d');
        var chart = new Chart(ctx, 
        {
            // The type of chart we want to create
            type: 'bar',
            // The data for our dataset
            data: {
            labels:  {!!json_encode($chart->labels)!!} ,
            datasets: [
                {
                    label: 'Table Data',
                    backgroundColor: {!! json_encode($chart->colours)!!} ,
                    data:  {!! json_encode($chart->dataset)!!} ,
                },
            ]
        },
        });
    </script>
</body>
</html>
@endsection