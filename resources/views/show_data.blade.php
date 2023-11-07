@extends('layouts')

@section('content')

<style>
#chartStyle {
  margin: auto;
  width: 100%;
  padding: 65px;
}
</style>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Register</div>
                <div class="card-body">
                <form action="{{ route('show_data') }}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Tables Name</label>
                        <div class="col-md-6">
                            <select id="table" name="table" class="form-control" required>
                                <option value="" selected disabled>Select</option>
                                    <?php 
                                        foreach($tableData as $data){ ?>
                                        <option value="<?= $data->name ?>" <?php if($tableName == $data->name) {echo "selected";}?>  ><?= $data->name ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Periodicity</label>
                        <div class="col-md-6">
                            <select  id="periodicity"  name="periodicity" class="form-control" required>
                                <option value="" selected disabled>Select</option>
                                <option value="daily" <?php if($period == "daily") {echo "selected";}?> >Daily</option>
                                <option value="weekly" <?php if($period == "weekly") {echo "selected";}?>>Weekly</option>   
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Submit">
                    </div>
                </form>
                </div>
            </div>
        </div>    
    </div>
</div>

<br> </br>
<?php if($showChart == 1) { ?>
<div class="container" id="chartStyle">
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-8">
                <canvas id="userChart" class="rounded shadow"></canvas>
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
</div>


<meta name="description" content="Bootstrap.">  
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>  
<body style="margin:20px auto"> 
<div class="container">
<table id="finalTable" class="table table-striped">
    <script>
        $('#finalTable').dataTable();
    </script>
    <thead>
        <tr>
            <?php foreach($tableHeaders as $head){ 
                if($head !== 'created_at' && $head !== 'updated_at') { ?>
                <th style = "background-color: plum;"><?php echo $head; ?></th>
                <?php } ?>
            <?php } ?>                     
        </tr>
    </thead> 
    <tbody>
        <?php $i = 0; foreach($tableRowValues as $data) { ?>
            <tr>
                <td> <?php echo $data->ID; ?> </td>
                <td> <?php echo $data->MainsRCurr; ?> </td>
                <td> <?php echo $data->MainsPosKWh; ?> </td>
                <td> <?php echo $data->DailyMainsPosKWh; ?> </td>
                <td> <?php echo $data->Timestamp; ?> </td>                         
                <td> <?php echo $data->from_unixtime; ?> </td>
                <td> <?php echo $data->date; ?> </td>
                <td> <?php echo $data->week; ?> </td>
                <td> <?php echo $data->diff; ?> </td>
            </tr>
        <?php $i++; } ?>
    </tbody>          
</table>

<?php } ?>


    
@endsection